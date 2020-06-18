<?php

namespace App\Command;

use App\Factory\RedisConnectionFactory;
use App\Service\AdvertisementService;
use App\Util\KeyGenerator;
use App\Value\CreateAdvertisement;
use App\Value\Customer;
use App\Value\Info;
use App\Value\Location;
use Faker\Factory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class InitializeCommand extends Command
{
    protected static $defaultName = 'app:initialize';

    /**
     * @var \App\Factory\RedisConnectionFactory
     */
    private $connectionFactory;

    /**
     * @var \App\Util\KeyGenerator
     */
    private $keyGenerator;

    /**
     * @var \Redis
     */
    private $redis;

    /**
     * @var \App\Service\AdvertisementService
     */
    private $advertisementService;

    public function __construct(
        RedisConnectionFactory $connectionFactory,
        KeyGenerator $keyGenerator,
        AdvertisementService $advertisementService
    )
    {
        parent::__construct();
        $this->connectionFactory = $connectionFactory;
        $this->keyGenerator = $keyGenerator;
        $this->redis = $connectionFactory->getRedis();
        $this->advertisementService = $advertisementService;
    }

    protected function configure()
    {
        $this
            ->setDescription('Initialises the default application data in Redis')
            ->addArgument('count', InputArgument::OPTIONAL, 'Number of advertisements to generate', 100);
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $pattern = $this->keyGenerator->getPrefixKeyPattern();
        $keys = $this->redis->keys($pattern);

        if (!empty($keys)) {
            $io->note(sprintf('Found %d key/keys', count($keys)));
            $io->note('Proceeding to removal.');

            $progressBar = new ProgressBar($output, count($keys));
            $progressBar->start();

            foreach ($keys as $key) {

                $this->redis->del($key);

                $progressBar->advance();
            }

            $progressBar->finish();
        }

        $count = intval($input->getArgument('count'));

        if (!is_int($count)) {
            $io->error("Valid integer needed.");

            return Command::FAILURE;
        }

        $io->writeln("");
        $io->writeln("Creating fresh data.");
        $faker = Factory::create();

        while ($count > 0) {
            $customer = Customer::generate();
            $location = new Location($faker->latitude,   $faker->longitude);
            $info = new Info($faker->text(25), $faker->text(150), $faker->image());
            $createAdvertisement = new CreateAdvertisement($info, $location, $customer);

            $this->advertisementService->create($createAdvertisement);

            $count--;
        }

        $io->success('Done.');

        return Command::SUCCESS;
    }
}

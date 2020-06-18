<?php

namespace App\EventSubscriber;

use App\Security\User;
use App\Value\Customer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class RemainingHitsSubscriber extends GenericApiLimit implements EventSubscriberInterface
{
    public function onKernelResponse(ResponseEvent $event)
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            return;
        }

        $customer = new Customer($user->getId());

        $event->getResponse()->headers->add(
            [
                'X-API-Hits-Remaining' => $this->limiterService->getHits($customer, self::EVERY_MINUTE, self::MAX_HITS_PER_MINUTE),
            ]
        );
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.response' => 'onKernelResponse',
        ];
    }
}

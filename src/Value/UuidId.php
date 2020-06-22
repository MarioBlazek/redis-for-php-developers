<?php

declare(strict_types=1);

namespace App\Value;

use Ramsey\Uuid\Uuid;

abstract class UuidId
{
    /**
     * @var string
     */
    private $string;

    public function __construct($string)
    {
        $this->string = (string) $string;
    }

    public function __toString()
    {
        return $this->string;
    }

    /**
     * @param string $string
     *
     * @return static
     */
    public static function fromString($string)
    {
        return new static($string);
    }

    /**
     * @return static
     */
    public static function generate()
    {
        return static::fromString(Uuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->string;
    }
}

<?php

declare(strict_types=1);

namespace App\Util;

use DateTimeZone;

final class TimeUtil
{
    public function getMinuteOfTheDay(): int
    {
        $date1 = $this->getDate();
        $date2 = $this->getDate();

        $date2->setTime(0, 0);

        $diff = $date1->diff($date2);

        return $diff->h * 60 + $diff->i;
    }

    private function getDate(): \DateTimeImmutable
    {
        return new \DateTimeImmutable('now', new DateTimeZone('UTC'));
    }
}

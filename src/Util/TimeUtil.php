<?php

namespace App\Util;

use DateTime;
use DateTimeZone;

final class TimeUtil
{
    public function getMinuteOfTheDay(): int
    {
        $date1 = $this->getDate();
        $date2 = $this->getDate();

        $date2->setTime(0, 0);

        $diff = $date1->diff($date2);

        $minutes = $diff->h * 60 + $diff->i;

        return $minutes;
    }

    private function getDate(): DateTime
    {
        return new DateTime('now', new DateTimeZone('UTC'));
    }
}

<?php

namespace BusinessDaysFrance;

class PeriodStatistics
{
    /**
     * @var int Number of days in the period
     */
    public $days = 0;

    /**
     * @var int Number of open days in the period ("jours ouvrés")
     */
    public $openDays = 0;

    /**
     * @var int Number of openable days in the period ("jours ouvrables")
     */
    public $openableDays = 0;

    /**
     * @var int Number of holidays days in the period
     */
    public $holidayDays = 0;

    /**
     * @var int Number of weekend days in the period
     */
    public $weekendDays = 0;
}

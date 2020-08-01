<?php

namespace BusinessDaysFrance;

class Period
{
    protected $begin;
    protected $end;
    protected $holidays;

    protected $statistics;

    /**
     * Period constructor.
     *
     * @param string $period A string representing the period for which to compute statistics (ex: "2020-01" for January of 2020, "2020" for whole of 2020)
     */
    public function __construct($period, Holidays $holidays)
    {
        if (preg_match('/^[0-9]{4}-[0-9]{2}$/', $period)) {
            $this->begin = new \DateTime('first day of '.$period);
            $this->end = new \DateTime('last day of '.$period);
        } elseif (preg_match('/^[0-9]{4}$/', $period)) {
            $this->begin = new \DateTime($period.'-01-01');
            $this->end = new \DateTime($period.'-12-31');
        } else {
            throw new \Exception('Invalid period given '.$period.', should be YYYY-MM or YYYY');
        }

        $this->holidays = $holidays;

        $this->compute();
    }

    protected function compute()
    {
        $this->statistics = new PeriodStatistics();

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($this->begin, $interval, $this->end->modify('+1 day'));

        foreach ($period as $dt) {
            $this->statistics->days += 1;

            $holiday = $this->holidays->isHoliday($dt);
            $weekend = $this->isWeekendDay($dt);
            $closing = $this->isClosingDay($dt);


            if ($holiday) {
                $this->statistics->holidayDays += 1;
            }
            if ($weekend) {
                $this->statistics->weekendDays += 1;
            }
            if (!$closing && !$holiday) {
                $this->statistics->openableDays += 1;
            }
            if (!$weekend && !$holiday) {
                $this->statistics->openDays += 1;
            }
        }

        //var_dump($this->statistics);
    }

    /**
     * Returns true if the given date is a weekend day
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    protected function isWeekendDay(\DateTime $date): bool
    {
        $weekDay = (int)$date->format('N');
        if ($weekDay === 6 || $weekDay === 7) {
            return true;
        }

        return false;
    }

    /**
     * Returns true if the given date is a closing day
     *
     * In general in France the closing day is sunday. This method should be overridden for other cases
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    protected function isClosingDay(\DateTime $date): bool
    {
        $weekDay = (int)$date->format('N');

        if ($weekDay === 7) {
            return true;
        }

        return false;
    }

    /**
     * Returns statistics about the period
     *
     * @return PeriodStatistics
     */
    public function getStatistics(): PeriodStatistics
    {
        return $this->statistics;
    }
}

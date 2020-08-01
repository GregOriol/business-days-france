<?php

namespace BusinessDaysFrance;

class Holidays
{
    protected $data = array();

    /**
     * Holidays constructor.
     *
     * @param string $dataUrl URL or path of the holidays json data
     *
     * @throws \Exception
     */
    public function __construct($dataUrl)
    {
        $data = file_get_contents($dataUrl);
        if ($data === false) {
            throw new \Exception('Could not read holidays data at '.$dataUrl);
        }

        $decodedData = json_decode($data, true);
        if ($decodedData === null) {
            throw new \Exception('Could not decode holidays json at '.$dataUrl);
        }

        $this->data = $decodedData;
    }

    /**
     * Returns true if the given date is a holiday according to the data
     *
     * @param \DateTime $date
     *
     * @return bool
     */
    public function isHoliday(\DateTime $date): bool
    {
        $key = $date->format('Y-m-d');

        return array_key_exists($key, $this->data);
    }
}

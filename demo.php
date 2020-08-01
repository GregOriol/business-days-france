<?php

//
// This file show a way of using the classes of this project
//
// In this demo, the classes are "required" to show how each one could be loaded manually,
// but it is recommended to use autoloading (with composer, ...)
//

//
// Checking holidays
//

require_once 'src/BusinessDaysFrance/Holidays.php';

$holidaysDataUrl = 'https://raw.githubusercontent.com/etalab/jours-feries-france-data/master/data/json/metropole.json';

// Use the following lines (or any better implementation) to cache the json data instead of downloading it each time
//$cachedHolidaysDataPath = 'holidays.json';
//if (!file_exists($cachedHolidaysDataPath)) {
//    $holidaysContents = file_get_contents($holidaysDataUrl);
//    file_put_contents($cachedHolidaysDataPath, $holidaysContents);
//}
//$holidaysDataUrl = $cachedHolidaysDataPath;

$holidays = new \BusinessDaysFrance\Holidays($holidaysDataUrl);

var_dump($holidays->isHoliday(new \DateTime('2020-01-01'))); // => true
var_dump($holidays->isHoliday(new \DateTime('2020-01-02'))); // => false

//
// Getting period statistics
//

require_once 'src/BusinessDaysFrance/PeriodStatistics.php';
require_once 'src/BusinessDaysFrance/Period.php';

$period = new \BusinessDaysFrance\Period('2020-01', $holidays);
var_dump($period->getStatistics());
//  => object(BusinessDaysFrance\PeriodStatistics)#5 (5) {
//    ["days"] => int(31)
//    ["openDays"] => int(22)
//    ["openableDays"] => int(26)
//    ["holidayDays"] => int(1)
//    ["weekendDays"] => int(8)
//  }

$period = new \BusinessDaysFrance\Period('2020', $holidays);
var_dump($period->getStatistics());
//  => object(BusinessDaysFrance\PeriodStatistics)#5 (5) {
//    ["days"] => int(366)
//    ["openDays"] => int(253)
//    ["openableDays"] => int(304)
//    ["holidayDays"] => int(11)
//    ["weekendDays"] => int(104)
//  }

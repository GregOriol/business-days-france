# business-days-france
PHP 7.0+ classes to compute calendar business days/holidays in France

The project is devided in two classes:
* Holidays: which manages the holidays data provided by the french opendata
* Period: which computes statistics about a given period (number of days, holidays, open days, openable days, weekend days)

A demo.php file provides examples on how to use them.

The main use case is to get the number of open days ("jours ouvrés") for a give month.

The holidays data is based on:
https://github.com/etalab/jours-feries-france-data

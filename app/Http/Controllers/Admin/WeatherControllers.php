<?php


namespace App\Http\Controllers\Admin;

use App\Libraries\WeatherLibraries;

class WeatherControllers
{
    public $WeatherLibraries;

    public function __construct(WeatherLibraries $WeatherLibraries)
    {
        $this->WeatherLibraries = $WeatherLibraries;
    }

    public function dateFormat($date){
        $date = new DateTime($date);
        $year = $date->format('Y');  // ได้ปี
        $month = $date->format('m'); // ได้เดือน
        $day = $date->format('d');   // ได้วัน

        return "ปี: $year, เดือน: $month, วัน: $day";
    }

    public function index(){
        $weather = $this->WeatherLibraries->getWeatherAPI();
        $weather['WeatherForecasts'][0]['forecasts'][0]['data']['cond'] = $this->WeatherLibraries->weatherCondition($weather['WeatherForecasts'][0]['forecasts'][0]['data']['cond']);
        return $weather['WeatherForecasts'][0]['forecasts'][0]['data'];
    }
}

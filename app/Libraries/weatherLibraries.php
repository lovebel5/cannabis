<?php

namespace App\Libraries;

use Exception;

class WeatherLibraries
{
    public function getWeatherAPI()
    {
        $date = date('Y-m-d');
        $URL = 'https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/at?lat=7.903917&lon=98.3793580&fields=tc_max,tc_min,rh,cond&date='.$date.'&duration=1';
        try {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $URL,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTPHEADER => array(
                    "accept: application/json",
                    "authorization: Bearer " . env('WEATHER_API_TOKEN'), // ใช้จาก .env
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                throw new Exception("cURL Error: " . $err);
            }

            return json_decode($response, true);

        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

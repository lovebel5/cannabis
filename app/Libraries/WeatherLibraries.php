<?php

namespace App\Libraries;

use Exception;

class WeatherLibraries
{

    public function weatherCondition($key){
        $weather = [
            1 => "ท้องฟ้าแจ่มใส (Clear)",
            2  => "มีเมฆบางส่วน (Partly cloudy)",
            3  => "เมฆเป็นส่วนมาก (Cloudy)",
            4  => "มีเมฆมาก (Overcast)",
            5  => "ฝนตกเล็กน้อย (Light rain)",
            6  => "ฝนปานกลาง (Moderate rain)",
            7  => "ฝนตกหนัก (Heavy rain)",
            8  => "ฝนฟ้าคะนอง (Thunderstorm)",
            9  => "อากาศหนาวจัด (Very cold)",
            10  => "อากาศหนาว (Cold)",
            11  => "อากาศเย็น (Cool)",
            12  => "อากาศร้อนจัด (Very hot)",
        ];
        return $weather[$key];
    }

    public function getWeatherAPI()
    {
        $date = date('Y-m-d');
//        $URL = 'https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/at?lat=7.903917&lon=98.3793580&fields=tc_max,tc_min,rh,cond&date='.$date.'&duration=1';
        $URL = 'https://data.tmd.go.th/nwpapi/v1/forecast/location/daily/place?province=ภูเก็ต&amphoe=เมืองภูเก็ต&amphoe=เมืองภูเก็ต&tambon=ตลาดใหญ่&fields=tc_max,tc_min,rh,cond&date='.$date.'&duration=1';
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

<?php


namespace App\Http\Controllers\Admin;


class VariableControllers
{
    public function getVariable($key){
        switch ($key) {
            case "var":
                return $this->variable();
                break;
            case "head":
                return $this->projectLeader();
                break;
             case "soil":
                return $this->soilType();
                break;
             case "status":
                return $this->status();
                break;
             case "building":
                return $this->building();
                break;
            default:
                return false;
        }
    }

    public function variable(){
        $var = [
            'input' => [
                'experiment_name'	=>	'experiment_name',
                'trial_code'	    =>	'trial_code',
                'objective'	        =>	'objective',
                'expert'	        =>	'expert',
                'coworker'	        =>	'coworker',
                'research_center'	=>	'research_center',
                'year'	            =>	'year',
                'address_land'	    =>	'address_land',
                'coordinates'	    =>	'coordinates',
                'sloping_area'	    =>	'sloping_area',
                'soil_preparation'	=>	'soil_preparation',
                'direction'     	=>	'direction',
                'plow'	            =>	'plow',
                'trial_plan'	    =>	'trial_plan',
                'planting'	        =>	'planting',
                'planting_date'	    =>	'planting_date',
                'germination_date'	=>	'germination_date',
                'how_to_plant'	    =>	'how_to_plant',
                'planting_rate'	    =>	'planting_rate',
                'varieties_used'	=>	'varieties_used',
                'seed_preparation'	=>	'seed_preparation',
                'repair_day'	    =>	'repair_day',
                'harvest_day'	    =>	'harvest_day',
                'sandy_loam'	    =>	'sandy_loam',
                'hclay_loam'	    =>	'hclay_loam',
                'soil_type'	        =>	'soil_type',
                'sandy_clay_loam'	=>	'sandy_clay_loam',
                'mold'	            =>	'mold',
                'other'	            =>	'other',
                'note'	            =>	'note',
                'status'	        =>	'status',
                'number_plants'	        =>	'number_plants',

            ],
            'name' => [
                'experiment_name'       => 'ชื่อโรงเรือน',
                'trial_code'            => 'รหัสการทดลอง',
                'objective'             => 'วัตถุประสงค์',
                'expert'                => 'หัวหน้าโรงเรือน',
                'coworker'              => 'เจ้าหน้าที่ประจำโรงเรือน',
                'research_center'       => 'Co-Partner',
                'year'                  => 'ฤดู-ปี',
                'address_land'          => 'สถานที่',
                'coordinates'           => 'พิกัด',
                'sloping_area'          => 'พื้นที่',
                'direction'             => 'ทิศทาง',
                'soil_preparation'      => 'การเตรียมดิน',
                'plow'                  => 'ไถแปร',
                'trial_plan'            => 'แผนการทดลอง',
                'planting'              => 'การปลูก',
                'planting_date'         => 'วันที่ปลูก',
                'germination_date'      => 'วันที่งอก',
                'how_to_plant'          => 'วิธีการปลูก',
                'planting_rate'         => 'อัตราปลูก',
                'varieties_used'        => 'พันธุ์ที่ใช้',
                'seed_preparation'      => 'การเตรียมเมล็ดพันธุ์',
                'repair_day'            => 'วันปลูกซ่อมหรือถอดแยก',
                'harvest_day'           => 'วันเก็บเกี่ยว',
                'sandy_loam'            => 'ดินร่วนปนทราย',
                'hclay_loam'            => 'ดินร่วนเหนียว',
                'soil_type'             => 'ประเภทดิน',
                'sandy_clay_loam'       => 'ดินร่วนเหนียวปนทราย',
                'mold'                  => 'ดินร่วน',
                'other'                 => 'อื่นๆ',
                'note'                  => 'Note',
                'status'	            =>	'สถานะ',
                'building'	            =>	'โรงเรือน',
                'number_plants'	            =>	'จำนวนต้น'
            ]

        ];
        return $var;
    }

    public function projectLeader(){
        return $name = [
          0 => 'นายมนตรี พรผล',
          1 => 'นางสาววรรดี เพชรชู',
//           2 => 'นายราก ใบสวย',
        ];

    }

    public function soilType(){
        return $soilType = [
            0  => 'ดินร่วนปนทราย',
            1  => 'ดินร่วนเหนียว',
            2  => 'ดินร่วนเหนียวปนทราย',
            3  => 'ดินร่วน',
            4  => 'อื่นๆ',
        ];
    }

    public function status(){
        return $status = [
            0 => 'ยกเลิก',
            1 => 'ปกติ',
            2 => 'จำหน่าย',
            3 => 'ล้มตาย',
        ];
    }

    public function building(){
        return $building = [
            0 => "NurseryRoom",
            1 => "a",
            2 => "b",
            3 => "c",
            4 => "d",
            5 => "e",
            6 => "f",
            7 => "g",
            8 => "h",
            9 => "i",
            10 => "j",
            11 => "k",
            12 => "l",
            13 => "m",
            14 => "n",
            15 => "o",
            16 => "p",
            17 => "q",
            18 => "r",
            19 => "s",
            20 => "t",
            21 => "u",
            22 => "v",
            23 => "w",
            24 => "x",
            25 => "y",
            26 => "z",
            27 => "flower-1",
            28 => "flower-2",
            // 29 => "Nursery Room",
            // 30 => "null",
        ];
    }
}

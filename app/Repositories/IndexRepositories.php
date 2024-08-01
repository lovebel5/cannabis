<?php

namespace App\Repositories;

use App\Models\BasicInformationModel;
use DB;

class IndexRepositories
{
    public function save($data)
    {
        $members = new BasicInformationModel($data);
        // บันทึกข้อมูลลงฐานข้อมูล
        $saveSuccessful = $members->save();

        // รับ ID ของบันทึกที่สร้างใหม่
        $newMemberId = $members->id;
        return [
            'saveSuccessful' => $saveSuccessful,
            'id' => $newMemberId
        ];
    }

    public function disableBasicInformation($id){
        return DB::table('basic_information')
            ->where('id', $id)
            ->update([
                'display' => 0
            ]);
    }

    public function getBasicInformationTableByKey($key)
    {
        return DB::table('basic_information')
            ->where([
                'key' => $key,
                'display' => 1,
            ])
            ->orderBy('display', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get()->toArray();
    }
    public function getDataById($id)
    {
        // ค้นหาข้อมูลที่ต้องการทำซ้ำ
        return  DB::table('basic_information')
            ->find($id);
    }
    // ฟังก์ชันที่ใช้ในการทำซ้ำข้อมูลตามจำนวนที่ต้องการ
    public function duplicate($data,$num)

    {
        $array = json_decode(json_encode($data), true);
        unset($array['id']);

        for ($i = 1; $i < $num; $i++) {
            DB::table('basic_information')->insert($array);
        }
    }
}

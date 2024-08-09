<?php


namespace App\Repositories;

use App\Models\EventModels;
use DB;


class EventRepositories
{
    public function save($data)
    {
        $members = new EventModels($data);
        return $members->save();
    }
    public function getAllEventByInfoId($id)
    {
        return DB::table('event')
            ->where('id_basic_info', $id)
            ->orderBy('id', 'DESC')
            ->get()
            ->toArray();
    }

    public function getEventByInfoId($id)
    {
        return DB::table('event')
            ->where('id_basic_info', $id)
            ->get()
            ->first();
    }

    public function saveAppend($id,$data)
    {

        return DB::table('event')
            ->where('id_basic_info', $id) // เปลี่ยนตามเงื่อนไขที่คุณต้องการ
            ->update([
                'val_json' => DB::raw("JSON_ARRAY_APPEND(val_json, '$', CAST('$data' AS JSON))"),
            ]);
    }

    public function getEventAll()
    {
        return DB::table('event')
            ->get()
            ->toArray();
    }
}

<?php


namespace App\Repositories;

use App\Models\ImageModels;
use DB;

class ProfileRepositories
{
    public function save($data)
    {
        $members = new ImageModels($data);
        return $members->save();
    }

    public function getBasicInformationById($id)
    {
        return DB::table('basic_information')
            ->where('id', $id)
            ->where('key', 'basic_information')
            ->get()
            ->first();
    }

    public function getBuildingInfoByKey($buildingKey)
    {
        return DB::table('basic_information')
            ->where('key', 'building_info')
            ->where('value->building', $buildingKey)
//            ->where('value->id_basic_info', $buildingKey)
            ->orderBy('value->date', 'DESC')
            ->get()
            ->first();
    }

    public function getBuildingInfoByIdBasicInfo($buildingKey)
    {
        return DB::table('basic_information')
            ->where('key', 'building_info')
            ->where('value->id_basic_info', $buildingKey)
            ->orderBy('value->date', 'DESC')
            ->get()
            ->first();
    }

    public function getBuildingInfoByKeyArray($buildingKey, $idBasicInfo)
    {
        return DB::table('basic_information')
            ->where('key', 'building_info')
//            ->where('value->building', $buildingKey)
            ->where('value->id_basic_info', $idBasicInfo)
            ->orderBy('value->date', 'DESC')
            ->get()
            ->toArray();
    }

    public function updateBasicInformationById($id, $data)
    {
        return DB::table('basic_information')
            ->where('id', $id)
            ->update([
                'value' => $data
            ]);
    }

    public function updateBasicInformationNoteOnlyById($id, $data)
    {
        return DB::table('basic_information')
            ->where('id', $id)
            ->update([
                'value->note' => $data
            ]);
    }

    public function getBuildingByDateFormDateTo($building_key, $dateForm, $dateTo)
    {
        return DB::table('building')
            ->where('building', $building_key)
            ->where('date', '>', $dateForm)
            ->where('date', '<=', $dateTo)
//             ->whereBetween('date', [$dateForm, $dateTo])
            ->orderBy('date', 'ASC')
            ->get()
            ->toArray();
    }




}

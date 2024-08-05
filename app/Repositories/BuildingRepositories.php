<?php


namespace App\Repositories;
use App\Models\BuildingModels;
use DB;

class BuildingRepositories
{
    public function save($data)
    {
        $members = new BuildingModels($data);
        return $members->save();
    }

    public function getDataBuildingByBuildingKey($building_Key){
        return DB::table('building')
            ->where([
                'building' => $building_Key,
            ])
            ->orderBy('date', 'DESC')
            ->get()->toArray();
    }

    public function getFirstBuildingByBuildingKey($building_Key){
        return DB::table('building')
            ->where([
                'building' => $building_Key,
            ])
            ->orderBy('date', 'DESC')
            ->get()
            ->first();
    }

    public function getDataBuildingEachDayById($id){
        return DB::table('building')
            ->where([
                'id' => $id,
            ])
            ->get()->first();
    }

    public function checkDateDuplicateByDataAndBuildingKey($date, $building_Key)
    {
        return DB::table('building')
            ->where([
                'date' => $date,
                'building' => $building_Key,
            ])
            ->get()
            ->first();
    }

    public function upDateBuildingById($id,$data)
    {

        return DB::table('building')
            ->where('id', $id)
            ->update((
                $data
            ));
    }

}

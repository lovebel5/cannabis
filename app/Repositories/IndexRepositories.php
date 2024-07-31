<?php

namespace App\Repositories;

use App\Models\BasicInformationModel;
use DB;

class IndexRepositories
{
    public function save($data)
    {
        $members = new BasicInformationModel($data);
        return $members->save();
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
}

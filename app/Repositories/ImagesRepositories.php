<?php


namespace App\Repositories;


use App\Models\ImageModels;
use DB;
//use http\Env\Request;

class ImagesRepositories
{
    public function save($data)
    {
        $members = new ImageModels($data);

       if($members->save()){
           return true;
       };
    }

    public function updateTitleAndContentImgByID($id, $data)
    {
        return DB::table('images')
            ->where('id', $id)
            ->update([
                'content' => $data
            ]);
    }

    public function getImageByIDBasicInfo($id)
    {
        return DB::table('images')
            ->where([
                'id_basic_info' => $id,
            ])
            ->orderBy('display', 'DESC')
            ->orderBy('updated_at', 'DESC')
            ->get()->toArray();
    }

    public function delImgById($id)
    {
        return DB::table('images')
            ->where([
                'id' => $id,
            ])
            ->delete();
    }

    public function getImgById($id)
    {
        return DB::table('images')
            ->where([
                'id' => $id,
            ])
            ->get()->first();
    }


}

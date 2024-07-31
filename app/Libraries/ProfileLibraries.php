<?php


namespace App\Libraries;


use App\Repositories\ProfileRepositories;
use App\Repositories\BuildingRepositories;
use App\Repositories\IndexRepositories;

class ProfileLibraries
{
    public $IndexRepositories;
    public function __construct(ProfileRepositories $ProfileRepositories,
                                BuildingRepositories $BuildingRepositories,
                                IndexRepositories $IndexRepositories)
    {
        $this->ProfileRepositories = $ProfileRepositories;
        $this->BuildingRepositories = $BuildingRepositories;
        $this->IndexRepositories = $IndexRepositories;
    }

    public function getBasicInformationById($id){
        if (is_numeric($id)){
            $basicInformation = $this->ProfileRepositories->getBasicInformationById($id);

            if($basicInformation === null){
                return false;
            } else {
                return $basicInformation;
            }
        } else {
            return false;
        }
    }

    public function upLoadImage($request){

        if($request->file('image')){
            $file = $request->file('image');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file-> move(public_path('public/image'), $filename);
          //  $data['image']= $filename;
        }
        //$data->save();
        return redirect()->route('images.view');

    }

    public function getDataBuildingAndThenSaveInBuildingInfo($buildingKey,$idBasicInfo){
      $firstBuildingInfo =  $this->ProfileRepositories->getBuildingInfoByKey($buildingKey);
      $firstBuildingInfoById =  $this->ProfileRepositories->getBuildingInfoByIdBasicInfo($idBasicInfo);
      $getBuildingByKey = $this->BuildingRepositories->getDataBuildingByBuildingKey($buildingKey);
      $firstBuilding = $this->BuildingRepositories->getFirstBuildingByBuildingKey($buildingKey);
//        dd($firstBuildingInfoById);
        if($firstBuildingInfoById != null){
            $buildingInfoById = json_decode($firstBuildingInfoById->value,true);
        }


//      dd($firstBuilding->date,$buildingInfoById['date'],$buildingKey);

      if($firstBuildingInfo === null && $getBuildingByKey === null) {
          return false;
          exit();
      } elseif ($firstBuildingInfo === null) {
//        dd($getBuildingByKey[$key]->date);
          foreach ($getBuildingByKey as $key => $value){
              if($firstBuildingInfoById === null || $buildingInfoById['date'] < $getBuildingByKey[$key]->date){
                  $getBuilding[] = json_decode($getBuildingByKey[$key]->value, true);
                  $getBuilding[$key]['date'] = $getBuildingByKey[$key]->date;
                  $getBuilding[$key]['building'] = $getBuildingByKey[$key]->building;
                  $getBuilding[$key]['id_basic_info'] = $idBasicInfo;
                  $setNewDataBuilding[$key] = json_encode($getBuilding[$key]);

                  $data = [
                      'key' => 'building_info',
                      'value' => $setNewDataBuilding[$key],
                      'display' => 1,
                      'status' => 1
                  ];
                  $this->IndexRepositories->save($data);
              }
          }
      } else {

          $buildingInfo = json_decode($firstBuildingInfo->value, true);
          $rowBuilding = $this->ProfileRepositories->getBuildingByDateFormDateTo($buildingInfo['building'], $buildingInfo['date'], $firstBuilding->date);

          if($firstBuilding->date != $buildingInfo['date']){
              foreach ($rowBuilding as $key => $value){
                  $getBuilding[] = json_decode($rowBuilding[$key]->value, true);
                  $getBuilding[$key]['date'] = $rowBuilding[$key]->date;
                  $getBuilding[$key]['building'] = $rowBuilding[$key]->building;
                  $getBuilding[$key]['id_basic_info'] = $idBasicInfo;
                  $setNewDataBuilding[$key] = json_encode($getBuilding[$key]);

                  $data = [
                      'key' => 'building_info',
                      'value' => $setNewDataBuilding[$key],
                      'display' => 1,
                      'status' => 1
                  ];

                  $this->IndexRepositories->save($data);

              }
          }
      }
      return true;
    }




}

<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\BuildingRepositories;
use function Symfony\Component\Translation\t;

class BuildingControllers
{
    public $VariableControllers;
    public $BuildingRepositories;

    public function __construct(VariableControllers $VariableControllers, BuildingRepositories $BuildingRepositories)
    {
        $this->VariableControllers = $VariableControllers;
        $this->BuildingRepositories = $BuildingRepositories;
    }

    public function index(){
        $var['var'] = $this->VariableControllers->getVariable('var');
        $var['building'] = $this->VariableControllers->getVariable('building');

        return view('admin.building',[
            'var' => $var,
        ]);
    }

    public function getDataBuildingById($id_building)
    {
        $var['var'] = $this->VariableControllers->getVariable('var');
        $var['building'] = $this->VariableControllers->getVariable('building');
        $row_building = $this->BuildingRepositories->getDataBuildingByBuildingKey($id_building);
        $row_first = $this->BuildingRepositories->getFirstBuildingByBuildingKey($id_building);

        ($row_first === null) ? $data = false : $data = json_decode($row_first->value,true);
//        dd($row_building);
        return view('admin.building_indoor',[
            'var' => $var,
            'id_building' => $id_building,
            'row' => $row_building,
            'data' => $data,
        ]);
    }

    public function insertDataBuildingEachDay(Request $input)
    {
        $request = $input->get('form');
        $date = date($request['date']);
        $building = $request['building'];

        if($this->BuildingRepositories->checkDateDuplicateByDataAndBuildingKey($date,$building)){
            return back()
                ->with('warning', 'danger')
                ->with('message', 'Error : วันที่ดังกล่าวมีข้อมูลแล้ว');
        }

        unset($request['date'],$request['building']);

        if(!isset($request['expert'],$request['coworker'])){
            return back()
                ->with('warning', 'danger')
                ->with('message', 'Error : "หัวหน้าโรงเรือน, เจ้าหน้าที่ประจำโรงเรือน" ต้องไม่เป็นค่าว่าง โปรดลองอีกครั้ง');
        }

        $requestToJson = json_encode($request);
        $data = [
            'date' => $date,
            'building' => $building,
            'value' => $requestToJson,
            'display' => 1,
            'status' => 1
        ];

        if($this->BuildingRepositories->save($data)){
            return back()
                ->with('warning', 'success')
                ->with('message', 'บันทึก '. $data['date'].' สำเร็จ');
        } else {
            return back()
                ->with('warning', 'danger')
                ->with('message', 'บันทึกไม่สำเร็จ โปรดลองอีกครั่้ง');
        }

    }

    public function upDateBuildingById(Request $input,$id){

        $request = $input->get('form');
        $requestToJson = json_encode($request);

        unset($request['date'],$request['building']);

        $data = [
            'value' => $requestToJson
        ];
        if ($this->BuildingRepositories->upDateBuildingById($id,$data)){
            return back()
                ->with('warning', 'success')
                ->with('message', 'การแก้ไข สำเร็จ')
                ->with('id', $id);
        } else {
            return back()
                ->with('warning', 'danger')
                ->with('message', 'การแก้ไขไม่สำเร็จ โปรดลองอีกครั่้ง');
        }

    }

    public function getDataBuildingEachDayById($id){
        $date = $this->BuildingRepositories->getDataBuildingEachDayById($id);
        return response()->json([
            'date' => $date,
        ]);

    }

}

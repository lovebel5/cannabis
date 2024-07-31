<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\IndexRepositories;
use App\Libraries\IndexLibraries;


class IndexControllers
{
    public $IndexRepositories;
    public $VariableControllers;

    public function __construct(IndexRepositories $IndexRepositories, VariableControllers $VariableControllers, IndexLibraries $IndexLibraries)
    {
        $this->IndexRepositories = $IndexRepositories;
        $this->VariableControllers = $VariableControllers;
        $this->IndexLibraries = $IndexLibraries;
    }


    public function index()
    {
        $var = $this->VariableControllers->getVariable('var');
        $head = $this->VariableControllers->getVariable('head');
        $soilType = $this->VariableControllers->getVariable('soil');
        $status = $this->VariableControllers->getVariable('status');
        $building = $this->VariableControllers->getVariable('building');
        $basicInformation = $this->IndexRepositories->getBasicInformationTableByKey('basic_information');

        return view('admin.index', [
            'input' => $var['input'],
            'name' => $var['name'],
            'status' => $status,
            'head_project' => $head,
            'soil_type' => $soilType,
            'building' => $building,
            'basicInformation' => $basicInformation,
        ]);
    }

    public function insetInformation(Request $input)
    {
        $dataInput = $input->get('input');
        if($this->IndexLibraries->checkInputNull($input->get('input'))){
            return back()
                ->with('warning', 'danger')
                ->with('message', 'Message[Error] : "ชื่อโรงเรือน, หัวหน้าโรงเรือน, เจ้าหน้าที่ประจำโรงเรือน" ต้องไม่เป็นค่าว่าง');
        }
//        $dataInput['expert'] = $this->IndexLibraries->countAndSetKeyInArray($dataInput['expert']);
//        $dataInput['coworker'] = $this->IndexLibraries->countAndSetKeyInArray($dataInput['coworker']);
        $inputToJson = json_encode($dataInput);
//        dd($dataInput['coworker']);
        $data = [
            'key' => 'basic_information',
            'value' => $inputToJson,
            'display' => 1,
            'status' => 1
        ];

        if ($this->IndexRepositories->save($data) === true) {
            return back()
                ->with('warning', 'success')
                ->with('message', 'บันทึกสำเร็จ ' . $dataInput['trial_code']);
        }
    }

    public function disableBasicInformation($id)
    {
        $result = $this->IndexRepositories->disableBasicInformation($id);

        if($result){
            return back()
                ->with('warning', 'success')
                ->with('message', 'ปรับปรุงรายการสำเร็จ');
        } else {
            return back()
                ->with('warning', 'danger')
                ->with('message', 'ปรับปรุงรายการไม่สำเร็จ');
        }

    }

    public function alert($warning, $message)
    {
        return back()
            ->with('warning', $warning)
            ->with('message', $message);
    }

    public function search(Request $search){
        if($search->get('search') === null){
            return redirect('admin')
                ->with('warning', 'warning')
                ->with('message', 'ข้อมูลไม่ถูกต้อง');
            exit();
        }
        return redirect('admin/profile/'.$search->get('search'));
    }

    public function showToken()
    {
        echo csrf_token();
    }
}

<?php


namespace App\Http\Controllers\Admin;

use App\Repositories\EventRepositories;
use App\Libraries\EventLibraries;
use App\Repositories\ProfileRepositories;
use App\Repositories\IndexRepositories;

use Illuminate\Http\Request;
use function Symfony\Component\String\u;

class EventControllers
{
    public $EventRepositories;
    public $EventLibraries;
    public $ProfileRepositories;
    public $IndexRepositories;
    public $VariableControllers;

    public function __construct(EventRepositories $EventRepositories,
                                EventLibraries $EventLibraries,
                                ProfileRepositories $ProfileRepositories,
                                IndexRepositories $IndexRepositories,
                                VariableControllers $VariableControllers)
    {
        $this->EventRepositories = $EventRepositories;
        $this->EventLibraries = $EventLibraries;
        $this->ProfileRepositories = $ProfileRepositories;
        $this->IndexRepositories = $IndexRepositories;
        $this->VariableControllers = $VariableControllers;

    }

    public function index()
    {
        $var = $this->VariableControllers->getVariable('eventCannabis');
        return view('admin.event-group', [
            'var' => $var,
        ]);
    }

    public function insetEventByScanQrCode(Request $input)
    {

        $dataInput['json'] = [
            'date' => $input->get('date'),
            'data' => [
                'tags' => $input->get('tags'),
                'message' => $input->get('message'),
                'img' => '-',
                'user' => '0',
            ]
        ];

        $data = [
            'id_basic_info' => $input->get('id_basic_info'),
            'val_json' => json_encode($dataInput['json']),
        ];

        if($this->EventRepositories->save($data)){
            return response()->json([
                'date' => $input,
            ]);
        } else {
            return response()->json([
                'Error' => $input,
            ]);
        }

    }

    public function showEventById($id)
    {
        $var = $this->VariableControllers->getVariable('eventCannabis');
        $checkCannabisAvailableById = $this->IndexRepositories->getDataById($id);


        if (!$checkCannabisAvailableById) {
            return abort(404);
            exit();
        }

        $getEvent = $this->EventRepositories->getAllEventByInfoId($id);
        $checkCannabisAvailableById->value = json_decode($checkCannabisAvailableById->value,true);

        return view('admin.event', [
            'id' => $id,
            'data' => $getEvent,
            'var' => $var,
            'info' => $checkCannabisAvailableById,


        ]);
    }

    public function insetEvent(Request $input)
    {
        $dataInput = $input->all();
        if(is_null($dataInput['message']) && is_null($dataInput['tags'])){
            return back()
                ->with('warning', 'danger')
                ->with('message', 'รายการไม่สำเร็จ');
        }

        $dataInput['json'] = [
            'date' => date('Y-m-d H:i:s'),
            'data' => [
                'tags' => $dataInput['tags'],
                'message' => $dataInput['message'],
                'img' => '-',
                'user' => '0',
            ]
        ];

        $data = [
            'id_basic_info' => $dataInput['id_basic_info'],
            'val_json' => json_encode($dataInput['json']),
        ];

        if ($this->EventRepositories->save($data)) {
            return back()
                ->with('warning', 'success')
                ->with('message', 'บันทึกสำเร็จ ');
        } else {
            return abort(404);
        }

//        if ($this->checkEventByIdInfo($dataInput['id_basic_info'])) {
//            $this->EventRepositories->saveAppend($dataInput['id_basic_info'], $inputToJson);
//
//            return back()
//                ->with('warning', 'success')
//                ->with('message', 'บันทึกสำเร็จ ');
//
//        } elseif ($this->EventRepositories->save($data)) {
//            return back()
//                ->with('warning', 'success')
//                ->with('message', 'บันทึกสำเร็จ ');
//
//        }
    }

    public function checkEventByIdInfo($id)
    {
        $result = $this->EventRepositories->getEventByInfoId($id);

        return $result;


    }


}

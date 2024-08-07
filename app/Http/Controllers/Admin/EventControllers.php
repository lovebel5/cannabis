<?php


namespace App\Http\Controllers\Admin;

use App\Repositories\EventRepositories;
use App\Libraries\EventLibraries;
use App\Repositories\ProfileRepositories;

use Illuminate\Http\Request;

class EventControllers
{
    public $EventRepositories;
    public $EventLibraries;
    public $ProfileRepositories;

    public function __construct(EventRepositories $EventRepositories, EventLibraries $EventLibraries, ProfileRepositories $ProfileRepositories)
    {
        $this->EventRepositories = $EventRepositories;
        $this->EventLibraries = $EventLibraries;
        $this->ProfileRepositories = $ProfileRepositories;

    }

    public function index()
    {
       dd($this->EventRepositories->getEventAll());
    }

    public function insetEvent(Request $input)
    {
        $dataInput = $input->all();

        $dataInput['json'] = [
            'date' => date('Y-m-d H:i:s'),
            'data' => [
                'tags' => $dataInput['tags'],
                'message' => $dataInput['message'],
                'img' => '-',
                'user' => '0',
            ]
        ];
//        dd($dataInput);
        $inputToJson = json_encode($dataInput['json']);
//        dd($dataInput,$inputToJson);
        $data = [
            'id_basic_info' => $dataInput['id_basic_info'],
            'val_json' => $inputToJson,
        ];

        if($this->checkEventByIdInfo($dataInput['id_basic_info'])){
            $this->EventRepositories->saveAppend($dataInput['id_basic_info'],$inputToJson);

        } else {
            if($this->EventRepositories->save($data)){
                return back()
                    ->with('warning', 'success')
                    ->with('message', 'บันทึกสำเร็จ ');
            }
        }


    }

    public function checkEventByIdInfo($id){
        $event = $this->EventRepositories->getEventByInfoId($id);

        if($event) {
            $event = $this->EventRepositories->getEventByInfoId($id);

            return view('admin.event', [
                'info_id' => $event->id_basic_info,
                'event' => $event,

            ]);
        }
    }


}

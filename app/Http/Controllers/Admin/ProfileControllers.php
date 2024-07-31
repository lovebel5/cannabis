<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\ProfileRepositories;
use App\Repositories\ImagesRepositories;
use App\Libraries\ProfileLibraries;

use DB;
use Symfony\Component\VarDumper\Cloner\Data;


class ProfileControllers
{
    public $ProfileLibraries;
    public $VariableControllers;
    public $ProfileRepositories;
    public $ImagesRepositories;

    public function __construct(ProfileLibraries $ProfileLibraries, VariableControllers $VariableControllers, ProfileRepositories $ProfileRepositories, ImagesRepositories $ImagesRepositories)
    {
        $this->ProfileLibraries = $ProfileLibraries;
        $this->VariableControllers = $VariableControllers;
        $this->ProfileRepositories = $ProfileRepositories;
        $this->ImagesRepositories = $ImagesRepositories;
    }

    public function index($id)
    {
        $result = $this->ProfileLibraries->getBasicInformationById($id);
        if (!$result) {
            //เช็ค ID ที่ส่งมาว่ามีจริงไหม
            return redirect('admin')
                ->with('warning', 'warning')
                ->with('message', 'ข้อมูลไม่ถูกต้อง');
            exit();
        }

        $var = $this->VariableControllers->getVariable('var');
        $soilType = $this->VariableControllers->getVariable('soil');
        $status = $this->VariableControllers->getVariable('status');
        $building = $this->VariableControllers->getVariable('building');
        $result->value = json_decode($result->value, true);

        $this->ProfileLibraries->getDataBuildingAndThenSaveInBuildingInfo($result->value['experiment_name'],$id);
        $rowBuildingInfo = $this->ProfileRepositories->getBuildingInfoByKeyArray($result->value['experiment_name'],$id);

        $img = $this->ImagesRepositories->getImageByIDBasicInfo($id);

        return view('admin.profile', [
            'data' => $result,
            'var' => $var,
            'status' => $status,
            'soil_type' => $soilType,
            'img' => $img,
            'building' => $building,
            'row_building_info' => $rowBuildingInfo,
        ]);
    }

    public function update(Request $input, $id){
        $date = $input->get('input');
        $result = $this->ProfileRepositories->updateBasicInformationById($id, json_encode($date));
        $resultUpLoadImg = $this->upLoadImg($input, $id);

        if ($result == 1 || $resultUpLoadImg) {
            return back()
                ->with('warning', 'success')
                ->with('message', 'ปรับปรุงรายการสำเร็จ');

        } else {
            return back()
                ->with('warning', 'danger')
                ->with('message', 'คำเตือน : โปรดลองใหม่ครั้ง! "ไม่มีการแก้ไข หรือ บันทึกไม่สำเร็จ"');
        }
    }

    public function upLoadImg($request, $id_basic_info){
            $result = array();
            foreach ($_FILES['upload_img']['name'] as $index => $val) {
                $errors = array();
                $file_name = $_FILES['upload_img']['name'][$index];
                $file_size = $_FILES['upload_img']['size'][$index];
//              $file_tmp = $_FILES['upload_img']['tmp_name'][$index];
//              $file_type = $_FILES['upload_img']['type'][$index];
                $explode = explode('.', $file_name);
                $file_ext = strtolower(end($explode));
                $setNewName = md5($file_name) . rand(1000, 9999) . '.' . $file_ext;

                $extensions = array("jpeg", "jpg", "png");

                if (in_array($file_ext, $extensions) === false) {
                    $errors[] = "extension not allowed, please choose a JPEG or PNG file.";
                }

                if ($file_size > 2097152) {
                    $errors[] = 'File size must be excately 2 MB';
                }

                if (empty($errors) == true) {
                    $file = $request->file('upload_img')[$index];
                    $file->move(public_path('upload/image'), $setNewName);
                    $data = [
                        'id_basic_info' => $id_basic_info,
                        'name_img' => $setNewName,
                    ];
                    $result[] = $this->ImagesRepositories->save($data);
                }
            }

            if(in_array('false',$result)  === false){
                return false;
            } else {
                return true;
            }
        }

    public function getBasicInformationById($id){
        $basicInformation = $this->ProfileLibraries->getBasicInformationById($id);

        if ($basicInformation === null) {
            return response()->json([
                'status' => 'danger',
                'message' => 'ไม่พบข้อมูล'
            ]);
        }
    }

    public function updateBasicInformationNoteOnlyById(Request $data){
        $this->ProfileRepositories->updateBasicInformationNoteOnlyById($data->get('id'), $data->get('note'));
        return response()->json([
            'status' => true,
            'message' => ''
        ]);
    }

    public function delImgInProFile($id_img){
        $result = $this->ImagesRepositories->getImgById($id_img);

        if ($result) {
            $this->ImagesRepositories->delImgById($id_img);
            $delImg = unlink(public_path('upload/image/'.$result->name_img));

            return response()->json([
                'status' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
            ]);
        }
    }

    public function insertContentImg(Request $data){
        $content = [
            'title' => $data->get('title'),
            'content' => $data->get('content')
        ];
        $result = $this->ImagesRepositories->updateTitleAndContentImgByID($data->get('id'),json_encode($content));
        if($result === 1){
            $error = 'success';
        } else {
            $error = 'error';
        }
        return response()->json([
            'status' => $error,
        ]);
    }

    public function getImageByImageID($id_img){
       $getImg = $this->ImagesRepositories->getImgById($id_img);
        return response()->json(json_decode($getImg->content,true));
    }

    public function ajaxGetBasicInformationById($id){
        $basicInformation = $this->ProfileLibraries->getBasicInformationById($id);

        if (!$basicInformation) {
            return response()->json([
                'status' => false,
                'message' => 'ข้อมูลไม่ถูกต้อง'
            ]);
        } else {
            return response()->json([
                'status' => true,
                'message' => ''
            ]);
        }
    }
}

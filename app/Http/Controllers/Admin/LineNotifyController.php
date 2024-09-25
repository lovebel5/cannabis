<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\weatherControllers;
use App\Http\Controllers\Admin\DiscordControllers;
use Illuminate\Support\Facades\Http;

class LineNotifyController
{
    protected $lineToken;
    public $weatherControllers;
    public $DiscordControllers;

    public function __construct(
        weatherControllers $weatherControllers,
        DiscordControllers $DiscordControllers
    )
    {
        // ใส่ Line Notify Token ที่ได้จากการลงทะเบียนกับ Line Notify API
        $this->lineToken = env('LINE_NOTIFY_TOKEN');
        $this->weatherControllers = $weatherControllers;
        $this->DiscordControllers = $DiscordControllers;
    }


    // ฟังก์ชันส่งข้อความไปยัง Line Notify
    public function sendNotification($message)
    {

        // ส่งข้อความผ่าน LINE Notify
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->lineToken,
        ])->asForm()->post('https://notify-api.line.me/api/notify', [
            'message' => $message
        ]);

        // ตรวจสอบสถานะการส่ง
        if ($response->successful()) {
            return response()->json(['success' => true, 'message' => 'Notification sent successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Failed to send notification.']);
    }

    public function eventNotification($data){
        $message = $data['id_basic_info'].", ".$data['message'].", \n".$data['tags'].", \n".url('admin/event/'.$data['id_basic_info']);
        $this->sendNotification($message);
    }

    public function warehouseNotification($data){
          $message = "\nDate: ".$data['date']."\nWarehouse: ".strtoupper($data['building'])."\nMoisture: ".$data['moisture']."\nTemperature: ".$data['temperature'];
          $this->sendNotification($message);
    }

    public function sendWeatherToLineGroup(){
       $weather = $this->weatherControllers->index();
       $message = " Climate\n"." Date: (".date('D').".) ".date('Y-m-d')."\n Location Outside: Taladyai, Phuket\n Temp.: ".$weather['tc_max']."/".$weather['tc_min']." °C"."\n Moisture: ".$weather['rh'].' %'."\n Weather: ".$weather['cond'];
       $this->sendNotification($message);
       $this->DiscordControllers->sendWeatherToDiscord($message);



    }
}

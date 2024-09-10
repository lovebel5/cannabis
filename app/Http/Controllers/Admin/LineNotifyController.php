<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Http;

class LineNotifyController
{
    protected $lineToken;

    public function __construct()
    {
        // ใส่ Line Notify Token ที่ได้จากการลงทะเบียนกับ Line Notify API
        $this->lineToken = env('LINE_NOTIFY_TOKEN');
    }

    // ฟังก์ชันส่งข้อความไปยัง Line Notify
    public function sendNotification($data)
    {

        $message = $data['id_basic_info'].", ".$data['message'].", \n".$data['tags'].", \n".url('admin/event/'.$data['id_basic_info']);
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
}

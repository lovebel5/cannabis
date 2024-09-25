<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\weatherControllers;

use Illuminate\Support\Facades\Http;


class DiscordControllers
{
    public function webHookDiscord($message)
    {
        // Webhook URL ของ Discord
        $webhook_url = env('DISCORD_WEBHOOK_URl');

        // ข้อความและลิงก์ที่ต้องการส่ง
        $link = "https://google.com";

        // ใช้ Facade Http ของ Laravel ในการส่งคำขอไปยัง Webhook
        $response = Http::post($webhook_url, [
            'content' => $message,
        ]);

        // ตรวจสอบผลลัพธ์การส่งข้อมูล
        if ($response->successful()) {
            return response()->json(['message' => 'Message sent successfully'], 200);
        } else {
            return response()->json(['error' => 'Failed to send message'], 500);
        }
    }

    public function sendEventToDiscord($message)
    {
        $message =  'ID: '.$message['id_basic_info']."\nTags: ".$message['tags']."\nMessage: ".$message['message'];
        $this->webHookDiscord($message);

    }

    public function sendWeatherToDiscord($message)
    {
        $this->webHookDiscord($message);
    }



}

<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class EventControllers
{
    public function index()
    {
        return view('admin.event', [
            'input' => 'zzzzz']);
    }
    public function test(Request $data)
    {
        $dataInput = $data->all();
        $xx = json_encode($dataInput['tags']);
        $zz = json_decode($xx,true);
        dd($dataInput,$xx,$zz);

        return view('admin.test', [
            'input' => 'zzzzz']);
    }
}

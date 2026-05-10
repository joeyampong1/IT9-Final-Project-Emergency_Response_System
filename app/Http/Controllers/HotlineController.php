<?php

namespace App\Http\Controllers;  

class HotlineController extends Controller
{
    public function index()
    {
        $hotlines = [
            ['name' => 'Philippine National Police (PNP)', 'number' => '117', 'icon' => 'police'],
            ['name' => 'Bureau of Fire Protection (BFP)', 'number' => '160', 'icon' => 'fire'],
            ['name' => 'Emergency 911', 'number' => '911', 'icon' => 'emergency'],
            ['name' => 'National Emergency Hotline', 'number' => '911', 'icon' => 'call'],
            ['name' => 'Red Cross Philippines', 'number' => '143', 'icon' => 'medical'],
        ];
        return view('citizen.hotlines', compact('hotlines'));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use App\Services\PatreonService;

class VolumeController extends Controller
{
    public function index() {
        $volumes = Volume::withAvailablePages()->get();
        
        return view('browse.volumes.index', compact('volumes'));
    }

    public function view(Volume $volume) {
        if ($volume->is_available) {
            return view('browse.volumes.view', compact('volume'));
        }
        else {
            return PatreonService::redirect();
        }
    }
}

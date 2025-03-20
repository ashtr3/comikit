<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Services\PatreonService;

class ChapterController extends Controller
{
    public function index() {
        $chapters = Chapter::withAvailablePages()->get();

        $groupedChapters = $chapters->groupBy('volume_id');

        return view('browse.chapters.index', compact('groupedChapters'));
    }

    public function view(Chapter $chapter) {
        if ($chapter->is_available) {
            return view('browse.chapters.view', compact('chapter'));
        }
        else {
            return PatreonService::redirect();
        }
    }
}

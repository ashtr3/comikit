<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Services\PatreonService;

class PageController extends Controller
{
    public function index() {
        $pages = Page::available()->get();
        
        $groupedPages = $pages->groupBy(function ($page) {
            return $page->chapter->volume_id;
        })->map(function ($volumePages) {
            return $volumePages->groupBy('chapter_id');
        });

        return view('browse.pages.index', compact('groupedPages'));
    }

    public function view(Page $page) {
        if ($page->is_available) {
            return view('browse.pages.view', compact('page'));
        }
        else {
            return PatreonService::redirect();
        }
    }

    public function start() {
        $page = Page::orderBy('page_index', 'asc')->first();

        if ($page->is_available) {
            return view('browse.pages.view', compact('page'));
        }
        else {
            return PatreonService::redirect();
        }
    }

    public function latest() {
        $page = Page::orderBy('page_index', 'desc')->first();

        if ($page->is_available) {
            return view('browse.pages.view', compact('page'));
        }
        else {
            return PatreonService::redirect();
        }
    }
}

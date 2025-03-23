<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index() {
        $pages = Page::with('chapter.volume')->get();

        $groupedPages = $pages->groupBy(function ($page) {
            return $page->chapter->volume_id;
        })->map(function ($volumePages) {
            return $volumePages->groupBy('chapter_id');
        });
        
        return view('admin.pages.index', compact('groupedPages'));
    }

    public function view(Page $page) {
        return view('admin.pages.view', compact('page'));
    }

    public function create() {
        $volumes = Volume::all();
        return view('admin.pages.create', compact('volumes'));
    }

    public function store(StorePageRequest $request) {
        $page = Page::create($request->except('page_image'));

        Page::where('page_index', '>=', $page->page_index)
            ->where('id', '!=', $page->id)
            ->increment('page_index');

        if ($request->hasFile('page_image')) {
            $file = $request->file('page_image');
            $file_ext = $file->getClientOriginalExtension();
            $file_path = "comics/{$page->id}.{$file_ext}";
            
            Storage::put($file_path, file_get_contents($file));

            $file_name = $file->getClientOriginalName();
            $mime_type = $file->getMimeType();
            $file_size = $file->getSize();
            
            $page->images()->create([
                'imageable_id' => $page->id,
                'imageable_type' => Page::class,
                'url' => Storage::url($file_path),
                'name' => $file_name,
                'alt_text' => $page->display_name . ' image',
                'file_size' => $file_size,
                'mime_type' => $mime_type,
                'extension' => $file_ext,
                'display_type' => 'full'
            ]);
        }

        return redirect()->route('admin.page.view', $page);
    }

    public function edit(Page $page) {
        $volumes = Volume::all();
        return view('admin.pages.edit', compact('page', 'volumes'));
    }

    public function update(UpdatePageRequest $request, Page $page) {
        $page->update($request->except('page_image'));
        
        if ($request->hasFile('page_image')) {
            $file = $request->file('page_image');
            $file_ext = $file->getClientOriginalExtension();
            $file_path = "comics/{$page->id}.{$file_ext}";
            
            Storage::put($file_path, file_get_contents($file));

            $file_name = $file->getClientOriginalName();
            $mime_type = $file->getMimeType();
            $file_size = $file->getSize();

            $page->image()->update([
                'url' => Storage::url($file_path),
                'name' => $file_name,
                'alt_text' => $page->display_name . ' image',
                'file_size' => $file_size,
                'mime_type' => $mime_type,
                'extension' => $file_ext,
            ]);
        }

        return redirect()->route('admin.page.view', $page);
    }

    public function sort() {
        $pages = Page::with('chapter.volume')->get();

        $groupedPages = $pages->groupBy(function ($page) {
            return $page->chapter->volume_id;
        })->map(function ($volumePages) {
            return $volumePages->groupBy('chapter_id');
        });

        return view('admin.pages.sort', compact('groupedPages'));
    }

    public function updateSort(Request $request) {
        $orderedIds = json_decode($request->input('order'), true);

        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                Page::where('id', $id)->update(['page_index' => $index]);
            }
        });

        return redirect()->route('admin.page.index');
    }

    public function destroy(Page $page) {
        Page::where('page_index', '>', $page->page_index)
            ->where('id', '!=', $page->id)->decrement('page_index');

        $page->delete();
        return redirect()->route('admin.page.index');
    }

    public function getNextPageNumber(int $chapterId) {
        $max_number = Page::where('chapter_id', $chapterId)->max('page_number') ?? 0;
        return $max_number + 1;
    }
}

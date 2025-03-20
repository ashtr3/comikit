<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Models\Chapter;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function index() {
        $chapters = Chapter::all();

        $groupedChapters = $chapters->groupBy('volume_id');

        return view('admin.chapters.index', compact('groupedChapters'));
    }

    public function view(Chapter $chapter) {
        return view('admin.chapters.view', compact('chapter'));
    }

    public function create() {
        $volumes = Volume::all();
        return view('admin.chapters.create', compact('volumes'));
    }

    public function store(StoreChapterRequest $request) {
        $chapter = Chapter::create($request->all());

        Chapter::where('chapter_index', '>=', $chapter->chapter_index)
            ->where('id', '!=', $chapter->id)->increment('chapter_index');

        return redirect()->route('admin.chapter.view', $chapter);
    }

    public function edit(Chapter $chapter) {
        $volumes = Volume::all();
        return view('admin.chapters.edit', compact('chapter', 'volumes'));
    }

    public function update(UpdateChapterRequest $request, Chapter $chapter) {
        $chapter->update($request->all());
        return redirect()->route('admin.chapter.view', $chapter);
    }

    public function sort() {
        $chapters = Chapter::all();

        $groupedChapters = $chapters->groupBy('volume_id');

        return view('admin.chapters.sort', compact('groupedChapters'));
    }

    public function updateSort(Request $request) {
        $orderedIds = json_decode($request->input('order'), true);

        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                Chapter::where('id', $id)->update(['chapter_index' => $index]);
            }

            $page_index = 0;

            foreach (Chapter::all() as $chapter) {
                foreach ($chapter->pages as $page) {
                    $page->update(['page_index' => $page_index]);
                    $page_index++;
                }
            }
        });        

        return redirect()->route('admin.chapter.index')->with('success', 'Sort order updated!');
    }

    public function destroy(Chapter $chapter) {
        if ($chapter->pages()->exists()) {
            return back()->with('error', 'Cannot delete this chapter because it has pages.');
        }

        Chapter::where('chapter_index', '>', $chapter->chapter_index)
            ->where('id', '!=', $chapter->id)->decrement('chapter_index');

        $chapter->delete();
        return redirect()->route('admin.chapter.index');
    }

    public function getChaptersByVolume(int $volumeId) {
        $chapters = Chapter::where('volume_id', $volumeId)
            ->get()
            ->map(fn($chapter) => [
                'id' => $chapter->id,
                'display_name' => $chapter->display_name,
            ]);
        return response()->json($chapters);
    }

    public function getNextChapterNumber(int $volumeId) {
        $max_number = Chapter::where('volume_id', $volumeId)->max('chapter_number') ?? 0;
        return $max_number + 1;
    }
}

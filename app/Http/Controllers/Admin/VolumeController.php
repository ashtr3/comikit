<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVolumeRequest;
use App\Http\Requests\UpdateVolumeRequest;
use App\Models\Chapter;
use App\Models\Volume;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VolumeController extends Controller
{
    public function index() {
        $volumes = Volume::all();
        return view('admin.volumes.index', compact('volumes'));
    }

    public function view(Volume $volume) {
        return view('admin.volumes.view', compact('volume'));
    }

    public function create() {
        return view('admin.volumes.create');
    }

    public function store(StoreVolumeRequest $request) {
        $volume = Volume::create($request->all());
        return redirect()->route('admin.volume.view', $volume);
    }

    public function edit(Volume $volume) {
        return view('admin.volumes.edit', compact('volume'));
    }

    public function update(UpdateVolumeRequest $request, Volume $volume) {
        $volume->update($request->all());
        return redirect()->route('admin.volume.view', $volume);
    }

    public function sort() {
        $volumes = Volume::all();
        return view('admin.volumes.sort', compact('volumes'));
    }

    public function updateSort(Request $request) {
        $orderedIds = json_decode($request->input('order'), true);

        DB::transaction(function () use ($orderedIds) {
            foreach ($orderedIds as $index => $id) {
                Volume::where('id', $id)->update(['volume_index' => $index]);
            }

            $chapter_index = 0;
            $page_index = 0;

            foreach (Volume::all() as $volume) {
                foreach ($volume->chapters as $chapter) {
                    $chapter->update(['chapter_index' => $chapter_index]);
                    $chapter_index++;
                    
                    foreach ($chapter->pages as $page) {
                        $page->update(['page_index' => $page_index]);
                        $page_index++;
                    }
                }
            }
        });        

        return redirect()->route('admin.volume.index')->with('success', 'Sort order updated!');
    }

    public function destroy(Volume $volume) {
        if ($volume->chapters()->exists()) {
            return back()->with('error', 'Cannot delete this volume because it has chapters.');
        }

        Volume::where('volume_index', '>', $volume->volume_index)
            ->where('id', '!=', $volume->id)->decrement('volume_index');

        $volume->delete();
        return redirect()->route('admin.volume.index');
    }
    
    public function getNextVolumeNumber() {
        $max_number = Volume::max('volume_number') ?? 0;
        return $max_number + 1;
    }
}

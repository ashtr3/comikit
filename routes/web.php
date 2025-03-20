<?php

use App\Http\Controllers\Admin\VolumeController as AdminVolumeController;
use App\Http\Controllers\Admin\ChapterController as AdminChapterController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\VolumeController;
use App\Services\PatreonService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
})->name('home');

Route::as('auth.')->group(function() {

    Route::get('/auth/redirect', function () {
        return PatreonService::redirect();
    })->name('redirect');
    
    Route::get('/auth/callback', function () {
        return PatreonService::register();
    })->name('callback');
    
    Route::post('/logout', function () {
        return PatreonService::logout();
    })->name('logout');

});

Route::prefix('admin')->as('admin.')->middleware('creator')->group(function() {

    Route::get('/volumes', [AdminVolumeController::class, 'index'])->name('volume.index');
    Route::get('/volumes/new', [AdminVolumeController::class, 'create'])->name('volume.create');
    Route::post('/volumes/new', [AdminVolumeController::class, 'store'])->name('volume.store');
    Route::get('/volumes/sort', [AdminVolumeController::class, 'sort'])->name('volume.sort');
    Route::put('/volumes/sort', [AdminVolumeController::class, 'updateSort'])->name('volume.sort.update');
    Route::get('/volumes/next_number', [AdminVolumeController::class, 'getNextVolumeNumber'])->name('volume.next-number');
    Route::get('/volume/{volume}', [AdminVolumeController::class, 'view'])->name('volume.view');
    Route::get('/volume/{volume}/edit', [AdminVolumeController::class, 'edit'])->name('volume.edit');
    Route::put('/volume/{volume}/edit', [AdminVolumeController::class, 'update'])->name('volume.update');
    Route::delete('/volume/{volume}/delete', [AdminVolumeController::class, 'destroy'])->name('volume.delete');

    Route::get('/chapters', [AdminChapterController::class, 'index'])->name('chapter.index');
    Route::get('/chapters/new', [AdminChapterController::class, 'create'])->name('chapter.create');
    Route::post('/chapters/new', [AdminChapterController::class, 'store'])->name('chapter.store');
    Route::get('/chapters/sort', [AdminChapterController::class, 'sort'])->name('chapter.sort');
    Route::put('/chapters/sort', [AdminChapterController::class, 'updateSort'])->name('chapter.sort.update');
    Route::get('/chapters/next_number/{volumeId}', [AdminChapterController::class, 'getNextChapterNumber'])->name('chapter.next-number');
    Route::get('/chapters/{volumeId}', [AdminChapterController::class, 'getChaptersByVolume'])->name('chapter.by-volume');
    Route::get('/chapter/{chapter}', [AdminChapterController::class, 'view'])->name('chapter.view');
    Route::get('/chapter/{chapter}/edit', [AdminChapterController::class, 'edit'])->name('chapter.edit');
    Route::put('/chapter/{chapter}/edit', [AdminChapterController::class, 'update'])->name('chapter.update');
    Route::delete('/chapter/{chapter}/delete', [AdminChapterController::class, 'destroy'])->name('chapter.delete');

    Route::get('/pages', [AdminPageController::class, 'index'])->name('page.index');
    Route::get('/pages/new', [AdminPageController::class, 'create'])->name('page.create');
    Route::post('/pages/new', [AdminPageController::class, 'store'])->name('page.store');
    Route::get('/pages/sort', [AdminPageController::class, 'sort'])->name('page.sort');
    Route::put('/pages/sort', [AdminPageController::class, 'updateSort'])->name('page.sort.update');
    Route::get('/pages/next_number/{chapterId}', [AdminPageController::class, 'getNextPageNumber'])->name('page.next-number');
    Route::get('/page/{page}', [AdminPageController::class, 'view'])->name('page.view');
    Route::get('/page/{page}/edit', [AdminPageController::class, 'edit'])->name('page.edit');
    Route::put('/page/{page}/edit', [AdminPageController::class, 'update'])->name('page.update');
    Route::delete('/page/{page}/delete', [AdminPageController::class, 'destroy'])->name('page.delete');

});

Route::as('browse.')->group(function() {

    Route::get('/volumes', [VolumeController::class, 'index'])->name('volume.index');
    Route::get('/volume/{volume}', [VolumeController::class, 'view'])->name('volume.view');

    Route::get('/chapters', [ChapterController::class, 'index'])->name('chapter.index');
    Route::get('/chapter/{chapter}', [ChapterController::class, 'view'])->name('chapter.view');

    Route::get('/pages', [PageController::class, 'index'])->name('page.index');
    Route::get('/page/start', [PageController::class, 'start'])->name('page.start');
    Route::get('/page/latest', [PageController::class, 'latest'])->name('page.latest');
    Route::get('/page/{page}', [PageController::class, 'view'])->name('page.view');
    
});

Route::as('comment.')->middleware('authenticated')->group(function() {
    
    Route::post('/comment/new/{type}/{id}', [CommentController::class, 'store'])->name('store');
    Route::put('/comment/{comment}/edit', [CommentController::class, 'update'])->name('update');
    Route::delete('/comment/{comment}/delete', [CommentController::class, 'destroy'])->name('delete');

});
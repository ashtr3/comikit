<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Volume;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request, string $type, int $id) 
    {
        $class = 'App\\Models\\' . ucfirst($type);

        if (!class_exists($class)) {
            return redirect()->back()->with('error', 'Invalid commentable type.');
        }

        $commentable = $class::findOrFail($id);
        $commentable->comments()->create($request->all());

        return redirect()->back()->with('success', 'Comment posted successfully!');
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->all());
        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}

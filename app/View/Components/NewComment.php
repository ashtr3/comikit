<?php

namespace App\View\Components;

use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Page;
use App\Models\Volume;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewComment extends Component
{
    public Volume|Chapter|Page $commentable;
    public Comment|null $parent;

    /**
     * Create a new component instance.
     */
    public function __construct(Volume|Chapter|Page $commentable, Comment|null $parent = null)
    {
        $this->commentable = $commentable;
        $this->parent = $parent;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.new-comment');
    }
}

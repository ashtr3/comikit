<?php

namespace App\View\Components;

use App\Models\Comment as CommentModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Closure;

class Comment extends Component
{
    public $comment;

    /**
     * Create a new component instance.
     */
    public function __construct(CommentModel $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.comment');
    }
}

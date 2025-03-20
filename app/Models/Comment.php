<?php

namespace App\Models;

use App\Services\PatreonService;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'commentable_type',
        'commentable_id',
        'parent_id',
        'body',
        'patron_id',
        'patron_name',
        'patron_email',
        'patron_avatar',
        'is_creator',
        'has_pledged',
    ];

    public function commentable() {
        return $this->morphTo();
    }

    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function getIsEditableAttribute() {
        $is_creator = PatreonService::isCreator();
        if ($is_creator) {
            return true;
        }

        $has_auth = PatreonService::hasAuthenticated();
        if ($has_auth) {
            $patron_id = session('patreon.id');
            return $this->patron_id == $patron_id;
        }
    }
}

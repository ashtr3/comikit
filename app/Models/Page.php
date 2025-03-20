<?php

namespace App\Models;

use App\Services\PatreonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected static function booted() {
        static::addGlobalScope('indexOrder', function (Builder $builder) {
            $builder->orderBy('page_index', 'asc');
        });
    }

    protected $fillable = [
        'chapter_id',
        'page_index',
        'page_number',
        'page_name',
        'page_image',
        'page_description',
        'page_secret',
        'is_cover',
        'is_special',
        'patreon_release_at',
        'public_release_at',
    ];

    protected $appends = [
        'display_name',
    ];

    protected $casts = [
        'patreon_release_at' => 'datetime',
        'public_release_at' => 'datetime',
    ];

    public function chapter() {
        return $this->belongsTo(Chapter::class);
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getDisplayNameAttribute() {
        if ($this->page_number != null && $this->page_name != null) {
            return "Pg. $this->page_number: $this->page_name";
        }
        else if ($this->page_number != null) {
            return "Pg. $this->page_number";
        }
        else if ($this->page_name) {
            return $this->page_name;
        }
        else {
            return "(#$this->id)";
        }
    }

    public function getNextPageAttribute() {
        return Page::where('page_index', $this->page_index + 1)->first();
    }

    public function getPreviousPageAttribute() {
        return Page::where('page_index', $this->page_index - 1)->first();
    }

    public function getIsPublicReleaseAttribute() {
        return $this->public_release_at->isPast();
    }

    public function getIsPatronOnlyReleaseAttribute() {
        return $this->patreon_release_at->isPast() && $this->public_release_at->isFuture();
    }

    public function getIsReleasedAttribute() {
        return $this->patreon_release_at->isPast();
    }

    public function getIsUnreleasedAttribute() {
        return $this->patreon_release_at->isFuture();
    }

    public function getIsAvailableAttribute() {
        $is_creator = PatreonService::isCreator();
        $has_pledged = PatreonService::hasPledged();
        return $this->is_public_release || ($this->is_released && $has_pledged) || $is_creator;
    }

    public function scopePublic($query) {
        return $query->where('public_release_at', '<', now());
    }

    public function scopePatronOnly($query) {
        return $query->where('patreon_release_at', '<', now())->where('public_release_at', '>', now());
    }

    public function scopeReleased($query) {
        return $query->where('patreon_release_at', '<', now());
    }

    public function scopeUnreleased($query) {
        return $query->where('patreon_release_at', '>', now());
    }

    public function scopeAvailable($query) {
        $is_creator = PatreonService::isCreator();
        $has_pledged = PatreonService::hasPledged();

        if ($is_creator) {
            return $query;
        }
        else if ($has_pledged) {
            return $query->released();
        }
        else {
            return $query->public();
        };
    }
}

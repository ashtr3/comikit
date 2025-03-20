<?php

namespace App\Models;

use App\Services\PatreonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected static function booted() {
        static::addGlobalScope('indexOrder', function (Builder $builder) {
            $builder->orderBy('chapter_index', 'asc');
        });
    }

    protected $fillable = [
        'volume_id',
        'chapter_index',
        'chapter_number',
        'chapter_name',
        'chapter_description',
    ];

    protected $appends = [
        'display_name',
    ];

    public function volume() {
        return $this->belongsTo(Volume::class);
    }

    public function pages() {
        return $this->hasMany(Page::class);
    }

    public function cover_page() {
        return $this->hasOne(Page::class)->where('is_cover', true);
    }

    public function special_pages() {
        return $this->hasMany(Page::class)->where('is_special', true);
    }

    public function comic_pages() {
        return $this->hasMany(Page::class)->where('is_special', false)->where('is_cover', false);
    }

    public function first_page() {
        return $this->hasOne(Page::class)->orderBy('page_index', 'asc');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getDisplayNameAttribute() {
        if ($this->chapter_number != null && $this->chapter_name != null) {
            return "Ch. $this->chapter_number: $this->chapter_name";
        }
        else if ($this->chapter_number != null) {
            return "Ch. $this->chapter_number";
        }
        else if ($this->chapter_name) {
            return $this->chapter_name;
        }
        else {
            return "(#$this->id)";
        }
    }

    public function getNextChapterAttribute() {
        return Chapter::where('chapter_index', $this->chapter_index + 1)->first();
    }

    public function getPreviousChapterAttribute() {
        return Chapter::where('chapter_index', $this->chapter_index - 1)->first();
    }

    public function getIsPublicReleaseAttribute() {
        return $this->pages()->public()->exists();
    }

    public function getIsReleasedAttribute() {
        return $this->pages()->released()->exists();
    }
    
    public function getIsAvailableAttribute() {
        $is_creator = PatreonService::isCreator();
        $has_pledged = PatreonService::hasPledged();
        return $this->is_public_release || ($this->is_released && $has_pledged) || $is_creator;
    }

    public function scopeWithPublicPages(Builder $query) {
        return $query->whereHas('pages', function ($query) {
            $query->public();
        });
    }

    public function scopeWithReleasedPages(Builder $query) {
        return $query->whereHas('pages', function ($query) {
            $query->released();
        });
    }

    public function scopeWithAvailablePages(Builder $query) {
        $is_creator = PatreonService::isCreator();
        $has_pledged = PatreonService::hasPledged();

        if ($is_creator) {
            return $query;
        }
        else if ($has_pledged) {
            return $query->withReleasedPages();
        }
        else {
            return $query->withPublicPages();
        };
    }
}

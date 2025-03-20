<?php

namespace App\Models;

use App\Services\PatreonService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Volume extends Model
{
    protected static function booted() {
        static::addGlobalScope('indexOrder', function (Builder $builder) {
            $builder->orderBy('volume_index', 'asc');
        });
    }
    
    protected $fillable = [
        'volume_index',
        'volume_number',
        'volume_name',
        'volume_description',
    ];

    protected $appends = [
        'display_name',
    ];

    public function chapters() {
        return $this->hasMany(Chapter::class);
    }

    public function first_chapter() {
        return $this->hasOne(Chapter::class)->orderBy('chapter_index', 'asc');
    }

    public function comments() {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function getDisplayNameAttribute() {
        if ($this->volume_number != null && $this->volume_name != null) {
            return "Vol. $this->volume_number: $this->volume_name";
        }
        else if ($this->volume_number != null) {
            return "Vol. $this->volume_number";
        }
        else if ($this->volume_name) {
            return $this->volume_name;
        }
        else {
            return "(#$this->id)";
        }
    }

    public function getNextVolumeAttribute() {
        return Volume::where('volume_index', $this->volume_index + 1)->first();
    }

    public function getPreviousVolumeAttribute() {
        return Volume::where('volume_index', $this->volume_index - 1)->first();
    }

    public function getIsPublicReleaseAttribute() {
        return $this->chapters()->withPublicPages()->exists();
    }

    public function getIsReleasedAttribute() {
        return $this->chapters()->withReleasedPages()->exists();
    }
    
    public function getIsAvailableAttribute() {
        $is_creator = PatreonService::isCreator();
        $has_pledged = PatreonService::hasPledged();
        return $this->is_public_release || ($this->is_released && $has_pledged) || $is_creator;
    }

    public function scopeWithPublicPages(Builder $query) {
        return $query->whereHas('chapters', function ($query) {
            $query->withPublicPages();
        });
    }

    public function scopeWithReleasedPages(Builder $query) {
        return $query->whereHas('chapters', function ($query) {
            $query->withReleasedPages();
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

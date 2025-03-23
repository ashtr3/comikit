<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'imageable_id',
        'imageable_type',
        'url',
        'name',
        'alt_text',
        'file_size',
        'mime_type',
        'extension',
        'display_type',
    ];

    public function imageable() {
        return $this->morphTo();
    }

    public function getDisplayImageAttribute() {
        return "<img src='$this->url' alt='$this->alt_text'>";
    }
}

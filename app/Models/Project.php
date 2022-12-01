<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['user_id', 'en_name', 'en_description', 'ar_name', 'ar_description'];

    public function before()
    {
        return $this->morphOne(config('media-library.media_model'), 'model')->where('media.collection_name', '=', 'before');
    }

    public function after()
    {
        return $this->morphOne(config('media-library.media_model'), 'model')->where('media.collection_name', '=', 'after');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

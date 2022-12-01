<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use TeamTNT\TNTSearch\TNTGeoSearch;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia, Searchable;

    public $asYouType = true;

    const USER_ADMIN = 0;
    const USER_DOCTOR = 1;
    const USER_COMPANY = 2;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plan_id',
        'en_name',
        'en_country',
        'en_city',
        'en_address',
        'en_bio',
        'ar_name',
        'ar_country',
        'ar_city',
        'ar_address',
        'ar_bio',
        'phone',
        'subscription_deadline',
        'subscription_period',
        'featured',
        'type',
        'email',
        'password',
        'is_activated',
        'latitude',
        'longitude',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'type' => 'integer'
    ];

    public function firstMediaOnly()
    {
        return $this->morphOne(config('media-library.media_model'), 'model');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();
        return $array;
    }
}

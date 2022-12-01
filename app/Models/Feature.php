<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'en_name', 'ar_name'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}

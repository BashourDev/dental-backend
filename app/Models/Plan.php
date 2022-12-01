<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    const PLAN_TYPE_DOCTOR = 0;
    const PLAN_TYPE_COMPANY = 1;

    const PLAN_QUARTER = 0;
    const PLAN_SEMI_ANNUAL = 1;
    const PLAN_ANNUAL = 2;

    protected $fillable = ['en_name', 'ar_name', 'type', 'quarter_price', 'semi_annual_price', 'annual_price'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}

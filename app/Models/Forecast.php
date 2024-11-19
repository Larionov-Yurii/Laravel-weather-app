<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_name',
        'timestamp_dt',
        'min_tmp',
        'max_tmp',
        'wind_spd'
    ];
}

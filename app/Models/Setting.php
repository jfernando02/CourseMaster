<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['department', 'threshold_year', 'threshold_trimester', 'current_year', 'current_trimester', 'campuses'];

    use HasFactory;
}

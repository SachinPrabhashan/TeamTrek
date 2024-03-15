<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExtraCharger extends Model
{
    use HasFactory;
    protected $fillable = [
        'sub_task_id',
        'task_id',
        'charging_dev_hours',
        'charging_eng_hours',
    ];
}

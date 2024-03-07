<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_contract_instance_id',
        'name',
        'start_date',
        'end_date',
        'isCompleted',
        'Description',
    ];
}

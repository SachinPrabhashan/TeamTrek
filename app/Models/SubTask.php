<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'support_contract_instance_id',
        'name',
        'date',
        'dev_hours',
        'eng_hours',
    ];
}

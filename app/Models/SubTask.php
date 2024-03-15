<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'support_contract_instance_id',
        'name',
        'date',
        'dev_hours',
        'eng_hours',
    ];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function remainingHours()
    {
        return $this->hasOne(RemainingHours::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'name',
        'start_date',
        'end_date',
        'isCompleted',
        'Description',
    ];
    public function supportContractInstance()
    {
        return $this->belongsTo(SupportContractInstance::class);
    }

    /**
     * Get the support contract associated with the task through the support contract instance.
     */
    public function supportContract()
    {
        return $this->hasOneThrough(SupportContract::class, SupportContractInstance::class);
    }

    public function subTasks()
    {
        return $this->hasMany(SubTask::class);
    }

    public function remainingHours()
    {
        return $this->hasMany(RemainingHours::class);
    }
}

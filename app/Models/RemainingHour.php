<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemainingHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_task_id',
        'task_id',
        'rem_dev_hours',
        'rem_eng_hours',
    ];
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function subTask()
    {
        return $this->belongsTo(SubTask::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpRate extends Model
{
    use HasFactory;
    protected $fillable = [
        'year',
        'user_id',
        'hourly_rate',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

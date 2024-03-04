<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportContractInstance extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'support_contract_id',
        'year',
        'owner',
        'dev_hours',
        'eng_hours',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'support_contract_instance_id',
        'dev_rate_per_hour',
        'eng_rate_per_hour',
        'year',
    ];

    // public function instances()
    // {
    //     return $this->hasMany(SupportContractInstance::class);
    // }

    public function supportContractInstance()
    {
        return $this->belongsTo(SupportContractInstance::class);
    }
}

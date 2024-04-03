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

    // public function supportcontract(){
    //     return $this->belongsTo(SupportContract::class);
    // }

    public function supportContract()
    {
        return $this->belongsTo(SupportContract::class, 'support_contract_id');
    }

    // public function supportPayment(){
    //     return $this->belongsTo(SupportPayment::class, 'id');
    // }


    public function supportPayment()
    {
        return $this->hasOne(SupportPayment::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}

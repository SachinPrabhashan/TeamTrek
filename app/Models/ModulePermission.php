<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'permission_id',
        'name',
        'role_id',
    ];

    protected $table = 'module_permissions';
}

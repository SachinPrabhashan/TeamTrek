<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    protected $fillable = [
        'name'
    ];

    /**
     * Define the relationship between Module and ModulePermission.
     */
    public function modulePermissions()
    {
        return $this->hasMany(ModulePermission::class);
    }
}

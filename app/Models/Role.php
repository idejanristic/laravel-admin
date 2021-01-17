<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permissions;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function permissions()
    {
        return $this->belongsToMeny(Permission::class, 'role_permission')
    }
}

<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRoute extends Model {
    protected $table = 'role_routes';
    protected $fillable = ['name', 'url', 'module_id'];
}

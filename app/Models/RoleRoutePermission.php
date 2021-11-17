<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRoutePermission extends Model
{
    public $timestamps = FALSE;
    protected $table = 'role_route_permissions';
    protected $guarded = [];
}

<?php

namespace App\Models\Role;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    public $timestamps = FALSE;
    protected $fillable = ['title', 'actions', 'status', 'default_module_id'];
}

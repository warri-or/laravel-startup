<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBrand extends Model
{
    public $timestamps = false;
    protected $fillable = ['module-id', 'user_id', 'brand_id'];
}

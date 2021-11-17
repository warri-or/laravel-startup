<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Translation extends Model
{

    protected $table = 'translations';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

}

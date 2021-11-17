<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Tag extends Model
{
    protected $table = 'tags';
    public $timestamps = true;

    use HasTranslations;

    protected $fillable = array('name', 'status');

    public $translatable = ['name'];
}

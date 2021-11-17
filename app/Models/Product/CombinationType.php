<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class CombinationType extends Model
{
    protected $table = 'combination_types';
    public $timestamps = true;

    use HasTranslations;

    protected $fillable = array('name');
    public $translatable = ['name'];
}

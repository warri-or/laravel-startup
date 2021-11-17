<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Combination extends Model
{
    protected $table = 'combinations';
    public $timestamps = true;
    use HasTranslations;
    protected $fillable = array('combination_type_id', 'name','class_name', 'color_code');
    public $translatable = ['name','combination_type'];
}

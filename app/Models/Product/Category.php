<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{

    protected $table = 'categories';
    public $timestamps = true;

    use HasTranslations;

    protected $fillable = array('name', 'slug', 'parent_id', 'status','icon');
    public $translatable = ['name'];

    public function parent()
    {
        return $this->belongsTo(Category::class,'parent_id')->where('parent_id','=',0)->with('parent');
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id')->whereNotIn('status', [INACTIVE])->orderBy('sort_number')
            ->with('children');
    }

}

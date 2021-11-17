<?php

namespace App\Models\Product;

use App\Models\Auction\Auction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    protected $table = 'products';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('seller_id', 'name', 'description', 'additional_info', 'slug', 'is_new', 'status',
                                'meta_title', 'meta_keywords', 'meta_description','price_range_from','price_range_to');

    public function product_categories(){
        return $this->hasMany(ProductCategory::class);
    }

    public function product_tags(){
        return $this->hasMany(ProductTag::class);
    }

    public function product_combinations() {
        return $this->hasMany(ProductCombination::class);
    }

    public function aution(){
        $this->hasOne(Auction::class);
    }
}

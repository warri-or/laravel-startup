<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCombination extends Model
{
    protected $table = 'product_combinations';
    public $timestamps = true;
    protected $fillable = array('product_id', 'combination_type_id', 'combination_id', 'media_type', 'media_url', 'status','is_featured');

    public function combination(){
        return $this->belongsTo(Combination::class);
    }

    public function combination_type(){
        return $this->belongsTo(CombinationType::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}

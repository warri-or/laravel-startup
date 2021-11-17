<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPricing extends Model
{
    protected $table = 'product_pricings';
    public $timestamps = false;
    protected $fillable = array('product_id', 'price_range_from','price_range_to','start_bidding_price');
}

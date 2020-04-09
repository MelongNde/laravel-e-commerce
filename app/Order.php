<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    public function items()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id');
    }

}

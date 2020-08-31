<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = "product_image";

    public function product() {
        return $this->belongsTo('App\Models\Products', 'product_id', 'id');
    }
}

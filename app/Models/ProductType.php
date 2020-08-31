<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Extension\Extension;

class ProductType extends Model
{
    protected $table = "products_type";

    public function product() {
        return $this->hasMany('App\Models\Product', 'type_id', 'id');
    }

    public function shortDescription() {
        return Extension::shorten_string($this->description, 50);
    }
}

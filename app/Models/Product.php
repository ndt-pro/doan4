<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Extension\Extension;

class Product extends Model
{
    protected $table = "products";

    public function product_type() {
        return $this->belongsTo('App\Models\ProductType', 'type_id', 'id');
    }

    public function product_image() {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id');
    }

    public function bill_detail() {
        return $this->hasMany('App\Models\BillDetail', 'product_id', 'id');
    }

    public function getLink() {
        return Extension::convert_name($this->name);
    }

    public function getLinkImage() {
        return "storage/products/".$this->type_id."/".$this->id."/";
    }

    public function getSortLinkImage() {
        return "products/".$this->type_id."/".$this->id."/";
    }
}

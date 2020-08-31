<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = "bill_detail";

    public function bill() {
        return $this->belongsTo('App\Models\Bill', 'bill_id', 'id');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }

    public function editableArrayColor() {
        $text = '';
        foreach (json_decode($this->product->colors) as $color) {
            $text .= "{ value: '$color->value', text: '$color->name' }, ";
        }

        return "[$text]";
    }

    public function editableArraySize() {
        $text = '';
        foreach (json_decode($this->product->sizes) as $size) {
            $text .= "{ value: '$size', text: '$size' }, ";
        }

        return "[$text]";
    }

    public function getColor() {
        $color = json_decode($this->color);
        return $color;
    }

    public function totalPrice() {
        return $this->quantity * $this->price;
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = "bills";
    public $m_status = [
        ['text' => 'Chưa duyệt đơn', 'class' => 'info'],
        ['text' => 'Đã duyệt đơn', 'class' => 'primary'],
        ['text' => 'Chờ lấy hàng', 'class' => 'warning'],
        ['text' => 'Đang giao hàng', 'class' => 'primary'],
        ['text' => 'Đã giao hàng', 'class' => 'success'],
        ['text' => 'Đã hủy đơn hàng', 'class' => 'danger'],
        ['text' => 'Gửi trả hàng', 'class' => 'secondary']
    ];

    public function bill_detail() {
        return $this->hasMany('App\Models\BillDetail', 'bill_id', 'id');
    }

    public function customer() {
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public static function newCount() {
        return self::where('status', '0')->count();
    }

    public function editableArray() {
        $text = '';
        foreach ($this->m_status as $key => $value) {
            $text .= "{ value: $key, text: '$value[text]' }, ";
        }

        return "[$text]";
    }

    public function getValueStatus($css = false) {
        $status = $this->m_status[$this->status];
        if($css) {
            return "<div class=\"badge badge-$status[class]\">$status[text]</div>";
        }
        return $status['text'];
    }

    public function totalPrice() {
        $total = 0;

        foreach ($this->bill_detail as $detail) {
            $total += $detail->quantity * $detail->price;
        }

        return $total;
    }
}
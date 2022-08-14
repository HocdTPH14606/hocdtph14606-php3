<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_details extends Model
{
    protected $table = 'order_details';

    use HasFactory;
    protected $fillable = [
        'product_name',
            'product_price',
            'Total_money',
            'amount',
            'order_id',
            'product_id',
            'product_img'
    ];

    // 1 room thuộc nhiều user 
    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'id');
    } 
}

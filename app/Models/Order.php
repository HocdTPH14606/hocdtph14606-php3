<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    use HasFactory;
    protected $fillable = [
        'email',
            'address',
            'phone',
            'price',
            'note',
            'status',
            'user_id'
    ];
 
    public function order_details(){
        return $this->hasMany(Order::class, 'order_id', 'id');
    } 
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    } 
}

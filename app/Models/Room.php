<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'name',
        'status',
        'parent_id',
    ];

    // 1 room thuộc nhiều user
    public function users(){
        return $this->hasMany(User::class, 'room_id', 'id');
    }
    public function children(){
        return $this->hasMany(Room::class, 'parent_id', 'id');
    }
    public function oneParent(){
        return $this->belongsTo(Room::class, 'parent_id', 'id');
    }

    public function products(){
        return $this->hasMany(Product::class, 'room_id', 'id');
    }
}

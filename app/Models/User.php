<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',

        'username',
        'birthday',
        'phone',
        'role',
        'status',
        'room_id',
        'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'birthday' => 'date:d/m/Y'
    ];
     
    // định nghĩa quan hệ 1 user thuộc 1 Room
    // belongsTo 1 phương thức thuộc về 1 Room 
    public function room(){
        return $this->belongsTo(Room::class, 'room_id', 'id');
    } 
    public function order(){
        return $this->hasMany(Order::class, 'user_id', 'id');
    } 

    
}

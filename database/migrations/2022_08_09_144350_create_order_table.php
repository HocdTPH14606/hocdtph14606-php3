<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan make:factory OrderFactory --model=Order
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('user_id');
            $table->string('address');
            $table->string('phone');
            $table->string('price');
            $table->string('note')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }
    // 
// id 
// email
// ho_ten
// sdt
// dia_chi
// don_gia
// ngay_them
// ghi_chu
// trang_thai


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order');
    }
};

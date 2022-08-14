<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *php artisan make:factory Order_detailsFactory --model=Order_details
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id(); 
            $table->string('product_id');
            $table->string('order_id');
            $table->string('product_name');
            $table->string('product_img');
            $table->string('product_price');
            $table->string('amount');
            $table->string('Total_money'); 
            $table->timestamps();
        });
    }
     
// ma_ct	
// ma_sp	
// ten_sp	
// anh	
// gia_sp	
// thanh_tien	
// so_luong	
// ma_dh	

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
};

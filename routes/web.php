<?php
    session_start();
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Nếu báo UserController không tồn tại
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoomController;
use App\http\Controllers\AuthController;
use App\http\Controllers\CartController; 
use App\http\Controllers\ClientController;
use PhpParser\Node\Expr\FuncCall;

use Laravel\Socialite\Facades\Socialite;

Route::prefix('/admin/users')->name('users.')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('list'); //users.list
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('delete'); //name: users.delete
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user?}', [UserController::class, 'edit'])->name('edit');
    Route::put('/update/{user?}', [UserController::class, 'update'])->name('update');
});

Route::prefix('/admin/products')->name('products.')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('list'); //Products.list
    Route::get('/changeStatus', [ProductController::class, 'changeStatus'])->name('changeStatus'); //Products.changeStatus
    Route::delete('/delete/{product}', [ProductController::class, 'delete'])->name('delete'); //name: Products.delete
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/store', [ProductController::class, 'store'])->name('store');
    Route::get('/edit/{product?}', [ProductController::class, 'edit'])->name('edit');
    Route::put('/update/{product?}', [ProductController::class, 'update'])->name('update');
});  
Route::get('/admin/rooms', [RoomController::class, 'index'])->middleware('auth')->middleware('admin'); 
// middleware guest chỉ cho request khi chưa đăng nhập
Route::prefix('/admin/rooms')->name('rooms.')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', [RoomController::class, 'index'])->name('list'); //rooms.list
    Route::get('/changeStatus', [RoomController::class, 'changeStatus'])->name('changeStatus'); //rooms.changeStatus
    Route::delete('/delete/{room}', [RoomController::class, 'delete'])->name('delete'); //name: rooms.delete
    Route::get('/create', [RoomController::class, 'create'])->name('create');
    Route::post('/store', [RoomController::class, 'store'])->name('store');
    Route::get('/edit/{room?}', [RoomController::class, 'edit'])->name('edit');
    Route::put('/update/{room?}', [RoomController::class, 'update'])->name('update');
}); 
Route::prefix('/admin/carts')->name('carts.')->middleware('auth')->middleware('admin')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('list'); 
    Route::delete('/delete/{order}', [CartController::class, 'delete'])->name('delete'); 
    Route::get('/details/{order}', [CartController::class, 'details'])->name('details'); 
    Route::get('/changeStatus', [CartController::class, 'changeStatus'])->name('changeStatus');  
    Route::get('/edit/{order?}', [CartController::class, 'edit'])->name('edit');
    Route::put('/update/{order?}', [CartController::class, 'update'])->name('update');
});
Route::middleware('guest')->prefix('/auth')->name('auth.')->group(function () {
    Route::get('/login', [AuthController::class, 'getLogin'])->name('getLogin');
    Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin'); 
    Route::get('/register', [AuthController::class, 'getRegister'])->name('getRegister');
    Route::post('/register', [AuthController::class, 'postRegister'])->name('postRegister');

    //use Laravel\Socialite\Facades\Socialite;
    Route::get('/login-google', [AuthController::class, 'getLoginGoogle'])->name('getLoginGoogle'); 
    Route::get('/google/callback', [AuthController::class, 'LoginGoogle'])->name('LoginGoogle');   
});

Route::get('/auth/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::prefix('/')->name('client.')->group(function () {
    Route::get('/', [ClientController::class, 'index'])->name('client');  
    Route::get('/shop', [ClientController::class, 'shop'])->name('shop'); 
    Route::get('/contact', [ClientController::class, 'contact'])->name('contact'); 
    //detail + comment
    Route::get('/detail/{product?}', [ClientController::class, 'detail'])->name('detail'); 
    Route::post('/comment/createComment/{product?}', [ClientController::class, 'createComment'])->name('createComment'); 
    Route::delete('/comment/delete/{comment}', [ClientController::class, 'commentDelete'])->name('commentDelete');
    // Route::get('/comment/edit/{comment?}', [ClientController::class, 'commentEdit'])->name('commentEdit');
    // Route::put('/comment/update/{comment?}', [ClientController::class, 'commentUpdate'])->name('commentUpdate');

    Route::get('/productRoom/{room?}', [ClientController::class, 'productRoom'])->name('productRoom'); 

    Route::get('/checkout', [ClientController::class, 'checkout'])->name('checkout'); 
    Route::post('/order', [ClientController::class, 'order'])->name('order'); 

    Route::post('/AddCart', [ClientController::class, 'AddCart'])->name('AddCart'); 
    Route::get('/cart', [ClientController::class, 'cart'])->name('cart'); 
    Route::get('/cart/delete/{delid}', [ClientController::class, 'cartDelete'])->name('cartDelete'); 
    Route::get('/cart/cartDeleteAll', [ClientController::class, 'cartDeleteAll'])->name('cartDeleteAll'); 
}); 

//Trang quản trị:
// Quản trị sản phẩm * ok 
// Danh mục * ok 
// Người dùng * ok 

// Đơn hàng  ok
// Thống kê 

// Trang khách: * ok
// Sản phẩm, chi tiết sản phẩm, BÌNH LUẬN sản phẩm * ok
// Danh mục * ok

// GIỎ HÀNG
// MUA HÀNG

// Đăng nhập, đăng ký * ok
// Deadline: buổi 16, làm hết những phần có thể làm.

// Có validate toàn bộ các form, có upload hình ảnh * check lại

// Có sử dụng middleware để check việc user đã đăng nhập hay chưa và chuyển hướng * ok
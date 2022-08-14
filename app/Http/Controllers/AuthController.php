<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
// php artisan make:controller AuthController
class AuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login');
    }
    public function getRegister()
    {
        return view('auth.register');
    }
    public function postLogin(LoginRequest $request)
    {
        $data = $request->all();
        $email = $data['email'];
        $password = $data['password']; 
        if (Auth::attempt(['email' => $email, 'password' => $password])) { 
            return redirect()->route('users.list');
        }else{ 
            $err = 'Tài khoản hoặc mật khẩu sai';
        return redirect()->route('auth.getLogin', [ 'err' => $err]);
    } 
    }
    public function postRegister(RegisterRequest $request)
    {  
        $User = new User(); 
        $User->fill($request->all());  
        // DB::table('users')->insert([
            $User->password = Hash::make($request->password);
        // ]);

        if($request->hasFile('avatar')) { 
            $avatar = $request->avatar;
            $avatarName = $avatar->hashName();
            $avatarName = $request->productname . '_' . $avatarName; 
            $User->avatar = $avatar->storeAs('images/users', $avatarName); 
        } else {
            $User->avatar = '';
        } 
        $User->save();  

        return redirect()->route('auth.getLogin');  
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.getLogin');
    }

    public function getLoginGoogle(){
        return Socialite::driver('google')->redirect(); 
        
    }
    public function LoginGoogle(){
        $googleUser = Socialite::driver('google')->user(); 
        // dd($googleUser);
        if($googleUser){
            // 1. xem xem user này đã tồn tại trong DB chưa
            $user = User::where('email', $googleUser->email)->first();
           
            // 2. nếu tồn tại user rồi thì cho đăng nhập
            if($user){
                Auth::login($user); //Không cần check password vẫn cho đăng nhập vào và lưu thông tin
                return redirect()->route('client.client');
            }
            // 3. nếu không có user thì tạo 1 bản ghi mới từ thông tin google
            $newUser = new User();
            $newUser->fill($googleUser->user);
            $newUser->name = $googleUser->name; 
            $newUser->username = $googleUser->email; 
            $newUser->room_id = 0; 
            $newUser->email = $googleUser->email;
            $newUser->password = $googleUser->sub;
            $newUser->birthday = '';
            $newUser->role = 0;
            $newUser->status = 0;
            $newUser->phone = '';
            $newUser->avatar =  $googleUser->picture;  

            $newUser->save(); 
            return redirect()->back();
            // "sub" => "116474006100564025082"
            // "name" => "Tiến Học Đỗ"
            // "given_name" => "Tiến Học"
            // "family_name" => "Đỗ"
            // "picture" => "https://lh3.googleusercontent.com/a-/AFdZuco7IWr6GUDFYq92uHaQ5IefwTYx55IZJjzMNNX9=s96-c"
            // "email" => "babiicuteo@gmail.com"
            // "email_verified" => true
            // "locale" => "vi"
            // "id" => "116474006100564025082"
            // "verified_email" => true
            // "link" => null
        }
    }
}
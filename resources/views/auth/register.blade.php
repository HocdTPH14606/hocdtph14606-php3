@extends('layout.auth')

@section('title', 'Đăng Ký')

@section('content-title', 'Đăng Ký')

@section('content')
<div>
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
</div>
        <form action="{{route('auth.postRegister')}}" method="post" >
            @csrf
            <div class="login-box">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <b>Đăng Ký</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <input type="text" name="name" class="form-control" placeholder="name" value="{{old('name')}}">   
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" name="username" class="form-control" placeholder="username" value="{{old('username')}}">   
                        </div>
                        <div class="form-group mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">   
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password">  
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password_confirmation" class="form-control" placeholder="password_confirmation">  
                        </div> 

                        <div class='form-group mb-3'> 
                            <input type="date" name='birthday' class='form-control' placeholder="birthday" value="{{old('email')}}">
                        </div>
                        <div class='form-group mb-3'> 
                            <input type="text" name='phone' class='form-control' placeholder="phone"  value="{{old('phone')}}">
                        </div>
                        <div class='form-group mb-3'> 
                            <input type="file" name='avatar' class='form-control' placeholder="avatar"> 
                        </div>

                        <div class="social-auth-links text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Đăng Ký</button>
                        </div>
                        <div class="form-group">
                            <a href="tai-khoan/quen-mk.php"><small>Quên mật khẩu?</small></a>
                            <div><small>Bạn đã có tài khoản?</small> <a href="tai-khoan/dang-ky.php"><small>Đăng Nhập.</small></a></div>   
                        </div> 
                        <input type="hidden" name="role" value="0">
                        <input type="hidden" name="status" value="0">
                        <input type="hidden" name="room_id" value="1">
                    </div> 
                </div> 
            </div>
        </form>
@endsection
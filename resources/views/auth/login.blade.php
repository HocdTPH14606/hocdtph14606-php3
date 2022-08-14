@extends('layout.auth')

@section('title', 'Đăng nhập')

@section('content-title', 'Đăng nhập')

@section('content')
<div>
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif 
    @if (isset($_GET['err'])) 
        <ul> 
            <li>{{'Tài khoản hoặc mật khẩu sai'}}</li> 
        </ul>
    @endif
</div>
        <form action="{{route('auth.postLogin')}}" method="post" >
            @csrf
            <div class="login-box">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <b>Đăng nhập</b>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <input type="text" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">  
                        {{-- @if (isset($_SESSION["er_email"]))
                            {{ $_SESSION["er_email"]}};
                        @endif --}}
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" name="password" class="form-control" placeholder="Password"> 
                            {{-- @if (isset($_SESSION["er_pas"] ))
                            {{ $_SESSION["er_pas"] }};
                            @endif --}}
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <input name="ghi_nho" type="checkbox" checked> Ghi nhớ tài khoản?
                            </div>
                        </div>
                        <div class="social-auth-links text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                        </div>
                        <div class="form-group">
                            <a href="tai-khoan/quen-mk.php"><small>Quên mật khẩu?</small></a>
                            <div><small>Không có tài khoản?</small> <a href="tai-khoan/dang-ky.php"><small>Đăng ký.</small></a></div>   
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </form>
@endsection
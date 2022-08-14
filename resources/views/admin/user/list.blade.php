@extends('layout.master')

@section('title', 'Quản lý người dùng')

@section('content-title', 'Quản lý người dùng')

@section('content')
    <div class='my-3'>
        <a href="{{route('users.create')}}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div>
    <caption>
        <form action="{{route('users.list')}}" method="get">
            @csrf
            <input type="search" name="name" placeholder="search" value="{{$name}}" class="form-control">
        </form>
    </caption> 
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Ngày sinh</th>
                <th>Mã nhân viên</th>
                <th>Room</th>
                <th>Email</th>
                <th>Avatar</th>
                <th>Status</th>
                <th>Role</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user_list as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->birthday}}</td>
                    <td>{{$user->username}}</td>
                    {{-- nếu chỉ select và paginate thì ở đây mới thực hiện --}}
                    {{-- N+1 Query để lấy ra danh sách kèm thông tin của quan  --}}
                    <td>{{isset($user->room) ? $user->room->name : ''}}</td>
                    <td>{{$user->email}}</td>
                    <td><img src="{{asset($user->avatar)}}" alt="" width="100"></td>
                    <td>
                        <button class="toggle-class" class="btn btn-info"><input data-id="{{$user->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $user->status ? 'checked' : '' }}> 
                            {{-- @if ($user->status === 1)
                                Hiện
                            @else
                                Ẩn
                            @endif --}}
                        </button>
                    </td>
                    <td>
                        @if ($user->role === 1)
                                Admin
                            @else
                                Client
                            @endif
                    </td>
                    <td>
                        <a href="{{route('users.edit',  $user->id) }}">
                            <button class='btn btn-warning'>Chỉnh sửa</button>
                        </a>
                        <form
                            action="{{route('users.delete', $user->id)}}"
                            method="post"
                        >
                            @csrf
                            @method('DELETE')
                            <button class='btn btn-danger' onclick="return confirm('bạn có chắc muốn xóa không?')">Xoá</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $user_list->links() }}
    </div>
    <script> 
        $(function() { 
          $('.toggle-class').change(function() { 
              var status = $(this).prop('checked') == true ? 1 : 0;  
              var id = $(this).data('id');  
              $.ajax({ 
                  type: "GET", 
                  dataType: "json", 
                  url: '/admin/users/changeStatus', 
                  data: {'status': status, 'id': id}, 
                  success: function(data){ 
                    console.log(data.success) 
                  } 
              }); 
          }) 
        }) 
      </script>
@endsection

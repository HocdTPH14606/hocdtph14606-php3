@extends('layout.master')

@section('title', 'Quản lý sản phẩm')

@section('content-title', 'Quản lý sản phẩm')

@section('content')
        <caption>
            <form action="{{route('carts.list')}}" method="get">
                @csrf
                <input type="search" name="name" placeholder="search" value="{{$name}}" class="form-control">
            </form>
        </caption> 
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>SĐt</th>
                <th>Địa chỉ</th>
                <th>Giá</th>
                <th>Ghi chú</th>
                <th>Ngày đặt</th>
                <th>trạng thái</th>
                <th>Tài khoản</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->user->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->phone}}</td> 
                    <td>{{$item->address}}</td> 
                    <td>{{ number_format($item->price)}} đ </td>
                    <td>{{$item->note}}</td> 
                    <td>{{$item->created_at}}</td> 
                    <td>  
                        <button class="toggle-class" class="btn btn-info"><input data-id="{{$item->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $item->status ? 'checked' : '' }}> 
                            @if ($item->status != 0)
                                Đã hoàn thành
                            @else
                                Chưa hoàn thành
                            @endif
                        </button>
                    </td>
                    {{-- @if ($item->status = 1)
                        <td>Chưa xác nhận</td>
                    @elseif($item->status = 2)
                        <td>Đã xác nhận</td>
                    @else
                        <td>Đã hoàn thành</td>
                    @endif    --}}
                    {{-- user_id --}}
                    <td>{{isset($item->user) ? $item->user->username : ''}}</td>  
                    <td>
                            {{-- <a href="{{route('carts.edit',  $item->id) }}">
                                <button class='btn btn-warning'>Chỉnh sửa</button>
                            </a> --}}
                            <a href="{{route('carts.details',  $item->id) }}">
                                <button class='btn btn-success'>Chi tiết</button>
                            </a>
                        <form
                            action="{{route('carts.delete', $item->id)}}"
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
        {{ $orders->links() }}
    </div> 
    <script> 
        $(function() { 
          $('.toggle-class').change(function() { 
              var status = $(this).prop('checked') == true ? 1 : 0;  
              var id = $(this).data('id');  
              $.ajax({ 
                  type: "GET", 
                  dataType: "json", 
                  url: '/admin/carts/changeStatus', 
                  data: {'status': status, 'id': id}, 
                  success: function(data){ 
                    console.log(data.success) 
                  } 
              }); 
          }) 
        }) 
      </script>
@endsection

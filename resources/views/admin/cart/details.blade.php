@extends('layout.master')

@section('title', 'Quản lý sản phẩm')

@section('content-title', 'Quản lý sản phẩm')

@section('content')
        {{-- <caption>
            <form action="{{route('carts.list')}}" method="get">
                @csrf
                <input type="search" name="name" placeholder="search" value="{{$name}}" class="form-control">
            </form>
        </caption>  --}}
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th> 
                <th>Mã đơn hàng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order_details as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->product_name}}</td>
                    <td><img src="{{asset($item->product_img)}}" alt="" width="100"></td> 
                    <td>{{ number_format($item->product_price)}} đ </td>
                    <td>{{$item->amount}}</td>
                    <td>{{ number_format($item->Total_money)}} đ </td> 
                    <td>{{$item->order_id}}</td>   
                    {{-- <td>{{isset($item->order) ? $item->order->username : ''}}</td>   --}}
                    <td>
                            {{-- <a href="{{route('carts.edit',  $item->id) }}">
                                <button class='btn btn-warning'>Chỉnh sửa</button>
                            </a> --}}
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
        {{ $order_details->links() }}
    </div> 
@endsection

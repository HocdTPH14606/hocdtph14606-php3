@extends('layout.master')

@section('title', 'Quản lý sản phẩm')

@section('content-title', 'Quản lý sản phẩm')

@section('content')
    <div class='my-3'>
        <a href="{{route('products.create')}}">
            <button class='btn btn-success'>Tạo mới</button>
        </a>
    </div> 
        <caption>
            <form action="{{route('products.list')}}" method="get">
                @csrf
                <input type="search" name="name" placeholder="search" value="{{$name}}" class="form-control">
            </form>
        </caption> 
    <table class='table'>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Avatar</th>
                <th>tatus</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($product_list as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{ number_format($product->price)}} đ </td>
                    <td>{{isset($product->room) ? $product->room->name : ''}}</td>
                    <td><img src="{{asset($product->thumbnail_url)}}" alt="" width="100"></td>

                    {{-- <td>{{$product->status}}</td> --}}
                    <td> 
                        <button class="toggle-class" class="btn btn-info"><input data-id="{{$product->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $product->status ? 'checked' : '' }}> 
                            {{-- @if ($product->status === 1)
                                Hiện
                            @else
                                Ẩn
                            @endif --}}
                        </button>
                    </td>
                    <td>
                            <a href="{{route('products.edit',  $product->id) }}">
                                <button class='btn btn-warning'>Chỉnh sửa</button>
                            </a>
                        <form
                            action="{{route('products.delete', $product->id)}}"
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
        {{ $product_list->links() }}
    </div>
    <script> 
        $(function() { 
          $('.toggle-class').change(function() { 
              var status = $(this).prop('checked') == true ? 1 : 0;  
              var id = $(this).data('id');  
              $.ajax({ 
                  type: "GET", 
                  dataType: "json", 
                  url: '/admin/products/changeStatus', 
                  data: {'status': status, 'id': id}, 
                  success: function(data){ 
                    console.log(data.success) 
                  } 
              }); 
          }) 
        }) 
      </script>
@endsection

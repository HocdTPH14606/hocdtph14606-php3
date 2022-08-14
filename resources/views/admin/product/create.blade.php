@extends('layout.master')

@section('title', 'Tạo mới người dùng')

@section('content-title', 'Tạo mới người dùng')

@section('content')
        @if($errors->any())
        <ul class='danger'>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    <form
        action="{{isset($product)
            ? route('products.update', $product->id)
            : route('products.store')}}
        "
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @if (isset($product))
            @method('PUT')
        @endif
        <div class='form-group'>
            <label for="">Tên</label>
            <input type="text" name='name' class='form-control' value="{{isset($product) ? $product->name : old('name')}}">
        </div>  
        <div class='form-group'>
            <label for="">Giá</label>
            <input type="text" name='price' class='form-control' value="{{isset($product) ? $product->price : old('price')}}">
        </div>  
        <div class='form-group'>
            <label for="">Ảnh</label>
            <input type="file" name='thumbnail_url' class='form-control'>
            @if (isset($product) && $product->thumbnail_url)
                <img src="{{asset($product->thumbnail_url)}}" alt="{{$product->name}}" width="100">
            @endif
        </div>
        <div class='form-group'>
            <label for="">Danh mục</label>
            <select name="room_id" class='form-control'>
                @foreach ($rooms as $item)
                    <option value="{{$item->id}}"
                        {{(isset($product) && $product->room_id === $item->id) ? 'selected' : ''}}
                    >{{$item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class='form-group'>
            <label for="">Trạng thái</label>
            <input type="radio" name='status' value="1" {{(isset($product) && $product->status === 1) ? 'checked' : ''}}>Kích hoạt
            <input type="radio" name='status' value="0" {{(isset($product) && $product->status === 0) ? 'checked' : ''}}>Không kích hoạt
        </div>
        
        <div>
            <button class='btn btn-primary'>{{isset($product) ? 'Cập nhật' : 'Tạo mới'}}</button>
            <button type='reset' class='btn btn-warning'>Nhập lại</button>
        </div> 
    </form>
@endsection

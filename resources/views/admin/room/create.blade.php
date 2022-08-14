@extends('layout.master')

@section('title', 'Tạo mới Room')

@section('content-title', 'Tạo mới Room')

@section('content')
@if($errors->any())
<ul class='danger'>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>
    @endforeach
</ul>

@endif
    <form
        action="{{isset($room)
            ? route('rooms.update', $room->id)
            : route('rooms.store')}}
        "
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @if (isset($room))
            @method('PUT')
        @endif
        <div class='form-group'>
            <label for="">Tên</label>
            <input type="text" name='name' class='form-control' value="{{isset($room) ? $room->name : old('name')}}">
        </div>  
        <div class='form-group'>
            <label for="">Trạng thái</label>
            <input type="radio" name='status' value="1" {{(isset($room) && $room->status === 1) ? 'checked' : ''}}>Kích hoạt
            <input type="radio" name='status' value="0" {{(isset($room) && $room->status === 0) ? 'checked' : ''}}>Không kích hoạt
        </div>
        <div class='form-group'>
            <label for="">Danh mục</label>
            <select name="parent_id" class='form-control'>
                @foreach ($room_all as $item)
                    <option value="{{$item->id}}" 
                    {{(isset($room) && $room->parent_id === $item->id) ? 'selected' : ''}} >
                        {{$item->name}}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <button class='btn btn-primary'>{{isset($room) ? 'Cập nhật' : 'Tạo mới'}}</button>
            <button type='reset' class='btn btn-warning'>Nhập lại</button>
        </div> 
    </form>
@endsection

@extends('layout.master')
@section('title', 'Đăng ký user')
@section('conten')
        <h2>{{$view_title}}</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Name</th>
              <th>Age</th>
              <th>Address</th>
              <th>Stutus</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($user_list as $user)
                <tr>
                    <td>{{$user['name']}}</td>
                    <td>{{$user['age']}}</td>
                    <td>{{$user['address']}}</td>
                    @if ($user['status'] === 1)
                        <td>Kích hoạt</td>
                    @else
                        <td>Chưa kích hoạt</td>
                    @endif
                    {{-- <td>{{$user['status'] ? 'kích hoạt' : 'Chưa kích hoạt'}}</td> --}}
                </tr>
            @endforeach
          </tbody>
        </table>
      @endsection

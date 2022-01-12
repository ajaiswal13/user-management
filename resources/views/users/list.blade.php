@extends('users.layout')
@section('content')

    @php
      $i = 0;
    @endphp

    
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List of users present in database</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('user.create') }}"> Add new user</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
            {{Session::forget('success')}}
        </div>
    @endif
   
    @if(count($users)>=1)
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ Arr::get($user,'first_name') }}</td>
            <td>{{ Arr::get($user,'last_name') }}</td>
            <td>{{ Arr::get($user,'email') }}</td>
            <td>
                <form action="{{ route('user.destroy',Arr::get($user,'id')) }}" method="POST">
   
                    <a class="btn btn-info" href="{{ route('user.show',Arr::get($user,'id') ) }}">Show</a>
    
                    <a class="btn btn-primary" href="{{ route('user.edit',Arr::get($user,'id')) }}">Edit</a>
   
                    @csrf
                    @method('DELETE')
      
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @else
        <div class="alert alert-info">
            <p>No users are present in database</p>
        </div>
    @endif
      
@endsection
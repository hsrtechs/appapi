@extends('layouts.default')
@section('container')
    @if($status)
        <div class="alert alert-success">
            Successful
        </div>
    @elseif($status === false)
        <div class="alert alert-danger">
            Failed
        </div>

    @endif
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
            <tr class="bg-primary">
                <th>ID</th>
                <th>Name</th>
                <th>Credits</th>
                <th>Number</th>
                <th>Email</th>
                <th>Device ID</th>
                <th>API Key</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody class="text-normal" style="font-size: 13px;">
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->credits }}</td>
                    <td>{{ $user->number }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->device_id }}</td>
                    <td>{{ $user->access_token }}</td>
                    <td>
                        <form method="post" action="/users/{{ $user->id }}/delete">
                            <input type="hidden" name="_method" value="delete"/>
                            <label for="submit-{{$user->id}}"><i
                                        class="glyphicon glyphicon-trash btn btn-danger"></i></label>
                            <input type="hidden" name="_method" value="delete">
                            <input type="submit" class="hidden" id="submit-{{$user->id}}">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

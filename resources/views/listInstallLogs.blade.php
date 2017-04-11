@extends('layouts.default')
@section('container')

    <table class="table table-dashed">
        <thead class="bg-primary">
        <tr>
            <th>ID</th>
            <th>Package</th>
            <th>Device ID</th>
            <th>User</th>
            <th>Type</th>
            <th>Credits</th>
        </tr>
        </thead>
        <tbody>
        @foreach($installs as $install)
            <tr>
                <td>{{ $install->id }}</td>
                <td>{{ $install->package }}</td>
                <td>{{ $install->device_id }}</td>
                <td>{{ $install->user->name }}</td>
                <td>{{ $install->type }}</td>
                <td>{{ $install->credits }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
@section('head-css')
    .table-img{
    max-width : 100px;
    min-width : 50px;
    max-height : 100px;
    }
@endsection
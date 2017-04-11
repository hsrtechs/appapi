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

    <table class="table table-dashed">
        <thead class="bg-primary">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Amount</th>
            <th>Number</th>
            <th>Approve</th>
        </tr>
        </thead>
        <tbody>
        @foreach($recharges as $recharge)
            <tr>
                <td>{{ $recharge->id }}</td>
                <td>{{ $recharge->user->name }}</td>
                <td>{{ $recharge->recharge }}</td>
                <td>{{ $recharge->number }}</td>
                <td>
                    <form method="post" action="/request/recharge/{{ $recharge->id }}/approve">
                        <input type="hidden" name="_method" value="patch"/>
                        <label for="visible-{{$recharge->id}}">
                            <i class="glyphicon glyphicon-eye-{{ $recharge->approved ? 'open' : 'close' }} btn btn-{{ $recharge->approved ? 'warning' : 'success' }}"
                               title="{{ $recharge->approved ? 'Hide' : 'Approve' }}"></i>
                        </label>
                        <input type="submit" class="hidden" id="visible-{{$recharge->id}}">
                    </form>
                </td>
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
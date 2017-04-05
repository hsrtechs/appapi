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
        <thead>
            <tr>
                <th>icon</th>
                <th>id</th>
                <th>Name</th>
                <th>Package</th>
                <th>Credits</th>
                <th>Valid until</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($offers as $offer)
            <tr>
                <td><img src="{{ $offer->img }}" class="table-img img-thumbnail"/></td>
                <td>{{ $offer->id }}</td>
                <td>{{ $offer->name }}</td>
                <td>{{ $offer->package }}</td>
                <td>{{ $offer->credits }}</td>
                <td>{{ $offer->validity }} ({{ $offer->valid_until->diffForHumans() }})</td>
                <td>
                    <form method="post" action="/offers/{{ $offer->id }}/delete">
                        <input type="hidden" name="_method" value="delete" />
                        <label for="submit-{{$offer->id}}"><i class="glyphicon glyphicon-trash btn-link"></i></label>
                        <input type="submit" class="hidden" id="submit-{{$offer->id}}">
                    </form>

                    <form method="post" action="/offers/{{ $offer->id }}/switch-visibility">
                        <input type="hidden" name="_method" value="patch" />
                        <label for="visible-{{$offer->id}}">
                            <i class="glyphicon glyphicon-eye-{{ $offer->hidden ? 'open' : 'close' }}" title="{{ $offer->hidden ? 'Make Visible' : 'hide' }}"></i>
                        </label>
                        <input type="submit" class="hidden" id="visible-{{$offer->id}}">
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
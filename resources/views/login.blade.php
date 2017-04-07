@extends('layouts.default')
@section('container')
    @include('partials.errors')
    <div class="col-md-5">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <p class="text-center"><strong>Login</strong></p>
            </div>
            <div class="panel-body">
                <form method="post" action="{{ url('/login') }}">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Username" name="username"
                               value="{{ getInput('username') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="Password" name="password"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" id="name" name="submit"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
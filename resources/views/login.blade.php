@extends('layouts.default')
@section('container')
    <div class="col-md-5 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3>Login</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="{{ url('/login') }}">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Username" name="username" />
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" placeholder="Password" name="password" />
                    </div>
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" id="name" name="submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.default')
@section('container')
    @include('partials.errors')
    <div class="col-md-5 col-sm-12">

        @if($status)
            <div class="alert alert-success">
                Successful
            </div>
        @elseif($status === false)
            <div class="alert alert-danger">
                Failed
            </div>
        @endif

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3>Registration</h3>
            </div>
            <div class="panel-body">
                <form method="post" action="{{ '/registration' }}">
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" placeholder="Name"
                               value="{{ getInput('name') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="username" placeholder="Username"
                               value="{{ getInput('username') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" placeholder="Email"
                               value="{{ getInput('email') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" placeholder="Password"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
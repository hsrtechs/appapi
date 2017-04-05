@extends('layouts.default')
@section('container')
    <div class="col-md-4 col-sm-12">
        @if(hasErrors())
            <div class="alert alert-danger">
                <p class="text-center"><strong>Errors</strong></p>

                <ul>
                @foreach(getErrors() as $error)
                    <li>{{ $error[0] }}</li>
                @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="col-md-5 col-sm-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2>Add App</h2>
            </div>
            <div class="panel-body">
                <form class="text-center" method="post" action="{{ url('/') }}">
                    <input type="hidden" name="_method" value="put" />
                    <div class="form-group">
                        <input class="form-control" name="name" type="text" placeholder="App Name" value="{{ getInput('name') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="url" type="text" placeholder="App Download Url" value="{{ getInput('url') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="package_id" type="text" placeholder="Package Name" value="{{ getInput('package_id') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="credits" type="text" placeholder="Credits" value="{{ getInput('credits') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="country" type="text" placeholder="Country" value="{{ getInput('country') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" name="img" type="text" placeholder="Image Url" value="{{ getInput('img') }}"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control btn btn-primary" name="package" type="submit" placeholder="Package Name"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
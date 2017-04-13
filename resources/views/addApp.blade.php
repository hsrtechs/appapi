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
                <h2>Add App</h2>
            </div>
            <div class="panel-body">
                <form class="text-center" method="post" action="/">
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
                        <textarea class="form-control" name="img"
                                  placeholder="App Description">{{ getInput('desc') }}</textarea>
                    </div>
                    <div class="form-group">
                        <input class="form-control" placeholder="Validity" name="valid" type="date"/>
                    </div>
                    <div class="form-group">
                        <input class="form-control btn btn-primary" name="package" type="submit"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
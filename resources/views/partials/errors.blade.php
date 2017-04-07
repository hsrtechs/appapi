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

@if ($errors->count() > 0)
    <div class="col-sm-12">
        <div class="clear margin-b-sm">
            <div class="alert alert-danger" role="alert">
                <span>Can't submit the form.</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if (session()->has('status'))
    <div class="col-sm-12">
        <div class="clear margin-b-md">
            <div class="alert alert-success">
                <span>{{ session()->get('status') }}</span>
            </div>
        </div>
    </div>
@endif

@if (session()->has('warning'))
    <div class="col-sm-12">
        <div class="clear margin-b-md">
            <div class="alert alert-info" role="alert">
                <span>{{ session()->get('warning') }}</span>
            </div>
        </div>
    </div>
@endif
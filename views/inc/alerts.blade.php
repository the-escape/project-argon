@if($messages = getMessage(session('message')))

    <div class="alert alert-success">

        <ul>
            @foreach ($messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

    </div>

@endif


@if($messages = getMessage(@$errors))

    <div class="alert alert-danger">

        <p><strong>Submission failed</strong></p>

        <ul>
            @foreach ($messages as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>

    </div>

@endif

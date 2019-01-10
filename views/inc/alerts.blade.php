@if($messages = getMessage(session('message')))
    <script>
        window.notifications = window.notifications || []
        @foreach ($messages as $message)
        window.notifications.push({
            text: "{{ $message }}",
            success: true
        });
        @endforeach
    </script>
@endif


@if($messages = getMessage(@$errors))
    <script>
        window.notifications = window.notifications || []
        @foreach ($messages as $message)
        window.notifications.push({
            text: "{{ $message }}",
            success: false
        });
        @endforeach
    </script>
@endif

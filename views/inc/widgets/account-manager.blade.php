<div class="c-widget">
    <div class="c-account-widget">
        <div class="c-account-widget__top">
            <h2 class="c-account-widget__title">Your account manager</h2>

            <p>Primary contact: <strong>{{ $name }}</strong></p>
            @if(!empty($phone))
                <p>Telephone: <a href="tel:{{ $phone }}">{{ $phone }}</a></p>
            @endif
            @if(!empty($email))
                <p>Email: <a href="mailto:{{ $email }}">{{ $email }}</a></p>
            @endif
        </div>
    </div>
</div>

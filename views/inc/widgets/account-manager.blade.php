<div class="c-widget">
    <div class="c-account-widget">
        <div class="c-account-widget__top">
            <h2 class="c-account-widget__title">Your account manager</h2>
            <p>If you require further help or support please contact your designated account manager.</p>
            <br>
            <p><strong>{{ $name }}</strong></p>
            @if(!empty($phone))
                <p><a href="tel:{{ $phone }}">{{ $phone }}</a></p>
            @endif
            @if(!empty($email))
                <p><a href="mailto:{{ $email }}">{{ $email }}</a></p>
            @endif
        </div>
        <div class="c-account-widget__bottom">
            <img alt="logo" src="/argon/images/e.png">
        </div>
    </div>
</div>

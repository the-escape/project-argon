@if(isLaravelVersionPre("5.7"))
<div class="c-widget c-widget--background-image" style="background-image: url('{{ $bgImage or '' }}')">
@else
<div class="c-widget c-widget--background-image" style="background-image: url('{{ $bgImage ?? '' }}')">
@endif
    <div class="c-widget__btn-cover c-widget--centered">
        <a class="o-btn o-btn--white-outline" href="{{ route('cms:pages:manage') }}">Manage site content</a>
    </div>
</div>

<div class="c-widget">
    <form class="c-feedback-widget" action="{{ route('dashboard:submit-feedback') }}" method="post">
        <div class="c-feedback-widget__top">
            <h2 class="c-feedback-widget__title">Give us some feedback</h2>
            <textarea class="c-feedback-widget__input" name="feedback" id="feedback" placeholder="Your message"></textarea>
        </div>
        <div class="c-feedback-widget__bottom">
            <button class="o-btn o-btn--primary" type="submit">Submit</button>
        </div>
    </form>
</div>
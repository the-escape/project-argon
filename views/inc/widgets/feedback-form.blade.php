<div class="c-widget">
    @if(session()->has('throttleFeedbackSubmission') && \Carbon\Carbon::now()->lt(session('throttleFeedbackSubmission')))
        <div class="c-feedback-widget__thank-you">
            Thank you for your feedback.
        </div>
    @else
        <form class="c-feedback-widget js-feedback-form" action="{{ route('dashboard:submit-feedback') }}" method="post">
            <div class="c-feedback-widget__top">
                <h2 class="c-feedback-widget__title">Give us some feedback</h2>
                <textarea class="c-feedback-widget__input" name="feedback" id="feedback" placeholder="Your message"></textarea>
            </div>
            <div class="c-feedback-widget__bottom">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_timestamp" value="{{ time() }}">
                <input type="hidden" name="_catcher">
                <button class="o-btn o-btn--primary" type="submit">Submit</button>
            </div>
        </form>
    @endif
</div>
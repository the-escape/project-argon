<div class="c-widget">
    <form class="c-feedback-widget js-feedback-form {{ $submittedClass }}" action="{{ route('dashboard:submit-feedback') }}" method="post">

            <div class="c-feedback-widget__part--1">
                <h2 class="c-feedback-widget__title">Give us some feedback</h2>
                <p class="c-feedback-widget__message js-feedback-form-message">We are always looking to improve functionality and would appreciate your feedback.</p>
                <div class="js-form-errros"></div>
            </div>

            <div class="c-feedback-widget__part--2">

                <div class="c-feedback-widget__form">

                    <textarea class="c-feedback-widget__input js-feedback-form-input" name="feedback" id="feedback" placeholder="Your message"></textarea>
                    <div class="c-feedback-widget__bottom">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="_timestamp" value="{{ time() }}">
                        <input type="hidden" name="_catcher">
                        <button class="o-btn o-btn--sm o-btn--primary js-feedback-form-btn" type="submit">Submit</button>
                    </div>

                </div>

            </div>

            <div class="c-feedback-widget__part--3">
                <div class="c-feedback-widget__thank-you">Thank you for your feedback.</div>
            </div>

    </form>
</div>

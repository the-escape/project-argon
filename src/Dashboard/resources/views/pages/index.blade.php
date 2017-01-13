@extends ('argon::layouts.master')
@section ('class', 'bg')
@section ('body')
    <div class="dashboard">
        <div class="dashboard__header">
            <h1>Hi Hannah</h1>
            <p>Welcome back to your dashboard!</p>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="dashboard__cta dashboard__cta--manage">
                    <a href="#" class="dashboard__cta-container">
                        <span class="form__btn form__btn--transparent">MANAGE SITE CONTENT</span>
                    </a>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="dashboard__cta dashboard__cta--half">

                </div>
                <div class="dashboard__cta dashboard__cta--half">

                </div>
            </div>
            <div class="col-xs-4">
                <div class="activity">

                </div>
            </div>
        </div>
    </div>
@endsection

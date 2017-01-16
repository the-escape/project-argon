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
                    <a href="#" class="dashboard__cta-cell">
                        <div class="dashboard__cta-content">
                            <i class="icon icon--add"></i>
                            <span>CREATE NEW BLOG POST</span>
                        </div>
                    </a>
                </div>
                <div class="dashboard__cta dashboard__cta--half">
                    <a href="#" class="dashboard__cta-cell">
                        <div class="dashboard__cta-content">
                            <i class="icon icon--upload"></i>
                            <span>UPLOAD MEDIA</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="activity">
                    <div class="activity__head">
                        <div class="activity__title">
                            <i></i>
                            ACTIVITY LOG <span>(6)</span>
                        </div>
                    </div>
                    <div class="activity__content">
                        <a href="#" class="activity__event">
                            <div class="activity__user">
                                <img src="{{ asset('argon/assets/img/user.png') }}" width="36" height="36" alt="user">
                            </div>
                            <div class="activity__text">
                                <span class="title">Hannah</span>
                                <span>Amended solutions</span>
                                <span class="date">17 Feb 2016</span>
                            </div>
                        </a>
                        <a href="#" class="activity__event">
                            <div class="activity__user">
                                <img src="{{ asset('argon/assets/img/user.png') }}" width="36" height="36" alt="user">
                            </div>
                            <div class="activity__text">
                                <span class="title">Hannah</span>
                                <span>Amended solutions</span>
                                <span class="date">17 Feb 2016</span>
                            </div>
                        </a>
                        <a href="#" class="activity__event">
                            <div class="activity__user">
                                <img src="{{ asset('argon/assets/img/user.png') }}" width="36" height="36" alt="user">
                            </div>
                            <div class="activity__text">
                                <span class="title">Hannah</span>
                                <span>Amended solutions</span>
                                <span class="date">17 Feb 2016</span>
                            </div>
                        </a>
                        <a href="#" class="activity__event">
                            <div class="activity__user">
                                <img src="{{ asset('argon/assets/img/user.png') }}" width="36" height="36" alt="user">
                            </div>
                            <div class="activity__text">
                                <span class="title">Hannah</span>
                                <span>Amended solutions</span>
                                <span class="date">17 Feb 2016</span>
                            </div>
                        </a>
                        <a href="#" class="activity__event">
                            <div class="activity__user">
                                <img src="{{ asset('argon/assets/img/user.png') }}" width="36" height="36" alt="user">
                            </div>
                            <div class="activity__text">
                                <span class="title">Hannah</span>
                                <span>Amended solutions</span>
                                <span class="date">17 Feb 2016</span>
                            </div>
                        </a>
                        <a href="#" class="activity__event">
                            <div class="activity__user">
                                <img src="{{ asset('argon/assets/img/user.png') }}" width="36" height="36" alt="user">
                            </div>
                            <div class="activity__text">
                                <span class="title">Hannah</span>
                                <span>Amended solutions</span>
                                <span class="date">17 Feb 2016</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

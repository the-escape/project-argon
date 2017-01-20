@extends ('argon::layouts.master')
@section ('body')
    <div class="row">
        <div class="col-sm-6">
            <h2>Page preview</h2>
            <p>Here you can edit, duplicate, remove or re-order page content.</p>
            <div class="blocks">
                <div class="form__group">
                    <input type="text" class="form__text icon" placeholder="Search blocks">
                    <span class="icon search"></span>
                </div>
                <div class="block__container">
                    <ul id="blocks--page">
                        @include ('argon.entity::partials.block-row')
                        @include ('argon.entity::partials.block-row')
                        <li class="block block--ghost"></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <h2>Page builder</h2>
            <p>Add blocks to create your own custom page layout.</p>
            <div class="blocks">
                <div class="form__group">
                    <input type="text" class="form__text icon" placeholder="Search blocks">
                    <span class="icon search"></span>
                </div>
                <div class="block__container">
                    <ul id="blocks--options">
                        @foreach ($groups as $group)
                            @include ('argon.entity::partials.block-row', ['group' => $group])
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    <div class="footer__container">
                        <div class="footer__right">
                            <button type="submit" class="form__btn">SAVE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

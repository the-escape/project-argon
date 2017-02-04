<link rel="stylesheet" href="{{ asset('argon/assets/css/libs.min.css') }}">
<link rel="stylesheet" href="{{ asset('argon/assets/css/main.min.css') }}">
<script type="application/javascript" src="{{ asset('argon/assets/js/libs.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('argon/assets/js/main.min.js') }}"></script>

<div class="container-fluid" id="ui">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label>Field title</label>
                <input type="text" class="input form__text" placeholder="Label">
            </div>
            <div class="form-group">
                <label>Field title</label>
                <textarea class="input form__text textarea" placeholder="Label"></textarea>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="field-group">
                    <input type="text" class="input form__text" placeholder="Label">
                </div>
            </div>
            <div class="form__group">
                <div class="field-group">
                    <input type="text" class="input form__text error icon" placeholder="Label">
                    <span class="icon error"></span>
                </div>
                <div class="form__alert form__alert--error">Error alert</div>
            </div>
            <div class="form__group">
                <div class="field-group">
                    <input type="text" class="input form__text success" placeholder="Label">
                </div>
                <div class="form__alert form__alert--success">Success alert</div>
            </div>
            <div class="form-group">
                <div class="field-group">
                    <input type="text" class="input form__text icon" placeholder="Search">
                    <span class="icon search"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <button class="form__btn" disabled>PREVIEW</button>
            </div>
            <div class="form-group">
                <button class="form__btn">PREVIEW</button>
            </div>
            <div class="form-group">
                <button class="form__btn form__btn--grey" disabled>CANCEL</button>
            </div>
            <div class="form-group">
                <button class="form__btn form__btn--grey">CANCEL</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <select class="input form__text">
                <option value="">Dropdown</option>
                <option value="1">Option #1</option>
                <option value="2">Option #2</option>
                <option value="3">Option #3</option>
                <option value="4">Option #4</option>
            </select>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="checkbox">
                    <input type="checkbox">
                    <span></span><span>Label</span>
                </label>
            </div>
            <div class="form-group">
                <label class="checkbox">
                    <input type="checkbox" checked>
                    <span></span><span>Label</span>
                </label>
            </div>
            <div class="form-group">
                <label class="switch">
                    <input type="checkbox">
                    <div class="slider">
                        <span>YES</span>
                        <span>NO</span>
                    </div>
                </label>
            </div>
            <div class="form-group">
                <label class="switch">
                    <input type="checkbox" checked>
                    <div class="slider">
                        <span>YES</span>
                        <span>NO</span>
                    </div>
                </label>
            </div>
        </div>
        <div class="col-sm-4">
            <h1 class="blue">H1 TITLE TO GO HERE</h1>
            <p>H1 Supporting copy to go here</p>
            <p>&nbsp;</p>
            <h2>H2 TO GO HERE</h2>
            <p>Sub head</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent eros augue, laoreet nec est et, pellentesque finibus purus. Maecenas nec aliquam nulla. Vivamus porta ut diam sit amet aliquam. Vestibulum tempor lectus rhoncus tellus pellentesque consectetur. In euismod eros mauris. Ut sagittis eros eu ipsum egestas, eget scelerisque dui porta. Ut at imperdiet massa.</p>
        </div>
    </div>
</div>

<script>
    $('select').select2({
        minimumResultsForSearch: Infinity
    });
</script>

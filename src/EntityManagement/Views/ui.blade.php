<link rel="stylesheet" type="text/css" href="/argon/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="/argon/css/app.css">
<script src="/argon/js/jquery.min.js"></script>
<script src="/argon/js/select2.min.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label>Field title</label>
                <input type="text" class="input text" placeholder="Label">
            </div>
            <div class="form-group">
                <label>Field title</label>
                <textarea class="input text textarea" placeholder="Label"></textarea>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="field-group">
                    <input type="text" class="input text" placeholder="Label">
                </div>
            </div>
            <div class="form-group">
                <div class="field-group">
                    <input type="text" class="input text error icon" placeholder="Label">
                    <span class="icon error"></span>
                </div>
                <div class="form-alert error">Error alert</div>
            </div>
            <div class="form-group">
                <div class="field-group">
                    <input type="text" class="input text success" placeholder="Label">
                </div>
                <div class="form-alert success">Success alert</div>
            </div>
            <div class="form-group">
                <div class="field-group">
                    <input type="text" class="input text icon" placeholder="Search">
                    <span class="icon search"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <button class="button" disabled>PREVIEW</button>
            </div>
            <div class="form-group">
                <button class="button">PREVIEW</button>
            </div>
            <div class="form-group">
                <button class="button grey" disabled>CANCEL</button>
            </div>
            <div class="form-group">
                <button class="button grey">CANCEL</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <select class="input text">
                <option value="">Dropdown</option>
                <option value="1">Option #1</option>
                <option value="2">Option #2</option>
                <option value="3">Option #3</option>
                <option value="4">Option #4</option>
            </select>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox">
                        <span></span>Label
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" checked>
                        <span></span>Label
                    </label>
                </div>
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
        placeholder: 'Dropdown',
        minimumResultsForSearch: Infinity
    });
</script>

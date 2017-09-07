<?php
$id = guid();
$key = isset($key) ? $key : '';
$value = isset($value) ? $value : '';
?>
<div class="row">
    <div class="col-sm-4">
        <div class="input-group">
            <input type="text" class="form-control" name="settings[{{ $id }}][key]" placeholder="Key" value="{{ $key }}">
            <div class="input-group-addon">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <input type="text" class="form-control" name="settings[{{ $id }}][value]" placeholder="Value" value="{{ $value }}">
    </div>
</div>
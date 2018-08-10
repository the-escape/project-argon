<script type="text/template" class="tp-image">
    {multiTop}
    <div class="o-file js-media-input">
        <div class="o-file__preview">
            <div class="o-file__preview-wrap">
                <img class="js-media-input-preview">
            </div>
        </div>
        <div class="o-file__help-text">
            <div class="o-form-icon">
                <div class="o-form-icon__icon">
                    <span>Alt</span>
                </div>
                <input type="text" id="{altInputName}" name="{altInputName}" data-name="{altDataName}" data-input-item-name="alt" value="{altValue}">

                <input type="hidden" id="{widthInputName}" name="{widthInputName}" data-name="{widthDataName}" data-input-item-name="width" value="{widthValue}">
                <input type="hidden" id="{heightInputName}" name="{heightInputName}" data-name="{heightDataName}" data-input-item-name="height" value="{heightValue}">
                <input type="hidden" id="{urlInputName}" name="{urlInputName}" data-name="{urlDataName}" data-input-item-name="url" value="{urlValue}" disabled>
                <input type="hidden" id="{idInputName}" name="{idInputName}" data-name="{idDataName}" data-input-item-name="id" value="{idValue}">
            </div>
            <button class="o-btn o-btn--sm o-file__btn js-media-input-select">select</button>
        </div>
    </div>
    {multiBot}
</script>

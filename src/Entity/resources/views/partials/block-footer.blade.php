<div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="footer__container">
                    <a href="#modal"
                        class="form__btn form__btn--grey blocks__cancel"
                        data-toggle="modal"
                        data-target=".modal"
                        data-title="DO YOU WISH TO CONTINUE?"
                        data-subtitle="Unsaved changes"
                        data-message="You have unsaved changes, do you wish to continue?"
                        data-url="{{ route('cms:pages:manage') }}">CANCEL</a>
                    <button type="submit" class="form__btn">SAVE</button>
                    <div class="footer__right">
                        <button class="form__btn form__btn--grey">PREVIEW</button>
                        <button type="submit" name="publish" class="form__btn">PUBLISH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

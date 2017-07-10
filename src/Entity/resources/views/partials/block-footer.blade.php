<div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="footer__container">
                    <a href="{{ route('cms:pages:manage') }}" class="form__btn form__btn--grey modal__link">CANCEL</a>
                    @if (!isset($hideSave))
                        <button type="submit" class="form__btn">SAVE</button>
                    @endif
                    <div class="footer__right">
                        <button type="submit" name="publish" class="form__btn">PUBLISH</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

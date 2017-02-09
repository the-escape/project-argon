let wysiwyg = {
    init: function (e) {

        let elem = $(e);

        CKEDITOR.basePath = '/argon/assets/js/ckeditor/';
        CKEDITOR.config.contentsCss = CKEDITOR.basePath + 'contents.css';
        CKEDITOR.config.skin = 'moono-lisa';

        CKEDITOR.replace(e, CKEDITOR.config);

        if (elem.hasClass('error')) {
            elem.parent().addClass('error');
        }
    }
};

$('.form__wysiwyg').each(function (i, e) {
    wysiwyg.init(e);
});

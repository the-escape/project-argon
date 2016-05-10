var WYSIWYG = {

    getToolbarOptions: function(el) {
        return (typeof el.dataset.wysiwyg_toolbar !== 'undefined')
            ? [el.dataset.wysiwyg_toolbar.split(',')]
            : [CKEDITOR.config.default_toolbar];
    },

    getFormatTagsOptions: function(el) {
        // Wysiwyg enabless 'p' tag regardless of settings, It will not show it in a Format dropdown when not explicitly enebled, but will allow within editor regardless...
        // Just make it permanently enabled. Simples! ?>

        if (typeof el.dataset.wysiwyg_format_tags !== 'undefined')
        {
            if (el.dataset.wysiwyg_format_tags)
            {
                return 'p;' + el.dataset.wysiwyg_format_tags;
            }
            else
            {
                return 'p';
            }
        }
        else
        {
            return CKEDITOR.config.default_format_tags;
        }
    },

    getHeight: function(el) {
        if (typeof el.dataset.wysiwyg_height !== 'undefined')
        {
            var wysiwyg_height = parseInt(el.dataset.wysiwyg_height, 10);

            if (!isNaN(wysiwyg_height))
            {
                return wysiwyg_height;
            }
        }

        return CKEDITOR.config.default_height;
    },

    onClone: function(data) {

        var editors_present = $('.field-'+data.id).find('.ckeditor');

        if (editors_present && editors_present.length) {
            // force all wysiwyg fields to populate native equivalents and remove before cloning
            for (var i in CKEDITOR.instances)
            {
                CKEDITOR.instances[i].updateElement();
                CKEDITOR.instances[i].destroy();
            }
            $('.ckeditor').each(function(i, el)
            {
                CKEDITOR.config.toolbar = WYSIWYG.getToolbarOptions(el);
                CKEDITOR.config.height = WYSIWYG.getHeight(el);
                CKEDITOR.config.format_tags = WYSIWYG.getFormatTagsOptions(el);
                CKEDITOR.config.on = {
                    'instanceReady': function(e){}
                };
                CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config
            });
        }
    },

    init: function(el) {

        // CKEDITOR: Custom toolbar setup and initialization
        CKEDITOR.config.fontSize_sizes = '12px;13px;14px;16px;18px;20px;22px;24px;26px;27px;28px;30px;32px;';
        CKEDITOR.replaceClass = null; // disable auto initialization by class

        CKEDITOR.config.default_height = 150;
        CKEDITOR.config.default_format_tags = 'p;h1;h2;h3;h4;h5;h6';
        CKEDITOR.config.default_toolbar = ['Source', 'Format', 'FontSize', 'Bold','Italic', 'Blockquote', 'NumberedList','BulletedList', 'Image', 'Table', 'Link', 'Unlink'];

        CKEDITOR.config.toolbar = WYSIWYG.getToolbarOptions(el);
        CKEDITOR.config.height = WYSIWYG.getHeight(el);
        CKEDITOR.config.format_tags = WYSIWYG.getFormatTagsOptions(el);
        CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config

        // this way handle ckeditor error class highlighting
        var $el = $(el);
        if ($el.hasClass('error')) {
            $el.parent().addClass('error');
        }
    }

};

$('.ckeditor').each(function(i, el) {
    WYSIWYG.init(el);
});

$.subscribe('field/clone', function (e, data) {
    WYSIWYG.onClone( data );
});

// CKEDITOR: Custom toolbar setup and initialization
CKEDITOR.config.fontSize_sizes = '12px;13px;14px;16px;18px;20px;22px;24px;26px;27px;28px;30px;32px;';
CKEDITOR.replaceClass = null; // disable auto initialization by class

CKEDITOR.config.default_height = 150;
CKEDITOR.config.default_format_tags = 'p;h1;h2;h3;h4;h5;h6';
CKEDITOR.config.default_toolbar = ['Source', 'Format', 'FontSize', 'Bold','Italic', 'Blockquote', 'NumberedList','BulletedList', 'Image', 'Table', 'Link', 'Unlink'];

$('.ckeditor').each(function(i, el)
{
    CKEDITOR.config.toolbar = getWysiwygToolbarOptions(el);
    CKEDITOR.config.height = getWysiwygHeight(el);
    CKEDITOR.config.format_tags = getWysiwygFormatTagsOptions(el);
    CKEDITOR.replace(el, CKEDITOR.config); // initialize manually with custom config

    // this way handle ckeditor error class highlighting
    var $el = $(el);
    if ($el.hasClass('error'))
    {
        $el.parent().addClass('error');
    }
});

function getWysiwygToolbarOptions(el)
{
    return (typeof el.dataset.wysiwyg_toolbar !== 'undefined')
        ? [el.dataset.wysiwyg_toolbar.split(',')]
        : [CKEDITOR.config.default_toolbar];
}

function getWysiwygFormatTagsOptions(el)
{
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
}

function getWysiwygHeight(el)
{
    if (typeof el.dataset.wysiwyg_height !== 'undefined')
    {
        var wysiwyg_height = parseInt(el.dataset.wysiwyg_height, 10);

        if (!isNaN(wysiwyg_height))
        {
            return wysiwyg_height;
        }
    }

    return CKEDITOR.config.default_height;
}

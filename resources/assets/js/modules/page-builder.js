$(function () {

    let entityGroups = document.getElementById('entity-groups'),
        entityRevisionGroups = document.getElementById('entity-revision-groups');

    if (entityGroups) {
        Sortable.create(entityGroups, {
            group: {
                name: 'blocks',
                pull: true,
                put: false
            },
            ghostClass: 'block--ghost'
        });
    }

    if (entityRevisionGroups) {
        Sortable.create(entityRevisionGroups, {
            group: {
                name: 'blocks',
                pull: false,
                put: true
            },
            ghostClass: 'block--ghost',
            onSort: function (event, originalEvent) {
                //
            }
        });
    }

    $('.block__add').on('click', function (e) {
        e.preventDefault();
        let block = $(this).parents('.block');
        block.appendTo('#entity-revision-groups');
        updateBlockArray(block.data('id'));
    });

    $('.block__delete').on('click', function (e) {
        e.preventDefault();
        let block = $(this).parents('.block');
        block.appendTo('#entity-groups');
        updateBlockArray(block.data('id'));
    });

    $('.blocks__search').on('keyup', function () {
        let self = $(this);
        self.parents('.blocks').find('li').each(function () {
            let block = $(this);
            if (block.data('name').toLowerCase().search(self.val().toLowerCase()) > -1) {
                block.show();
            } else {
                block.hide();
            }
        });
    });

    $('.blocks__cancel').on('click', function (e) {
        e.preventDefault();
        //$('.modal').modal();
    });

    function updateBlockArray(itemId) {
        let blocks = $(entityRevisionGroups).find('.block'),
            currentArray = $('input[name="array"]'),
            blockArray = [];
        blocks.each(function (i, v) {
            blockArray.push($(v).data('id'));
        });
        let json = JSON.stringify(blockArray);
        if (currentArray.val() != json) {
            currentArray.val(JSON.stringify(blockArray));
        }
    }
});

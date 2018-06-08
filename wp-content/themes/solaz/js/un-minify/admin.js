(function ($) {
    "use strict";
    jQuery(document).on('click', '.edit-menu-item-use_megamenu', function (event) {
        var clickedID = jQuery(this).attr('id');
        var columnID = clickedID.replace('edit-menu-item-use_megamenu-', '');
        if (jQuery('#' + clickedID).prop('checked')) {
            jQuery('#wrap-edit-menu-item-panel_column-' + columnID).show();
            jQuery('#wrap-edit-menu-item-bg_image-' + columnID).show();
            jQuery('#wrap-edit-menu-item-bg_image1-' + columnID).show();
            jQuery('#wrap-edit-menu-item-popup_pos-' + columnID).show();
            if(jQuery('input.menu-item-data-parent-id[value="'+columnID+'"]').length) {
                jQuery('input.menu-item-data-parent-id[value="'+columnID+'"]').parent().parent().find('.wrap-edit-menu-item-mega_item_column').show();
            }
   
        } else {
            jQuery('#wrap-edit-menu-item-panel_column-' + columnID).hide();
            jQuery('#wrap-edit-menu-item-bg_image-' + columnID).hide();
            jQuery('#wrap-edit-menu-item-bg_image1-' + columnID).hide();
            jQuery('#wrap-edit-menu-item-popup_pos-' + columnID).hide();
            if(jQuery('input.menu-item-data-parent-id[value="'+columnID+'"]').length) {
                jQuery('input.menu-item-data-parent-id[value="'+columnID+'"]').parent().parent().find('.wrap-edit-menu-item-mega_item_column').hide();
            }
        }

    });

    $('.redux-messageredux-notice,#redux_dashboard_widget').remove();
    $('#redux-header').remove();
    $('<div class="redux-header"><div class="display_header"><h2>Solaz</h2><span>1.0</span></div><div class="clear"></div></div>').insertBefore('.redux-container .redux-sidebar');
})(jQuery);

var file_frame;

jQuery(document).on('click', '.button_upload_image', function (event) {

    event.preventDefault();

    var clickedID = jQuery(this).attr('id');

    // Create the media frame.
    file_frame = wp.media.frames.downloadable_file = wp.media({
        title: 'Choose an image',
        button: {
            text: 'Use image'
        },
        multiple: false
    });

    // When an image is selected, run a callback.
    file_frame.on('select', function () {
        attachment = file_frame.state().get('selection').first().toJSON();

        jQuery('#' + clickedID).val(attachment.url);
        if (jQuery('#' + clickedID).attr('data-name'))
            jQuery('#' + clickedID).attr('name', jQuery('#' + clickedID).attr('data-name'));
    });

    // Finally, open the modal.
    file_frame.open();
});

jQuery(document).on('click', '.button_remove_image', function (event) {

    var clickedID = jQuery(this).attr('id');
    jQuery('#' + clickedID).val('');

    return false;
});

jQuery(function ($) {
    function changeMenuCustomOptions(el, index) {
        var currentEl = el;
        var depthIndex = index;
        var classNames = currentEl.attr('class').split(' ');
        var parentId = currentEl.find('input.menu-item-data-parent-id').val();

        for (var i = 0; i < classNames.length; i += 1) {
            if (classNames[i].indexOf('menu-item-depth-') >= 0) {
                var depth = classNames[i].split('menu-item-depth-');
                var id = currentEl.attr('id');

                depth = parseInt(depth[1]) + depthIndex;
                id = id.replace('menu-item-', '');

                if (depth === 0) {
                    currentEl.find('.wrap-custom-options-level1-' + id).hide().find('select, input, textarea').each(function () {
                        $(this).removeAttr('name');
                    });
                    currentEl.find('.wrap-custom-options-level0-' + id).show().find('select, input[type="text"], textarea').each(function () {
                        if ($(this).val()) {
                            $(this).attr('name', $(this).data('name'));
                        } else {
                            $(this).removeAttr('name');
                        }
                    });
                    currentEl.find('.wrap-custom-options-level0-' + id).find('input[type="checkbox"]').each(function () {
                        if ($(this).is(':checked')) {
                            $(this).attr('name', $(this).data('name'));
                        } else {
                            $(this).removeAttr('name');
                        }
                    });
                } else if (depth === 1) {
                    if($('#edit-menu-item-use_megamenu-' + parentId).prop('checked')) {
                        currentEl.find('.wrap-edit-menu-item-mega_item_column').show();
                    } else {
                        currentEl.find('.wrap-edit-menu-item-mega_item_column').hide();
                    }
                    currentEl.find('.wrap-custom-options-level0-' + id).hide().find('select, input, textarea').each(function () {
                        $(this).removeAttr('name');
                    });
                    currentEl.find('.wrap-custom-options-level1-' + id).show().find('select, input[type="text"], textarea').each(function () {
                        if ($(this).val()) {
                            $(this).attr('name', $(this).data('name'));
                        } else {
                            $(this).removeAttr('name');
                        }
                    });
                    currentEl.find('.wrap-custom-options-level1-' + id).find('input[type="checkbox"]').each(function () {
                        if ($(this).is(':checked')) {
                            $(this).attr('name', $(this).data('name'));
                        } else {
                            $(this).removeAttr('name');
                        }
                    });
                } else {
                    currentEl.find('.wrap-custom-options-level0-' + id).hide().find('select, input, textarea').each(function () {
                        $(this).removeAttr('name');
                    });
                    currentEl.find('.wrap-custom-options-level1-' + id).hide().find('select, input, textarea').each(function () {
                        $(this).removeAttr('name');
                    });
                }
            }
        }
    }

    $(document).on('change', '.menu-item select, .menu-item textarea, .menu-item input[type="text"]', function () {
        var that = $(this);
        value = that.val();
        if (value) {
            that.attr('name', $(this).data('name'));
        } else {
            that.removeAttr('name');
        }
    });

    $(document).on('change', '.menu-item input[type="checkbox"]', function () {
        var currentEl = $(this);
        value = currentEl.is(':checked');
        if (value) {
            currentEl.attr('name', $(this).data('name'));
        } else {
            currentEl.removeAttr('name');
        }
    });

    $('#update-nav-menu').bind('click', function (e) {
        if (e.target && e.target.className) {
            if (-1 != e.target.className.indexOf('item-delete')) {
                var clickedEl = e.target;
                var itemID = parseInt(clickedEl.id.replace('delete-', ''), 10);
                var menu_item = $('#menu-item-' + itemID);
                var children = menu_item.childMenuItems();
                children.each(function () {
                    changeMenuCustomOptions($(this), -1);
                });
            }
        }
    });

    $("#menu-to-edit").on("sortstop", function (event, ui) {
        var menu_item = ui.item;
        setTimeout(function () {
            changeMenuCustomOptions(menu_item, 0);
            var children = menu_item.childMenuItems();
            children.each(function () {
                changeMenuCustomOptions($(this), 0);
            });
        }, 200);
    });
});

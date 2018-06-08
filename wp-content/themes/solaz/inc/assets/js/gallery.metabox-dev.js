(function($){
    "use strict"

    $(document).ready(function(){

        var imgSelectFrame,
            imgPreviews = $('#gallery-metabox ul.images-list').first();

        $(document).on('click', '#gallery-metabox a.gallery-add-images', function(e) {

            e.preventDefault();

            if ( imgSelectFrame ) imgSelectFrame.close();

            imgSelectFrame = wp.media.frames.imgSelectFrame = wp.media({
                title: $(this).data('uploader-title'),
                button: {
                    text: $(this).data('uploader-button-text'),
                },
                multiple: true
            });

            imgSelectFrame.on('select', function() {
                var listIndex = imgPreviews.children('li').index(imgPreviews.children('li:last')),
                    selection = imgSelectFrame.state().get('selection');

                selection.map(function(attachment, i) {
                    attachment = attachment.toJSON();
                    var index                   = listIndex + (i + 1),
                        attachmentThumbnailObj  = attachment.sizes.thumbnail;

                    if ( attachmentThumbnailObj == undefined ) {
                        attachmentThumbnailObj = attachment.sizes.full;
                    }

                    imgPreviews.append('<li>'
                            + '<input type="hidden" name="sn-gallery-id[' + index + ']" value="' + attachment.id + '"/>'
                            + '<img class="image-preview" src="' + attachmentThumbnailObj.url + '"/>'
                            + '<a class="change-image" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><i class="dashicons dashicons-edit"></i></a>'
                            + '<a class="remove-image" href="#"><i class="dashicons dashicons-no"></i></a>'
                        + '</li>');
                });
            });

            makeSortable();

            imgSelectFrame.open();

        });

        $(document).on('click', '#gallery-metabox a.change-image', function(e) {

            e.preventDefault();

            var _this = $(this);

            if ( imgSelectFrame ) imgSelectFrame.close();

            imgSelectFrame = wp.media.frames.imgSelectFrame = wp.media({
                title: $(this).data('uploader-title'),
                button: {
                    text: $(this).data('uploader-button-text'),
                },
                multiple: false
            });

            imgSelectFrame.on( 'select', function() {
                var attachment              = imgSelectFrame.state().get('selection').first().toJSON(),
                    attachmentThumbnailObj  = attachment.sizes.thumbnail;

                if ( attachmentThumbnailObj == undefined ) {
                    attachmentThumbnailObj = attachment.sizes.full;
                }

                var selection = imgSelectFrame.state().get('selection');
                console.log(selection);

                _this.parent().find('input:hidden').attr('value', attachment.id);
                _this.parent().find('img.image-preview').attr('src', attachmentThumbnailObj.url);
            });

            imgSelectFrame.on( 'open', function(){
                var selected = wp.media.attachment( _this.parent().find('input:hidden').attr('value') );
                var selection = imgSelectFrame.state().get('selection');
                selection.add( selected ? [selected] : [] );
                console.log(selection);
            });

            imgSelectFrame.open();

        });

        function resetIndex() {
            imgPreviews.children('li').each(function(i) {
                $(this).find('input:hidden').attr('name', 'sn-gallery-id[' + i + ']');
            });
        }

        function makeSortable() {
            imgPreviews.sortable({
                opacity: 0.6,
                stop: function() {
                    resetIndex();
                }
            });
        }

        $(document).on('click', '#gallery-metabox a.remove-image', function(e) {
            e.preventDefault();

            $(this).parents('li').animate({ opacity: 0 }, 200, function() {
                $(this).remove();
                resetIndex();
            });
        });

        makeSortable();

    });
})(jQuery);
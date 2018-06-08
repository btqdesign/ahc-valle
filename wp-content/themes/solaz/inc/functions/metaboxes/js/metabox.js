jQuery(function($){
    
    if($("input[name='special_skin']").length){
        if(!$("input[name='special_skin']").is(':checked')) {
            if($('.metabox[data-name="skin"]').length){
                $('.metabox[data-name="skin"]').hide();
            }
        }
        $("input[name='special_skin']").change(function() {
            if(!this.checked) {
                if($('.metabox[data-name="skin"]').length){
                    $('.metabox[data-name="skin"]').hide();
                }
            }else{
                if($('.metabox[data-name="skin"]').length){
                    $('.metabox[data-name="skin"]').show();
                }
            }
        });
    }
    $('.list-color li').each(function() {
        var item = $(this),
            link = item.find('a').eq(0);

        link.on('click', function(e) {
            e.preventDefault();
            $('.list-color li').each(function(){
                $(this).removeClass('selected');
            });
            $('input[name="skin"]').val($(this).closest('li').data('name'));
            link.closest('li').addClass('selected');
        });
    });
    $('.format-type').hide();
    $( ".post-type-post #gallery-metabox" ).hide();
    var post_format = $(".postbox input.post-format").attr("value");

    if($('#post-format-video').is(':checked') || $('#post-format-audio').is(':checked') ){
        $( ".post-type-video" ).show();
    }
    if($('#post-format-quote').is(':checked')){
             $( ".post-type-quote" ).show();
    }
    if($('#post-format-link').is(':checked')){
             $( ".post-type-link" ).show();
    }
    if($('#post-format-0').is(':checked') || $('#post-format-image').is(':checked')
        || $('#post-format-gallery').is(':checked')){
        $( "#view-format-boxes" ).hide();
    }
    if($('#post-format-gallery').is(':checked') ){
         $( "#post #gallery-metabox" ).show();
    }
    $('input.post-format').change(function(){
        if($(this).attr("value")=="video" || $(this).attr("value")=="audio"){
             $( ".post-type-video" ).show();
        }else{
             $( ".post-type-video" ).hide();
        }
        if($(this).attr("value")=="gallery"){
             $( "#post #gallery-metabox" ).show();
        }else{
             $( "#post #gallery-metabox" ).hide();
        }
        if($(this).attr("value")=="link"){
             $( ".post-type-link" ).show();
        }else{
             $( ".post-type-link" ).hide();
        }
        if($(this).attr("value")=="quote"){
             $( ".post-type-quote" ).show();
        }else{
             $( ".post-type-quote" ).hide();
        }
        if($(this).attr("value")=="image" || $(this).attr("value")=="0" || $(this).attr("value")=="gallery"){
             $( "#view-format-boxes" ).hide();
        }else{
             $( "#view-format-boxes" ).show();
        }
    });
        $('.arp-meta-color').each(function() {
            var $el = $(this),
                $c = $el.find('.arp-color-field'),
                $t = $el.find('.arp-color-transparency');

            $c.wpColorPicker({
                change: function( e, ui ) {
                    $( this ).val( ui.color.toString() );
                    $t.removeAttr( 'checked' );
                },
                clear: function( e, ui ) {
                    $t.removeAttr( 'checked' );
                }
            });
            $t.on('click', function() {
                if ( $( this ).is( ":checked" ) ) {
                    $c.attr('data-old-color', $c.val());
                    $c.val( 'transparent' );
                    $el.find( '.wp-color-result' ).css('background-color', 'transparent');
                } else {
                    if ( $c.val() === 'transparent' ) {
                        var oc = $c.attr('data-old-color');
                        $el.find( '.wp-color-result' ).css('background-color', oc);
                        $c.val(oc);
                    }
                }
            });
        });
});
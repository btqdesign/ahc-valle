!function(e){"use strict";e(document).ready(function(){function t(){n.children("li").each(function(t){e(this).find("input:hidden").attr("name","sn-gallery-id["+t+"]")})}function a(){n.sortable({opacity:.6,stop:function(){t()}})}var i,n=e("#gallery-metabox ul.images-list").first();e(document).on("click","#gallery-metabox a.gallery-add-images",function(t){t.preventDefault(),i&&i.close(),i=wp.media.frames.imgSelectFrame=wp.media({title:e(this).data("uploader-title"),button:{text:e(this).data("uploader-button-text")},multiple:!0}),i.on("select",function(){var e=n.children("li").index(n.children("li:last")),t=i.state().get("selection");t.map(function(t,a){t=t.toJSON();var i=e+(a+1),l=t.sizes.thumbnail;void 0==l&&(l=t.sizes.full),n.append('<li><input type="hidden" name="sn-gallery-id['+i+']" value="'+t.id+'"/><img class="image-preview" src="'+l.url+'"/><a class="change-image" href="#" data-uploader-title="Change image" data-uploader-button-text="Change image"><i class="dashicons dashicons-edit"></i></a><a class="remove-image" href="#"><i class="dashicons dashicons-no"></i></a></li>')})}),a(),i.open()}),e(document).on("click","#gallery-metabox a.change-image",function(t){t.preventDefault();var a=e(this);i&&i.close(),i=wp.media.frames.imgSelectFrame=wp.media({title:e(this).data("uploader-title"),button:{text:e(this).data("uploader-button-text")},multiple:!1}),i.on("select",function(){var e=i.state().get("selection").first().toJSON(),t=e.sizes.thumbnail;void 0==t&&(t=e.sizes.full);var n=i.state().get("selection");console.log(n),a.parent().find("input:hidden").attr("value",e.id),a.parent().find("img.image-preview").attr("src",t.url)}),i.on("open",function(){var e=wp.media.attachment(a.parent().find("input:hidden").attr("value")),t=i.state().get("selection");t.add(e?[e]:[]),console.log(t)}),i.open()}),e(document).on("click","#gallery-metabox a.remove-image",function(a){a.preventDefault(),e(this).parents("li").animate({opacity:0},200,function(){e(this).remove(),t()})}),a()})}(jQuery);
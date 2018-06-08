(function ($) {
    "use strict";
    $('.number_nav').click(function(){
        if($('.number_nav').hasClass('active')){
            $('.number_nav').removeClass('active');
            $(this).addClass('active');
        }else{
            $(this).addClass('active');            
        }
    })
    $('.vc_btn3-icon.fa-long-arrow-right').removeClass('fa-long-arrow-right').addClass('icon-arrow-right');
    $('.main-navigation ul.mega-menu > li:not(.megamenu)').mouseover(function () {
        var wapoMainWindowWidth = $(window).width();
        // checks if third level menu exist
        var subMenuExist = $(this).find('.menu-item-has-children').length;
        if (subMenuExist > 0) {
            var subMenuWidth = $(this).children('.children').width();
            var subMenuOffset = $(this).children('.children').parent().offset().left + subMenuWidth;

            // if sub menu is off screen, give new position
            if ((subMenuOffset + subMenuWidth) > wapoMainWindowWidth) {
                var newSubMenuPosition = subMenuWidth;
                $(this).addClass('left_side_menu');

            } else {
                var newSubMenuPosition = subMenuWidth;

                $(this).removeClass('left_side_menu');
            }
        }
    }); 

    //Check in date   
    var check_in_date = $('input[name="check_in_date"]');
    var check_out_date = $('input[name="check_out_date"]');
    check_in_date.datepicker({
        setDate: new Date(),
        minDate: new Date(),
        dateFormat: 'mm/dd/yy',
        onSelect: function(date) {
            var day =check_in_date.datepicker("getDate");

            var selectedDate = new Date(date);
            var msecsInADay = 86400000;
            var endDate = new Date(selectedDate.getTime() + msecsInADay);
            $(".date:not(.checkout)").find("h2.day").text($.datepicker.formatDate("dd", day));
             $(".date:not(.checkout)").find("span.month").text($.datepicker.formatDate("M", day));
            // $(".date").find("h4").text(date);
            check_out_date.datepicker( "option", "minDate", endDate );
            check_out_date.datepicker("setDate", new Date('minDate') );
            var checkout_day =check_out_date.datepicker("getDate");
            $(".date.checkout").find("h2.day").text($.datepicker.formatDate("dd", checkout_day));
            $(".date.checkout").find("span.month").text($.datepicker.formatDate("M", checkout_day));
      },    
    });

    //Check out date
    
    check_out_date.datepicker({
        setDate: new Date(),
        mindate: '+1day',
        changeMonth: true,
        dateFormat: 'mm/dd/yy',
      onSelect: function(date) {
        var day =check_out_date.datepicker("getDate");
        $(".date.checkout").find("h2.day").text($.datepicker.formatDate("dd", day));
         $(".date.checkout").find("span.month").text($.datepicker.formatDate("M", day));
        // $(".date").find("h4").text(date);
      },
    });
    $('a.next-day:not(.checkout)').click(function () {
        var $picker = check_in_date;
        var date=new Date($picker.datepicker('getDate'));
        date.setDate(date.getDate()+1);
        $picker.datepicker('setDate', date);
        var day =check_in_date.datepicker("getDate");
        $(".date:not(.checkout)").find("h2.day").text($.datepicker.formatDate("dd", day));
         $(".date:not(.checkout)").find("span.month").text($.datepicker.formatDate("M", day));  
            var selectedDate = new Date(date);
            var msecsInADay = 86400000;
            var endDate = new Date(selectedDate.getTime() + msecsInADay); 
            check_out_date.datepicker( "option", "minDate", endDate );
            check_out_date.datepicker("setDate", new Date('minDate') );
            var checkout_day =check_out_date.datepicker("getDate");
            $(".date.checkout").find("h2.day").text($.datepicker.formatDate("dd", checkout_day));
            $(".date.checkout").find("span.month").text($.datepicker.formatDate("M", checkout_day));                 
        return false;
    });
	
	$('.active-sidebar select.select_slider').removeAttr('disabled');
	$('#hotel-booking-results select.number_room_select').removeAttr('disabled');

    // Previous Day Link
    $('a.previous-day:not(.checkout)').click(function () {
        var $picker = check_in_date;
        var today = new Date();
        today.setHours(0);
        today.setMinutes(0);
        today.setSeconds(0);        
        var date=new Date($picker.datepicker('getDate'));
        date.setDate(date.getDate()-1);
        $picker.datepicker('setDate', date);
        var day =check_in_date.datepicker("getDate");
        $(".date:not(.checkout)").find("h2.day").text($.datepicker.formatDate("dd", day));
        $(".date:not(.checkout)").find("span.month").text($.datepicker.formatDate("M", day)); 
        if (Date.parse(today) <= Date.parse(date)) {
            var msecsInADay = 86400000;
            var endDate = new Date(date.getTime() + msecsInADay); 
            check_out_date.datepicker( "option", "minDate", endDate );
            check_out_date.datepicker("setDate", new Date('minDate') );
            var checkout_day =check_out_date.datepicker("getDate");
            $(".date.checkout").find("h2.day").text($.datepicker.formatDate("dd", checkout_day));
            $(".date.checkout").find("span.month").text($.datepicker.formatDate("M", checkout_day));  
        }             
        return false;
    });
    //Get Date Shortname
    Date.prototype.monthNames = [
    "January", "February", "March",
    "April", "May", "June",
    "July", "August", "September",
    "October", "November", "December"
    ];

    Date.prototype.getMonthName = function() {
        return this.monthNames[this.getMonth()];
    };
    Date.prototype.getShortMonthName = function () {
        return this.getMonthName().substr(0, 3);
    };
    var currentTime = new Date();
    currentTime.setDate(currentTime.getDate() + 1);
    var date_next_day = currentTime.getDate();
    var month_next_day = currentTime.getShortMonthName();
    if(date_next_day<10){
        date_next_day='0'+date_next_day;
    } 
    $(".date.checkout h2.day").append(date_next_day);
    $(".date.checkout span.month").append(month_next_day);
    $('a.next-day.checkout').click(function () {
        var $picker = check_out_date;
        var date=new Date($picker.datepicker('getDate'));
        date.setDate(date.getDate()+1);
        $picker.datepicker('setDate', date);
        var day =check_out_date.datepicker("getDate");
        $(".date.checkout").find("h2.day").text($.datepicker.formatDate("dd", day));
        $(".date.checkout").find("span.month").text($.datepicker.formatDate("M", day));        
        return false;
    });

    // Previous Day Link
    $('a.previous-day.checkout').click(function () {
        var $picker = check_out_date;
        var date=new Date($picker.datepicker('getDate'));
        date.setDate(date.getDate()-1);
        $picker.datepicker('setDate', date);
        var day =check_out_date.datepicker("getDate");
        $(".date.checkout").find("h2.day").text($.datepicker.formatDate("dd", day));
        $(".date.checkout").find("span.month").text($.datepicker.formatDate("M", day));        
        return false;
    }); 
    /* Filter isotop */
    $(window).load(function() {
        var container = $('.isotope').isotope({
            itemSelector: '.item',
            layoutMode: 'masonry',
            getSortData: {
                name: '.item'
            }
        });
		$('.grid-isotope').isotope({
		  itemSelector: '.grid-item',
		  masonry: {
			columnWidth: '.grid-item'
		  }
		});
		
        $('.btn-filter').on( 'click', '.button', function() {
            var filterValue = $(this).attr('data-filter');
            container.isotope({ filter: filterValue });
        });
        $('.btn-filter').each( function( i, buttonGroup ) {
            var buttonGroup = $(buttonGroup);
            buttonGroup.on( 'click', '.button', function() {
                buttonGroup.find('.active').removeClass('active');
                $(this).addClass('active');
            });
        });
    });
    var $grid = $('.isotope');
    // $grid.imagesLoaded().progress( function() {
    //       $grid.isotope('layout');
    // });
    //preloader
    $(document).ready(function($) {  
      $('.preloader').delay(1200).fadeOut();
    });
	
	// filter items on button click
	$('.button-group').on( 'click', 'button', function() {
	  var filterValue = $(this).attr('data-filter');
	  $grid.isotope({ filter: filterValue });
	  $('.button-group button').removeClass('is-checked');
	  $(this).addClass('is-checked');
	});
	
    //Select number of guest
    $(".next_child").click(function(e) {
        e.preventDefault();
        var isLastElementSelected = $('.choosing-block-child .select_slider > option:selected').index() == $('.select_slider > option').length -1;

        if (!isLastElementSelected) {     
            $('.choosing-block-child .select_slider > option:selected').removeAttr('selected').next('option').attr('selected', 'selected'); 
        } else {
               $('.choosing-block-child .select_slider > option:selected').removeAttr('selected');
               $('.choosing-block-child .select_slider > option').first().attr('selected', 'selected'); 
         }   
    });

    $(".prev_child").click(function(e) {
        e.preventDefault();
        var isFirstElementSelected = $('.choosing-block-child .select_slider > option:selected').index() == 0;

        if (!isFirstElementSelected) {
           $('.choosing-block-child .select_slider > option:selected').removeAttr('selected').prev('option').attr('selected', 'selected');
        } else {
             $('.choosing-block-child .select_slider > option:selected').removeAttr('selected');
             $('.choosing-block-child .select_slider > option').last().attr('selected', 'selected'); 
        }

    }); 
    $(".next_adults").click(function(e) {
        e.preventDefault();
        var isLastElementSelected = $('.choosing-block-adults .select_slider > option:selected').index() == $('.select_slider > option').length -1;

        if (!isLastElementSelected) {     
            $('.choosing-block-adults .select_slider > option:selected').removeAttr('selected').next('option').attr('selected', 'selected'); 
        } else {
               $('.choosing-block-adults .select_slider > option:selected').removeAttr('selected');
               $('.choosing-block-adults .select_slider > option').first().attr('selected', 'selected'); 
         }   
    });

    $(".prev_adults").click(function(e) {
        e.preventDefault();
        var isFirstElementSelected = $('.choosing-block-adults .select_slider > option:selected').index() == 0;

        if (!isFirstElementSelected) {
           $('.choosing-block-adults .select_slider > option:selected').removeAttr('selected').prev('option').attr('selected', 'selected');
        } else {
             $('.choosing-block-adults .select_slider > option:selected').removeAttr('selected');
             $('.choosing-block-adults .select_slider > option').last().attr('selected', 'selected'); 
        }

    });  
	$('.related-slider .product-grid').each(function(){ 
    
        /* Max items counting */
        var max_items = $('.related-slider').attr('data-max-items');
        var tablet_items = max_items;
        var tablet_items_v = max_items;
        if(max_items > 1){
            tablet_items = max_items - 1;
            tablet_items_v = 6;
        }
        var mobile_items = 1;
        
        /* Install Owl Carousel */
        $(this).slick({
          slidesToShow: max_items,
          slidesToScroll: 1,
          arrows: true,
		  nextArrow: '<button class="btn-prev"><i class="pe-7s-angle-left"></i></button>',
          prevArrow: '<button class="btn-next"><i class="pe-7s-angle-right"></i></button>',
          fade: false,
          infinite: true,
          variableWidth: false,

          responsive: [
            {
              breakpoint: 1025,
              settings: {
                slidesToShow: tablet_items,
                slidesToScroll: 1,
                variableWidth: false,
              }
            },
         
            {
              breakpoint: 769,
              settings: {
                slidesToShow: tablet_items,
                slidesToScroll: 1,
                variableWidth: false,
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: mobile_items,
                slidesToScroll: 1,
                variableWidth: false,
              }
            }
          ]
        });
    });
    $(document).ready(function () {
        $('.fancybox').fancybox({
		});
		$(".fancybox-thumb").fancybox({
			prevEffect	: 'none',
			nextEffect	: 'none',
			helpers	: {
				title	: {
					type: 'outside'
				},
				thumbs	: {
					width	: 70,
					height	: 50
				}
			}
		});

		if( navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/webOS/i) || 
			navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || 
			navigator.userAgent.match(/iPod/i) || navigator.userAgent.match(/BlackBerry/i) || 
			navigator.userAgent.match(/Windows Phone/i) ){ 
			var arrowpress_touch_device = true; 
		}else{ 
			var arrowpress_touch_device = false; 
		}
		// animate ux
		if( !arrowpress_touch_device && ( !$.browser.msie || (parseInt($.browser.version) > 8)) ){
			// item animate
			$('.animate-top').each(function(){
				var animate_item = $(this);
				if( animate_item.offset().top > $(window).scrollTop() + $(window).height() ){
					animate_item.css({ 'opacity':0, 'padding-top':20, 'margin-bottom':-20 });
				}else{ return; }	

				$(window).scroll(function(){
					if( $(window).scrollTop() + $(window).height() > animate_item.offset().top + 100 ){
						animate_item.animate({ 'opacity':1, 'padding-top':0, 'margin-bottom':0 }, 1200);
					}
				});					
			});
			
		// do not animate on scroll in mobile
		}else{
			return;
		}	
		
        var color = $('.ultsl-stop').css("color");
        $('.ultsl-stop').css('background',color);

        $("a.grouped_elements").fancybox();
        $('img').hover(function(e){
            $(this).data("title", $(this).attr("title")).removeAttr("title");
        });    
        $("a.cart_label").click(function(event){
            event.preventDefault();
        }); 
        
        //validate form
        $('#commentform').validate();
        //fullpage
        var fullpage_tooltips = [];
        $('#fullpage .section .number-slide h2').each(function() {
            fullpage_tooltips.push($(this).text());
        });
        //animation
        $('.animated').appear(function() {
            var item = $(this);
            var animation = item.data('animation');
            if ( !item.hasClass('visible') ) {
                var animationDelay = item.data('animation-delay');
                if ( animationDelay ) {
                    setTimeout(function(){
                        item.addClass( animation + " visible" );
                    }, animationDelay);
                } else {
                    item.addClass( animation + " visible" );
                }
            }
        });
        //One page
          $('.scroll-down a[href*=#]:not([href=#]),a[href*=#]:not([href=#]).scroll-to-bottom ').click(function(){
           $('.scroll-down a[href*=#]:not([href=#]),a[href*=#]:not([href=#]).scroll-to-bottom').removeClass('active');
           $(this).addClass('active');
           if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
            || location.hostname == this.hostname) 
           {
             
             var target = $(this.hash),           
             target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
               
             if (target.length) 
             {
            $('html,body').animate({
              scrollTop: target.offset().top - 90
            }, 500);
            return false;
             }
           }
          });
    });
	//Coming-soon date
	$('#getting-started').countdown(solaz_params.under_end_date).on('update.countdown', function(event) {
		var $this = $(this);
		if (event.elapsed) {
		  $this.html(event.strftime(''
		 + '<div class="coming-timer"><span>%D</span>days</div> '
		 + '<div class="coming-timer"><span>%H</span>hours</div>'
		 + '<div class="coming-timer"><span>%M</span>minutes</div>'
		 + '<div class="coming-timer"><span>%S</span>secs</div>'
		 + ''));
		} else {
		  $this.html(event.strftime(''
		 + '<div class="coming-timer"><span>%D</span>days</div> '
		 + '<div class="coming-timer"><span>%H</span>hours</div>'
		 + '<div class="coming-timer"><span>%M</span>minutes</div>'
		 + '<div class="coming-timer"><span>%S</span>secs</div>'
		 + ''));
		}
	});
	
    // Media product details
    if(!!$.prototype.elevateZoom) {
        $("img.zoom").elevateZoom({ zoomType: "inner", cursor: "crosshair", gallery:'thumbs_list_frame', imageCrossfade: true });
    }
	//Add class category
	$('.widget_categories ul').each(function(){
		if($(this).hasClass('children')) {
			$(this).parent().addClass('cat-item-parent');
		} 
	});
    $('.owl-carousel').each(function(){ 
    
        /* Max items counting */
        var max_items = $(this).attr('data-max-items');
        var tablet_items = max_items;
        if(max_items > 1){
            tablet_items = max_items - 1;
        }
        var mobile_items = 1;

        var autoplay_carousel = $(this).attr('data-autoplay');
        
        /* Install Owl Carousel */
        $(this).owlCarousel({
            
            items : max_items,
            navSpeed : 800,
            nav : true,
            loop  : false,
            autoplay : autoplay_carousel,
            autoplaySpeed : 800,
            navText : false,
            responsive : {
                0:{
                    items:mobile_items
                },
                481:{
                    items:tablet_items
                },
                1200:{
                    items:max_items
                }
            }                    
        }); 
    });
   
    $('.owl-prd-thumbnail').each(function(){ 
    
        /* Max items counting */
        var max_items = $(this).attr('data-max-items');
        var tablet_items = max_items;
        if(max_items > 1){
            tablet_items = max_items - 1;
        }
        var mobile_items = 1;

        var autoplay_carousel = $(this).attr('data-autoplay');
        
        /* Install Owl Carousel */
        $(this).owlCarousel({
            
            items : max_items,
            navSpeed : 800,
            nav : true,
            loop  : false,
            autoplay : autoplay_carousel,
            autoplaySpeed : 800,
            navText : true,
            responsive : {
                0:{
                    items:mobile_items
                },
                481:{
                    items:tablet_items
                },
                1200:{
                    items:max_items
                }
            }                    
        }); 
    });
    
    var w = $(window).width();
    var h = $(window).height();
    $('header:not(.header-v2) .woocommerce-search').css('height', h + 'px'); 
    $('header:not(.header-v2) .woocommerce-search').css('width', w + 'px');
    
    $('.adapt-height .vc_column-inner').css('height', h + 'px'); 
    /* remove old "view cart" text*/
	if(w > 767){
		var heightBlog = $('.blog-img').height();
		$('.blog-grid .blog-video').css('height', heightBlog - 1 + 'px'); 
		$('.blog-list .blog-video').css('height', heightBlog + 'px'); 
	}
    $('body').on('added_to_cart', function () {
        $("a.added_to_cart").remove();
    });
    // Vertical Menu
    var clickOutSite = true;
    $('.open-vertical').click(function () {
        if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $('.vertical-menu').show().animate({
                'margin-left' : 0
            }, 400);
        } else {
            $(this).removeClass('active');
            $('.vertical-menu').animate({
                'margin-left' : '-270px'
            }, 400, function () {
                $('.vertical-menu').hide()
            });
        }
        clickOutSite = false;
        setTimeout(function () {
            clickOutSite = true;
        }, 100);
    });
    $('.vertical-menu').click(function () {
        clickOutSite = false;
        setTimeout(function () {
            clickOutSite = true;
        }, 100);
    });
    $(document).click(function () {
        if (clickOutSite && $('.open-vertical').hasClass('active')) {
            $('.open-vertical').trigger('click');
        }
    });
	//Testimonial Style4
    var Testimonial = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.testimonialGallery();
        },
        testimonialGallery: function () {
            if (!$('.testimonial-style4'))
                return;
            $('.testimonial-style4').each(function () {
                var viewport = $(this).find('.testimonial-viewport').first();
                var thumbnails = $(this).find('.profile-thumbnail').first();
                var thumbs_display = thumbnails.attr('data-thumbs') ? thumbnails.attr('data-thumbs') : 6;
                var flag = false;
                if (!viewport.length || !thumbnails.length)
                    return;

                viewport.owlCarousel({
                    items: 1,
                    nav: false,
                    dotClass: 'owl-page',
                    dotsClass: 'owl-pagination',
                    mouseDrag: true,
                    autoHeight: true
                }).on('changed.owl.carousel', function (e) {
                    if (!flag) {
                        flag = true;
                        thumbnails.trigger('to.owl.carousel', [e.item.index, 200, true]);
                        flag = false;
                    }
                });

                thumbnails.owlCarousel({
                    nav: false,
                    dots: false,
                    mouseDrag: false,
                    items: thumbs_display,
                    navContainerClass: 'owl-buttons',
                    center: false,
                    navRewind: false,
                    responsive: {
                        0: {items: 1},
                        479: {items: 1},
                        768: {items: 1},
                        979: {items: 1},
                        1199: {items: thumbs_display}
                    },
                    afterInit: function (el) {
                        el.find('.owl-item').eq(0).addClass('active');
                    }
                });

                thumbnails.on('click', '.owl-item', function (e) {
                    viewport.trigger('to.owl.carousel', [$(this).index(), 500]);
                });

            });
        },
    };
    //Sub-menu
    $(function(){
        $(".dropdown-menu > li > .caret").on("click",function(e){
              $(this).toggleClass('active');
              var current=$(this).next();
              var grandparent=$(this).parent().parent();
              if($(this).hasClass('caret'))
              grandparent.find(".mega-menu li ul li ul:visible").not(current).hide();
              current.toggle();
              e.stopPropagation();
        });
    });
    
    //Scroll to top
    $(window).load(function () {
        var wd = $(window).width();
        if ($('.scroll-to-top').length) {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 1) {
                    $('.scroll-to-top').css({bottom: "25px"});
                    if(solaz_params.header_sticky_mobile != 1){
                        if(wd > 991){
                            if(solaz_params.header_sticky == 1) {
                                $('html:not(.nav-open) .site-header').addClass("is-sticky");
                            }else{
                                $('.site-header').addClass("none-sticky");
                            }
                        } 
                    }else{
                        if(solaz_params.header_sticky == 1) {
                            $('html:not(.nav-open) .site-header').addClass("is-sticky");
                        }else{
                            $('.site-header').addClass("none-sticky");
                        }
                    }
                } else {
                    $('.scroll-to-top').css({bottom: "-100px"});
                    $('.site-header').removeClass("is-sticky");
                    $('.site-header').removeClass("none-sticky");
                }
				
                if ($(this).scrollTop() > 500) {
                    $('.slide-section').addClass("active");
                }
                else {
                    $('.slide-section').removeClass("active");
                }
				
				if ($(this).scrollTop() > 130) {
                    $('.menu-menu-features-container').addClass("menu-sticky");
                }
                else {
					$('.menu-menu-features-container').removeClass("menu-sticky");
                }
            });

            $('.scroll-to-top').click(function () {
                $('html, body').animate({scrollTop: '0px'}, 800);
                return false;
            });
            // $('.scroll-to-bottom').click(function () {
            //      $("html, body").animate({ scrollTop: $(document).height() }, 800);
            //     return false;
            // });
        }
        $(document).ready(function ($) {
		//Up to top
		$('.to-top').click(function () {
			$('html, body').animate({scrollTop: '0px'}, 800);
			return false;
		});
		
        var wd = $(window).width();
            $('.bxslider').owlCarousel({
                items: 6,
                margin: 20,
                responsive : {
                    0:{
                        items:3
                    },
                    481:{
                        items:6
                    },
                }  
            });
            $(".bx-viewport #thumbs_list_frame a").click(function(event){
                event.preventDefault();
            });
        });       
        
    });
    
    //like count gallery
    $('body').on('click', '.solaz-post-like', function (event) {
        event.preventDefault();
        var heart = $(this);
        var post_id = heart.data("post_id");
        var like_type = heart.data('like_type') ? heart.data('like_type') : 'post';
        heart.html("<i id='icon-like' class='fa fa-heart-o'></i> <i id='icon-spinner' class='fa fa-spinner fa-spin'></i>");
        $.ajax({
            type: "post",
            url: ajax_var.url,
            data: "action=solaz-post-like&nonce=" + ajax_var.nonce + "&solaz_post_like=&post_id=" + post_id + "&like_type=" + like_type,
            success: function (count) {
                if (count.indexOf("already") !== -1)
                {
                    var lecount = count.replace("already", "");
                    if (lecount === "0")
                    {
                        lecount = "Like";
                    }
                    heart.prop('title', 'Like');
                    heart.removeClass("liked");
                    heart.html("<i id='icon-unlike' class='fa fa-heart-o'></i>" + lecount);
                }
                else
                {
                    heart.prop('title', 'Unlike');
                    heart.addClass("liked");
                    heart.html("<i id='icon-like' class='fa fa-heart-o'></i>" + count);
                }
            }
        });
    });
	//category sidebar  
    $("<p></p>").insertAfter(".widget_product_categories ul.product-categories > li > a");
    var $p = $(".widget_product_categories ul.product-categories > li p");
    $(".widget_product_categories ul.product-categories > li:not(.current-cat):not(.current-cat-parent) p").append('<span>+</span>');
    $(".widget_product_categories ul.product-categories > li.current-cat p").append('<span>-</span>');
    $(".widget_product_categories ul.product-categories > li.current-cat-parent p").append('<span>-</span>');
    $(".widget_product_categories ul.product-categories > li:not(.current-cat):not(.current-cat-parent) > ul").hide();

    $(".widget_product_categories ul.product-categories > li").each(function () {
        if ($(this).find("ul > li").length == 0) {
            $(this).find('p').remove();
        }

    });

    $p.click(function () {
        var $accordion = $(this).nextAll('ul');

        if ($accordion.is(':hidden') === true) {

            $(".widget_product_categories ul.product-categories > li > ul").slideUp();
            $accordion.slideDown();

            $p.find('span').remove();
            $p.append('<span>+</span>');
            $(this).find('span').remove();
            $(this).append('<span>-</span>');
        }
        else {
            $accordion.slideUp();
            $(this).find('span').remove();
            $(this).append('<span>+</span>');
        }
    });

	// Menu Lever 2
    $("<p></p>").insertAfter(".widget_product_categories ul.product-categories > li > ul > li > a");
    var $pp = $(".widget_product_categories ul.product-categories > li > ul > li p");
    $(".widget_product_categories ul.product-categories > li >ul >li > ul").hide();
    $(".widget_product_categories ul.product-categories > li > ul > li p").append('<span>+</span>');

    $(".widget_product_categories ul.product-categories > li > ul > li").each(function () {
        if ($(this).find("ul > li").length == 0) {
            $(this).find('p').remove();
        }
    });

    $pp.click(function () {
        var $accordions = $(this).nextAll('ul');

        if ($accordions.is(':hidden') === true) {

            $(".widget_product_categories ul.product-categories > li > ul > li > ul").slideUp();
            $accordions.slideDown();

            $pp.find('span').remove();
            $pp.append('<span>+</span>');
            $(this).find('span').remove();
            $(this).append('<span>-</span>');
        }
        else {
            $accordions.slideUp();
            $(this).find('span').remove();
            $(this).append('<span>+</span>');
        }
    });
	
	// Menu Lever 3
	$("<p></p>").insertAfter(".widget_product_categories ul.product-categories > li > ul > li > ul > li > a");
    var $ppp = $(".widget_product_categories ul.product-categories > li > ul > li > ul > li p");
    $(".widget_product_categories ul.product-categories > li > ul > li > ul > li > ul").hide();
    $(".widget_product_categories ul.product-categories > li > ul > li > ul > li p").append('<span>+</span>');
	
	$(".widget_product_categories ul.product-categories > li > ul > li > ul > li").each(function () {
        if ($(this).find("ul > li").length == 0) {
            $(this).find('p').remove();
        }
    });
	
	$ppp.click(function () {
        var $accordions = $(this).nextAll('ul');

        if ($accordions.is(':hidden') === true) {

            $(".widget_product_categories ul.product-categories > li > ul > li > ul > li > ul").slideUp();
            $accordions.slideDown();

            $ppp.find('span').remove();
            $ppp.append('<span>+</span>');
            $(this).find('span').remove();
            $(this).append('<span>-</span>');
        }
        else {
            $accordions.slideUp();
            $(this).find('span').remove();
            $(this).append('<span>+</span>');
        }
    });
    
	// One page features
	function scrollToElement (selector) {
		if(w > 991){
		  jQuery('html, body').animate({
			scrollTop: jQuery(selector).offset().top - 130
		  }, 300); 
		}else{
			jQuery('html, body').animate({
				scrollTop: jQuery(selector).offset().top
			}, 300);  
		}
	};
	jQuery(document).ready(function() {
		jQuery('.content-section').each(function() {
			jQuery(this).mouseenter(function(){
				clearTimeout(jQuery(this).data('timeoutId'));
			}).mouseleave(function(){
				var someElement = jQuery(this),
					timeoutId = setTimeout(function(){
					}, 450);
				//set the timeoutId, allowing us to clear this trigger if the mouse comes back over
				someElement.data('timeoutId', timeoutId); 
			});
		});
		jQuery('#menu-menu-features .menu-item').click(function(){
			scrollToElement(jQuery('#' + jQuery(this).attr('id').replace('menu-', '')));
			jQuery("#menu-menu-features .menu-item").removeClass('selected');
			jQuery(this).addClass('selected');
		});
	});
	
    /*Animation*/
    window.scrollReveal = new scrollReveal({
        mobile: false
    });
    //mini cart
    $(document).ready(function(){
        /* Menu responsive*/
        // $(".open-menu").click(function(){
        //     $('.header_center_menu').toggleClass('active');
        //     // $(".header_center_menu").slideToggle("slow");
        //     $(this).toggleClass('active');
        // });

		// $(".open-account").click(function(){
  //           $(".header-account").toggleClass('active');
  //           $(this).toggleClass('active');
  //       });
        $(".btn-open-social").click(function(){
            $(".slideDown").slideToggle("slow");
        });

    });
  
    $('#commentform .form-submit .submit').addClass("btn btn-primary");
    //remove class
    $( ".megamenu .dropdown-menu.children > li > ul.children" ).removeClass( "dropdown-menu" )
    //woocommerce
    $('body').bind('added_to_cart', function (response) {
        $('body').trigger('wc_fragments_loaded');
    });
    //tooltip
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    //last menu level 3
    //$('li.menu-item-has-children > .children li ul.children').last().addClass('menu-lv3-last');
    //ajaxload cart
    function woocommerce_add_cart_ajax_message() {
        if ($('.add_to_cart_button').length !== 0 && $('#cart_added_msg_popup').length === 0) {
            var message_div = $('<div>')
                    .attr('id', 'cart_added_msg'),
                    popup_div = $('<div>')
                    .attr('id', 'cart_added_msg_popup')
                    .html(message_div)
                    .hide();

            $('body').prepend(popup_div);
        }
    }

    woocommerce_add_cart_ajax_message();
    //Woocommerce update cart sidebar
    $('body').bind('added_to_cart', function (response) {
        $('body').trigger('wc_fragments_loaded');
        $('ul.products li .added_to_cart').remove();
        var msg = $('#cart_added_msg_popup');
        $('#cart_added_msg').html(solaz_params.ajax_cart_added_msg);
        msg.css('margin-left', '-' + $(msg).width() / 2 + 'px').fadeIn();
        window.setTimeout(function () {
            msg.fadeOut();
        }, 2000);
    });
    // tabs
    $("form.cart").on("change", "input.qty", function() {
        if (this.value === "0")
            this.value = "1";

        $(this.form).find("button[data-quantity]").data("quantity", this.value);
    });
    var tabs = $('.tabs');
    if(tabs.length){
        $('.tabs').tabs({
            beforeActivate: function(event, ui) {
                var hash = ui.newTab.children("li a").attr("href");
            },
            hide : {
                effect : "fadeOut",
                duration : 450
            },
            show : {
                effect : "fadeIn",
                duration : 450
            },
            updateHash : false
        });
    }
    $( "#accordion" ).accordion({
      collapsible: true,
      heightStyle: "content",
    });
    $('.coming-soon-container').css('height', h + 'px');
    $('.page-404').css('height', h + 'px');
    $(window).resize(function () {
        var h = $(window).height();
        $('.coming-soon-container').css('height', h + 'px');
        $('.page-404').css('height', h + 'px');
    });
	// var heightMenu = $('.main-navigation .mega-menu').height(); 
	// if(w < 992){
	// 	$('.main-navigation .mega-menu').css('height', heightMenu + 20 + 'px'); 
	// }
    $('ul.mega-menu > li.megamenu .menu-bottom').hide();
    $('ul.mega-menu > li.megamenu .menu-bottom').each(function(){
        var className = $(this).parent().parent().attr('id');
            if($(this).hasClass(className)){
                $(this).show();
            }
    });
    //Check if Safari
    if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
        $('html').addClass('safari');
    }
    //Check if MAC
     if(navigator.userAgent.indexOf('Mac')>1){
       $('html').addClass('safari');
     }
    $(window).resize(function () {
        var h = $(window).height();
        //$('.coming-soon-container').css('height', h + 'px');
         $('.adapt-height .vc_column-inner').css('height', h + 'px'); 
        var wdw = $(window).width();
		// var heightMenu = $('.main-navigation .mega-menu').height();
		if(wdw > 767){
			var heightBlog = $('.blog-img').height();
			$('.blog-grid .blog-video').css('height', heightBlog - 1 + 'px'); 
			$('.blog-list .blog-video').css('height', heightBlog + 'px'); 
		}
        if(wdw > 991){
            var left_ser = $('.page-home-4 .left-services').height();
            $('.page-home-4 .right-services').height(left_ser);
        }
		// if(wdw < 992){
		// 	$('.main-navigation .mega-menu').css('height', heightMenu + 20 + 'px'); 
		// }
        var wd = $(window).width();
        $('.bxslider').owlCarousel({
            items: 6,
            margin: 20,
            responsive : {
                0:{
                    items:3
                },
                481:{
                    items:6
                },
            }  
        });
            var hei = $('.main-images').height();
            $('.views-block').css('height', hei + 'px');
    });
    //$('.page-coming-soon .mc4wp-form button[type="submit"]').html("<i class='pe-7s-mail'></i>Notify me");
//product list view mode
if(solaz_params.type_product == 'list-default' || solaz_params.type_product == 'grid-default' || solaz_params.shop_list != true || solaz_params.type_product == ''){
    $('#grid_mode').unbind('click').click(function () {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.product_types').addClass('product-grid').removeClass('product-list');
        $products.find('li').removeClass('col-md-12 col-sm-12');
        $('this').addClass('active');
        $('#list_mode').removeClass('active');
        if (($.cookie && $.cookie('viewmodecookie') == 'list') || !$.cookie) {
            if ($toggle.length) {
                $products.fadeOut(300, function () {
                    $products.addClass('grid').removeClass('list').fadeIn(300);
                });
            }
        }
        if ($.cookie)
            $.cookie('viewmodecookie', 'grid', {
                path: '/'
            });
        return false;
    });

    $('#list_mode').unbind('click').click(function () {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.product_types').addClass('product-list').removeClass('product-grid');
        $products.find('li').addClass('col-md-12 col-sm-12');
        $(this).addClass('active');
        $('#grid_mode').removeClass('active');
        if (($.cookie && $.cookie('viewmodecookie') == 'grid') || !$.cookie) {
            if ($toggle.length) {
                $products.fadeOut(300, function () {
                    $products.addClass('list').removeClass('grid').fadeIn(300);
                });
            }
        }
        if ($.cookie)
            $.cookie('viewmodecookie', 'list', {
                path: '/'
            });
        return false;
    });

    if ($.cookie && $.cookie('viewmodecookie')) {
        var $toggle = $('.viewmode-toggle');
        if ($toggle.length) {
            var $parent = $toggle.parent();
            if ($parent.find('ul.products').hasClass('grid')) {
                $.cookie('viewmodecookie', 'grid', {
                    path: '/'
                });
            } else if ($parent.find('ul.products').hasClass('list')) {
                $.cookie('viewmodecookie', 'list', {
                    path: '/'
                });
            } else {
                $parent.find('ul.products').addClass($.cookie('viewmodecookie'));
            }
        }
    }
    if ($.cookie && $.cookie('viewmodecookie') == 'grid') {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.viewmode-toggle #grid_mode').addClass('active');
        $('.product_types').addClass('product-grid').removeClass('product-list');
        $('.viewmode-toggle #list_mode').removeClass('active');
    }
    if ($.cookie && $.cookie('viewmodecookie') == 'list') {
        var $toggle = $('.viewmode-toggle');
        var $parent = $toggle.parent();
        var $products = $parent.find('ul.products');
        $('.viewmode-toggle #grid_mode').addClass('active');
        $('.product_types').addClass('product-grid').removeClass('product-list');
        $('.viewmode-toggle #list_mode').removeClass('active');
    }
    if(solaz_params.type_product == 'grid-default' || solaz_params.shop_list != true){
        if ($.cookie && $.cookie('viewmodecookie') == null) {
            var $toggle = $('.viewmode-toggle');
            if ($toggle.length) {
                var $parent = $toggle.parent();
                $parent.find('ul.products').addClass('grid');
                $('.product_types').addClass('product-grid')
            }
            $('.viewmode-toggle #grid_mode').addClass('active');
            if ($.cookie)
                $.cookie('viewmodecookie', 'grid', {
                    path: '/'
                });
        }
    }  
    if(solaz_params.type_product == 'list-default' || solaz_params.shop_list != true){
        if ($.cookie && $.cookie('viewmodecookie') == null) {
            var $toggle = $('.viewmode-toggle');
            if ($toggle.length) {
                var $parent = $toggle.parent();
                $parent.find('ul.products').addClass('list');
                $('.product_types').addClass('product-list')
            }
            $('.viewmode-toggle #list_mode').addClass('active');
            if ($.cookie)
                $.cookie('viewmodecookie', 'list', {
                    path: '/'
                });
        }
    }      
}
    // fix placeholder IE 9
    $('[placeholder]').focus(function () {
        var input = $(this);
        if (input.val() === input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function () {
        var input = $(this);
        if (input.val() === '' || input.val() === input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
    }).blur().parents('form').submit(function () {
        $(this).find('[placeholder]').each(function () {
            var input = $(this);
            if (input.val() === input.attr('placeholder')) {
                input.val('');
            }
        });
    });

    //quantily
    $('div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)').addClass('buttons_added').append('<div class="qty-number"><span class="increase-qty plus" onclick=""><i class="pe-7s-plus"></i></span></div>').prepend('<div class="qty-number"><span class="increase-qty minus" onclick=""><i class="pe-7s-less"></i></span></div>');

    // Target quantity inputs on product pages
    $('input.qty:not(.product-quantity input.qty)').each(function () {
        var min = parseFloat($(this).attr('min'));

        if (min && min > 0 && parseFloat($(this).val()) < min) {
            $(this).val(min);
        }
    });

    $(document).off('click', '.plus, .minus').on('click', '.plus, .minus', function () {

        // Get values
        var $qty = $(this).closest('.quantity').find('.qty'),
                currentVal = parseFloat($qty.val()),
                max = parseFloat($qty.attr('max')),
                min = parseFloat($qty.attr('min')),
                step = $qty.attr('step');

        // Format values
        if (!currentVal || currentVal === '' || currentVal === 'NaN')
            currentVal = 0;
        if (max === '' || max === 'NaN')
            max = '';
        if (min === '' || min === 'NaN')
            min = 1;
        if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN')
            step = 1;

        // Change the value
        if ($(this).is('.plus')) {

            if (max && (max === currentVal || currentVal > max)) {
                $qty.val(max);
            } else {
                $qty.val(currentVal + parseFloat(step));
            }

        } else {

            if (min && (min === currentVal || currentVal < min)) {
                $qty.val(min);
            } else if (currentVal > 0) {
                $qty.val(currentVal - parseFloat(step));
            }

        }

        // Trigger change event
        $qty.trigger('change');
    });
    if($('input.qty:not(.product-quantity input.qty)').val() < 10){
      $('input.qty:not(.product-quantity input.qty)').val('0'+$('input.qty:not(.product-quantity input.qty)').val());  
    }
    $('input.qty:not(.product-quantity input.qty)').on('change', function() {
        if($(this).val() < 10 && $(this).val() > 0) {
            $(this).val('0'+$(this).val());
        }
    });
    //wishlist
    $( document ).ready( function($){
        if(typeof yith_wcwl_l10n != 'undefined') {
            var update_wishlist_count = function() {
                var data = {
                    action: 'update_wishlist_count'
                };
                $.ajax({
                    type: 'POST',
                    url: yith_wcwl_l10n.ajax_url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {

                    },
                    success   : function (data) {
                        $('a.update-wishlist span').html('('+data+')');
                    }
                });
            };

            $('body').on( 'added_to_wishlist removed_from_wishlist', update_wishlist_count );
        }
    } );
    $('.ult_acord').remove();

    // Viewby
    $( '.woocommerce-viewing' ).off( 'change' ).on( 'change', 'select.count', function() {
        $( this ).closest( 'form' ).submit();
    });
    //gallery
    var gallery_paged = $('#gallery-loadmore').data('paged');
    var gallery_page = gallery_paged ? gallery_paged + 1 : 2;
    var Gallery = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.galleryLoadmore();
        },
        galleryLoadmore: function () {
            $('#gallery-loadmore').click(function (event) {
                event.preventDefault();
                var el = $(this);
                var gallery_wrap = $('.gallery-entries-wrap');
                var url = $(this).attr('href');
                
                $('#gallery-loadmore').after('<i class="fa fa-refresh fa-spin"></i>');
                el.addClass('hide-loadmore');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {paged: gallery_page},
                    success: function (response) {
                        $('.load-more').find('.fa-spin').remove();
                        el.removeClass('hide-loadmore');
                        var result = $(response).find('.gallery-entries-wrap').html();
                        if ($().isotope) {
                            $(result).imagesLoaded(function () {
                                if (gallery_wrap.data('isotope')) {
                                    gallery_wrap.isotope('insert', $(result));
                                }
                            });
                        }
                        gallery_page++;
                        if (gallery_page > parseInt(el.data('totalpage'))) {
                            el.parent().remove();
                        }
                    }
                });
            });
        }
    };
    var GallerySc = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.galleryLoadmore();
        },
        galleryLoadmore: function () {
            $('.our-gallery-sc').each(function(f){
                var gallerysc_paged = $(this).data('paged');
                var gallerysc_page = gallerysc_paged ? gallerysc_paged + 1 : 2;
                var gallery_id = $(this).find('.gallery-entries-wrapsc').attr('id');
                var gallery_wrap = $(this).find('.gallery-entries-wrapsc');
                $(this).find('#gallery-loadmoresc').click(function (event) {
                event.preventDefault();
                var el = $(this);
                
                var url = $(this).attr('href');
                
                $(this).after('<i class="fa fa-refresh fa-spin"></i>');
                el.addClass('hide-loadmore');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {paged: gallerysc_page},
                    success: function (response) {
                        $(response).find('.our-gallery-sc').each(function(){
                            $('.load-more').find('.fa-spin').remove();
                            el.removeClass('hide-loadmore');
                            var result = $(this).find("#"+gallery_id).html();
                            if ($().isotope) {
                                $(result).imagesLoaded(function () {
                                    if (gallery_wrap.data('isotope')) {
                                        gallery_wrap.isotope('insert', $(result));
                                    }
                                });
                            }
                            
                        });
                            gallerysc_page++;
                            if (gallerysc_page > parseInt(el.data('totalpage'))) {
                                el.parent().remove();
                            }
                        
                    }
                });
            });
            });
        }
    };     
	// Blog Load More
    var blog_paged = $('#blog-loadmore').data('paged');
    var blog_page = blog_paged ? blog_paged + 1 : 2;
    var Blog = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.blogLoadmore();
        },
        blogLoadmore: function () {
            $('#blog-loadmore').click(function (event) {
                event.preventDefault();
                var el = $(this);
                var blog_wrap = $('.blog-entries-wrap');
                var url = $(this).attr('href');
                $('.load-more').append('<i class="fa fa-refresh fa-spin"></i>');
                el.addClass('hide-loadmore');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {paged: blog_page},
                    success: function (response) {
                        $('.load-more').find('.fa-spin').remove();
                        el.removeClass('hide-loadmore');
                        var result = $(response).find('.blog-entries-wrap').html();
						if ($().isotope) {
                            $(result).imagesLoaded(function () {
                                if (blog_wrap.data('isotope')) {
                                    blog_wrap.isotope('insert', $(result));
                                }
                            });
                        }
                        blog_page++;
                        if (blog_page > parseInt(el.data('totalpage'))) {
                            el.parent().remove();
                        }
                    }
                });
            });
        }
    };
	// Product Load More
    var product_paged = $('#product-loadmore').data('paged');
    var product_page = product_paged ? product_paged + 1 : 2;
    var Product = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.productLoadmore();
        },
        productLoadmore: function () {
            $('#product-loadmore').click(function (event) {
                event.preventDefault();
                var el = $(this);
                var product_wrap = $('.product-entries-wrap');
                var url = $(this).attr('href');
                $('#product-loadmore').after('<i class="fa fa-refresh fa-spin"></i>');
                el.addClass('hide-loadmore');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {paged: product_page},
                    success: function (response) {
                        $('.load-more').find('.fa-spin').remove();
                        el.removeClass('hide-loadmore');
                        var result = $(response).find('.product-entries-wrap').html();
                        if ($().isotope) {
                            $(result).imagesLoaded(function () {
                                if (product_wrap.data('isotope')) {
                                    product_wrap.isotope('insert', $(result));
                                }
                            });
                        }
                        product_page++;
                        if (product_page > parseInt(el.data('totalpage'))) {
                            el.parent().remove();
                        }
                    }
                });
            });
        }
    };

    //hb room
    var room_paged = $('#room-loadmore').data('paged');
    var room_page = room_paged ? room_paged + 1 : 2;
    var Room = {
        _initialized: false,
        init: function () {
            if (this._initialized)
                return false;
            this._initialized = true;
            this.roomLoadmore();
        },
        roomLoadmore: function () {
            $('#room-loadmore').click(function (event) {
                event.preventDefault();
                var el = $(this);
                var room_wrap = $('.room-entries-wrap');
                var url = $(this).attr('href');
                $('.load-more').append('<i class="fa fa-refresh fa-spin"></i>');
                el.addClass('hide-loadmore');
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {paged: room_page},
                    success: function (response) {
                        $('.load-more').find('.fa-spin').remove();
                        el.removeClass('hide-loadmore');
                        var result = $(response).find('.room-entries-wrap').html();
                        room_wrap.append(result);
                        room_page++;
                        if (room_page > parseInt(el.data('totalpage'))) {
                            el.parent().remove();
                        }
                    }
                });
            });
        }
    };
    $(document).ready(function () {
        Gallery.init();
        GallerySc.init();
		Testimonial.init();
        Product.init();
        Blog.init();
        Room.init();
    });

    $('.header-v3 .cart_label').click(function () {
        if($(this).parent().find('.content-filter').hasClass('active')){
            $('.mini-cart-special').addClass('active');
        }else{
            $('.mini-cart-special').removeClass('active');
        }
        if($('body').hasClass('special-cart-open')){
            $('body').removeClass('special-cart-open');
        }else{
            $('body').addClass('special-cart-open');
        }
    });
    $('.close_mini_special').click(function () {
        if($('body').hasClass('special-cart-open')){
            $('body').removeClass('special-cart-open');
        }else{
            $('body').addClass('special-cart-open');
        }
    });
	$('.overlay').click(function () {
        if($('body').hasClass('special-cart-open')){
            $('body').removeClass('special-cart-open');
        }
    });

    // Vertical Menu
  var menuspeed  = 400; // milliseconds for sliding menu animation time
  var $bdy       = $('html');
    
  $('.btn-open-menu').on('click',function(e){
    if($bdy.hasClass('openmenu')) {
      jsAnimateMenu('close');
    } else {
      jsAnimateMenu('open');
    }
  });
  $('.btn-close-menu').on('click',function(e){
    if($bdy.hasClass('openmenu')) {
      jsAnimateMenu('close');
    } else {
      jsAnimateMenu('open');
    }
  });

    
  // $('a[href$="#"]').on('click', function(e){
  //   e.preventDefault();
  // });
    $('#closeNav').on('click',function(){
        $(".nav-sections").css( "width", "0" );
        $("#page").css( "margin-left", "0" );
        $('#closeNav').css({
            'width': '0',
            'opacity' : '0',
            'left' : '0',
        }  );
        $('html').removeClass('nav-open');
        if($('html').hasClass('openmenu')){
            $('html').removeClass('openmenu');
        }  
    });
    $('.btn-menu-open').on('click',function(){
        $(".nav-sections").css( "width", "288px" );
        $("#page").css({
            "margin-left": "288px",
        });
        $('#closeNav').css({
            'width': '100%',
            'opacity' : '1',
            'left': '288px',
        } );
        $('html').addClass('nav-open');  
    });
    $('.btn-open').on('click', function(e){
        toggleFilter(this);
    });
    $('.btn-search').on('click', function(e){
        toggleFilter(this);
    });
    $('.cart_label').on('click', function(e){
        toggleFilter(this);
    });
    $('.current-open').on('click', function(e){
        toggleFilter(this);
    });
  $('.menutab').on('click',function(){
    var tabTitle='menu';
    var evt ='event';
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabTitle).style.display = "block";
    // evt.currentTarget.className += " active"; 
  });  
    
  function jsAnimateMenu(tog) {
    if(tog == 'open') {
      $bdy.addClass('openmenu');
    }
    if(tog == 'close') {
      $bdy.removeClass('openmenu');
    }
  }

})(jQuery);
// Active Cart, Search
function toggleFilter(obj){
    if(jQuery(window).width() <= 1199){
    if(jQuery(obj).parent().find('> .content-filter').hasClass('active')){
        jQuery(obj).parent().find('> .content-filter').removeClass('active');  
        jQuery(obj).removeClass('btn-active');                         
    }else{
        jQuery('.btn-open,.cart_label,.btn-search, .languges-flags > a').removeClass('btn-active');
        jQuery('.content-filter').removeClass('active');
        jQuery(obj).parent().find(' > .content-filter').addClass('active');   
        jQuery(obj).addClass('btn-active');           
    }
    }
}
// Add class IE
var ms_ie = false;
var ua = window.navigator.userAgent;
var old_ie = ua.indexOf('MSIE ');
var new_ie = ua.indexOf('Trident/');
if ((old_ie > -1) || (new_ie > -1)) {
	ms_ie = true;
}
if ( ms_ie ) {
   jQuery('body').addClass('ie-11');
}

//Check if Safari
function isSafari() {
  return /^((?!chrome).)*safari/i.test(navigator.userAgent);
}
//Check if MAC
if(navigator.userAgent.indexOf('Mac')>1){
   jQuery('html').addClass('macbook');
}
function openNav() {
    jQuery(".nav-sections").css( "width", "288px" );
    jQuery("#page").css({
        "margin-left": "288px",
    });
    jQuery('#closeNav').css({
        'width': '100%',
        'opacity' : '1',
        'left': '288px',
    } );
    jQuery('html').addClass('nav-open');

}

/* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
function closeNav() {
    jQuery(".nav-sections").css( "width", "0" );
    jQuery("#page").css( "margin-left", "0" );
    jQuery('#closeNav').css({
        'width': '0',
        'opacity' : '0',
        'left' : '0',
    }  );
    jQuery('html').removeClass('nav-open');
    if(jQuery('html').hasClass('openmenu')){
        jQuery('html').removeClass('openmenu');
    }

    // document.body.style.backgroundColor = "white";
} 
function menu_tab(evt, tabTitle) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabTitle).style.display = "block";
    evt.currentTarget.className += " active";
}
if(document.getElementById("defaultOpen")){
 // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen").click();   
}
function is_Rirefox(){
 return /^((?!firefox).)*firefox/i.test(navigator.userAgent);
}
if(navigator.userAgent.indexOf('Firefox') > -1) {
    jQuery('body').addClass('firefox');
}
jQuery(document).ready(function(){
	
	moment.tz.add('America/Mexico_City|LMT MST CST CDT CWT|6A.A 70 60 50 50|012121232324232323232323232323232323232323232323232323232323232323232323232323232323232323232323232|-1UQF0 deL0 8lc0 17c0 10M0 1dd0 gEn0 TX0 3xd0 Jb0 6zB0 SL0 e5d0 17b0 1Pff0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 1fB0 WL0 1fB0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0|20e6');
	
	jQuery('#btq-date-start').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: '+0d',
		onSelect: function(dateSelected){
			if (
				jQuery('#btq-date-end').val() == '' || 
				moment(jQuery('#btq-date-end').val(), 'DD/MM/YYYY').tz('America/Mexico_City').subtract(1,'day').date() <= moment(dateSelected, 'DD/MM/YYYY').tz('America/Mexico_City').subtract(1,'day').date()
			) {	
				jQuery('#btq-date-end').datepicker('option', { 
					minDate: moment(dateSelected, 'DD/MM/YYYY').tz('America/Mexico_City').subtract(1,'day').date()
				})
				.datepicker('setDate', moment(dateSelected, 'DD/MM/YYYY').subtract(1,'day').tz('America/Mexico_City').date())
				.datepicker('refresh');
				
				jQuery('#btq-date-end').val(moment(dateSelected, 'DD/MM/YYYY').tz('America/Mexico_City').add(1,'day').format('DD/MM/YYYY'));
			}
			else {
				jQuery('#btq-date-end').datepicker('option', { 
					minDate: moment(dateSelected, 'DD/MM/YYYY').tz('America/Mexico_City').subtract(1,'day').date()
				})
				.datepicker('refresh');
			}
	    }
	});
	
	jQuery('#btq-date-end').datepicker({
		dateFormat: 'dd/mm/yy',
		minDate: '+1d'
	});
	
	jQuery.getJSON( '/wp-content/plugins/btq-booking-tc/assets/js/btq-unavailable.json', {}).done(function(data) {
		jQuery('#btq-date-start').datepicker('option', {
			beforeShowDay: function(date){
				var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
				return [ data.indexOf(string) == -1 ]
    		}
		})
		.datepicker('refresh');
		
		jQuery('#btq-date-end').datepicker('option', {
			beforeShowDay: function(date){
				var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
				return [true, 'btq-unavailable-day']
    		}
		})
		.datepicker('refresh');
	});
	
	function vermas() {
		jQuery('.texto_recorrido').hide();
		jQuery('.vermas').click(function () {
			jQuery(this).parent().children('.texto_recorrido').slideToggle(200);
			jQuery(this).text('');
			jQuery(this).parent().css('display','inherit');
			jQuery(this).parent().children('.texto_recorrido').css('display','contents');
			
		});
		jQuery('.texto_recorrido').slideUp(200);
	}
	vermas();

	
	
	jQuery('#btq-booking-tc-form').submit(false);
	
	jQuery('#btq-search').click(function() {
		btq_btn_search();
	});
	
	jQuery('#btq-btn-rooms').click(function() {
		jQuery('#btq-btn-rooms').addClass('btn-default');
		jQuery('#btq-btn-packages').removeClass('btn-default');
		jQuery('#btq-btn-top').removeClass('btn-default');
		
		jQuery('#btq-type-query').val('rooms');
		
		var today = new Date();
		if((jQuery('#btq-date-start').datepicker('getDate') <= today) || (jQuery('#btq-date-end').datepicker('getDate') <= today)){
			btq_btn_rooms();
		}
		else if ((jQuery('#btq-date-start').datepicker('getDate') > today) && (jQuery('#btq-date-end').datepicker('getDate') > today)){
			btq_btn_search();
		}
		else {
			console.log('#btq-btn-rooms nada');
		}
	});
	
	jQuery('#btq-btn-packages').click(function() {
		jQuery('#btq-btn-rooms').removeClass('btn-default');
		jQuery('#btq-btn-packages').addClass('btn-default');
		jQuery('#btq-btn-top').removeClass('btn-default');
		
		jQuery('#btq-type-query').val('packages');
		
		var today = new Date();
		if((jQuery('#btq-date-start').datepicker('getDate') <= today) || (jQuery('#btq-date-end').datepicker('getDate') <= today)){
			btq_btn_packages();
		}
		else if ((jQuery('#btq-date-start').datepicker('getDate') > today) && (jQuery('#btq-date-end').datepicker('getDate') > today)){
			btq_btn_search();
		}
		else {
			console.log('#btq-btn-packages nada');
		}
	});
	
	jQuery('#btq-btn-top').click(function() {
		jQuery('#btq-btn-rooms').removeClass('btn-default');
		jQuery('#btq-btn-packages').removeClass('btn-default');
		jQuery('#btq-btn-top').addClass('btn-default');
		
		jQuery('#btq-type-query').val('rooms');
		
		var today = new Date();
		if((jQuery('#btq-date-start').datepicker('getDate') <= today) || (jQuery('#btq-date-end').datepicker('getDate') <= today)){
			btq_btn_rooms();
		}
		else if ((jQuery('#btq-date-start').datepicker('getDate') > today) && (jQuery('#btq-date-end').datepicker('getDate') > today)){
			btq_btn_search();
		}
		else {
			console.log('#btq-btn-rooms nada');
		}
	});
	
	function btq_btn_packages(){
		console.log('#btq-btn-packages click function');
		
		jQuery('#btq-booking-tc-form').submit(function(e){ e.preventDefault(); });
		
		jQuery("#wait").css("display", "block");
		
		jQuery(".preloader").css("display", "block");
		jQuery.post(
		    '/wp-admin/admin-ajax.php', 
		    {
				'action' : 'btq_booking_tc_grid_packages',
				'data' : {
					btq_packages_init : 'OK'
				}
		    }, 
		    function(response) {
				jQuery('#btq-booking-grid').html(response);
				jQuery(".preloader").css("display", "none");
				vermas();
		    }
		)
		.done(function() {
			jQuery(".preloader").css("display", "none");
		})
		.fail(function() {
			jQuery(".preloader").css("display", "none");
		});
	}
	
	function btq_btn_rooms(){
		console.log('#btq-btn-rooms click function');
		
		jQuery('#btq-booking-tc-form').submit(function(e){ e.preventDefault(); });
		
		jQuery("#wait").css("display", "block");
		
		jQuery(".preloader").css("display", "block");
		jQuery.post(
		    '/wp-admin/admin-ajax.php', 
		    {
				'action' : 'btq_booking_tc_grid_rooms',
				'data' : {
					btq_rooms_init : 'OK'
				}
		    }, 
		    function(response) {
				jQuery('#btq-booking-grid').html(response);
				jQuery(".preloader").css("display", "none");
				vermas();
		    }
		)
		.done(function() {
			jQuery(".preloader").css("display", "none");
		})
		.fail(function() {
			jQuery(".preloader").css("display", "none");
		});
	}
	
	function btq_btn_search(){
		console.log('#btq-search click function');
		
		jQuery('#btq-booking-tc-form').submit(function(e){ e.preventDefault(); });
		
		jQuery("#wait").css("display", "block");
		
		jQuery(".preloader").css("display", "block");
		jQuery.post(
		    '/wp-admin/admin-ajax.php', 
		    {
				'action' : 'btq_booking_tc_grid',
				'data' : {
					btq_date_start   : moment( jQuery('#btq-date-start').datepicker('getDate') ).tz('America/Mexico_City').format('YYYY-MM-DD'), 
					btq_date_end     : moment( jQuery('#btq-date-end').datepicker('getDate')   ).tz('America/Mexico_City').format('YYYY-MM-DD'),
					btq_type_query   : jQuery('#btq-type-query').val(),
					btq_num_rooms    : jQuery('#btq-num-rooms').val(),
					btq_num_adults   : jQuery('#btq-num-adults').val(),
					btq_num_children : jQuery("#btq-num-children").val()
				}
		    }, 
		    function(response) {
				jQuery('#btq-booking-grid').html(response);
				jQuery(".preloader").css("display", "none");
				vermas();
		    }
		)
		.done(function() {
			jQuery(".preloader").css("display", "none");
		})
		.fail(function() {
			jQuery(".preloader").css("display", "none");
		});
	}
});
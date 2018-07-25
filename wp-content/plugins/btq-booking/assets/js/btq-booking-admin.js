(function($) {
    $(function() {
        // Add Color Picker to all inputs that have 'color-field' class
        $('#btq_booking_color_principal').wpColorPicker();
        
        // Aplica la clase hide
        if ($('input[type=radio][name=btq_booking_service]:checked').val() == 'tc'){
	        $('#btq_booking_tc_form_settings').removeClass('hide');
			$('#btq_booking_iph_form_settings').addClass('hide');
        }
        else if ($('input[type=radio][name=btq_booking_service]:checked').val() == 'iph'){
	        $('#btq_booking_iph_form_settings').removeClass('hide');
			$('#btq_booking_tc_form_settings').addClass('hide');
        }
        else {
	        $('#btq_booking_tc_form_settings').addClass('hide');
	        $('#btq_booking_iph_form_settings').addClass('hide');
        }
    });
    
    // Formulario de opciones
    $('input[type=radio][name=btq_booking_service]').change(function() {
		if (this.value == 'tc') {
			console.log("Travel Click");
			$('#btq_booking_tc_form_settings').removeClass('hide');
			$('#btq_booking_iph_form_settings').addClass('hide');
		}
		else if (this.value == 'iph') {
			console.log("Internet Power Hotel");
			$('#btq_booking_iph_form_settings').removeClass('hide');
			$('#btq_booking_tc_form_settings').addClass('hide');
		}
	});
	
	$(document).ready(function(){
		$('.datepicker').datepicker({
			dateFormat: 'dd/mm/yy'
		});
		
		$('#btq-admin-search').click(function() {
			btq_admin_btn_search();
		});

	});
	
	function btq_admin_btn_search(){
		console.log('#btq-admin-search click function');
		
		moment.tz.add('America/Mexico_City|LMT MST CST CDT CWT|6A.A 70 60 50 50|012121232324232323232323232323232323232323232323232323232323232323232323232323232323232323232323232|-1UQF0 deL0 8lc0 17c0 10M0 1dd0 gEn0 TX0 3xd0 Jb0 6zB0 SL0 e5d0 17b0 1Pff0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 1fB0 WL0 1fB0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0|20e6');
		
		$('#btq-admin-booking-form').submit(function(e){ e.preventDefault(); });
		
		//$("#wait").css("display", "block");
		//$(".preloader").css("display", "block");
		
		$.post(
		    '/wp-admin/admin-ajax.php', 
		    {
				'action' : 'btq_booking_admin_grid',
				'data' : {
					btq_date_start   : moment( $('#btq-date-start').datepicker('getDate') ).tz('America/Mexico_City').format('YYYY-MM-DD'), 
					btq_date_end     : moment( $('#btq-date-end').datepicker('getDate')   ).tz('America/Mexico_City').format('YYYY-MM-DD'),
					btq_type_query   : $('#btq-type-query').val(),
					btq_num_rooms    : $('#btq-num-rooms').val(),
					btq_num_adults   : $('#btq-num-adults').val(),
					btq_num_children : $("#btq-num-children").val()
				}
		    }, 
		    function(response) {
				$('#btq-booking-admin-result').html(response);
				//$(".preloader").css("display", "none");
		    }
		)
		.done(function() {
			//$(".preloader").css("display", "none");
		})
		.fail(function() {
			//$(".preloader").css("display", "none");
		});
	}
})(jQuery);
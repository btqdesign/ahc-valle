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
	});
})(jQuery);
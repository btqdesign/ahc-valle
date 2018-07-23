(function($) {
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('#btq_booking_color_principal').wpColorPicker();
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
})(jQuery);
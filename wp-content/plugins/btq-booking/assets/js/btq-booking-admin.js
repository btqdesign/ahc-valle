(function($) {
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('#btq_booking_color_principal').wpColorPicker();
    });
    
    // Formulario de opciones
    $('input[type=radio][name=btq_booking_service]').change(function() {
		if (this.value == 'tc') {
			alert("Travel Click");
		}
		else if (this.value == 'iph') {
			alert("Internet Power Hotel");
		}
	});
})(jQuery);
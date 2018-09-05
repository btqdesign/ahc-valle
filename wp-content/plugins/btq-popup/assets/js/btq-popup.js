jQuery(document).ready(function(){
	setTimeout(function(){
		if(Cookies.get('modalShown')) {
			jQuery('#Top5razones').modal('show');
			Cookies.set('modalShown', true);
		}
	},9000);
});

function btq_windows_size(){
	var isMobile = navigator.userAgent.toLowerCase().match(/android|ipad|ipod|iphone|windows phone/i) !== null ? navigator.userAgent.toLowerCase().match(/android|ipad|ipod|iphone|windows phone/i)[0] : false;
}
(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(document).ready(function() {
	 	$('body').on('click', '.k8affil-btn', function(event) {
	 		event.preventDefault();
	 		var $but = $(this),
	 				$prld = $('.k8affil-prld'),
	 				act = $but.attr('data-action');
	 		// console.log(act);
	 		$prld.css('display', 'block');
	 		
	 		$.ajax({
				type: 'POST',
				dataType: 'json',
				url: k8All.ajaxurl,
				data: {
					'action': act,
				},
				success: function (data) {
					$but.addClass('dis').attr('disabled', 'disabled');
					$prld.css('display', 'none');

					// if ( data.error ) {
					// 	var $mod = $('#modd__err'),
					// 	txt = '<p>';
					// 	data.error.forEach(function (item, index) {
					// 	  txt = txt + item + '</p><p>';
					// 	});
					// 	txt = txt + '</p>';
					// 	$mod.find('.modd__txt').html( txt );
					// 	$('body').addClass('ov-hidd');
					// 	$mod.css('display', 'block');
					// }
					// else{
					// 	$('#modd__succ').css('display', 'block');
					// 	setTimeout(function(){
					// 		window.location.replace("https://vavt.de/link/ppt");
					// 	}, 1000);
					// }
					console.log(data);
				}
			});
	 	});
	 });

})( jQuery );

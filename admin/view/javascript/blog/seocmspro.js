	/*
	WebFontConfig = {
	google: { families: [ 'Roboto:400,400italic,700:latin,cyrillic-ext' ] }
	};
	(function() {
	var wf = document.createElement('script');
	wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
	'://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
	wf.type = 'text/javascript';
	wf.async = 'true';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(wf, s);
	})();
     */
$(document).ready(function() {
	$('button.close').click(function() {
		$('.success , .warning' ).remove();
	});

$('#menu a').css('box-sizing', 'content-box' );

});
$(function() {
	$('#nav-login a').click(function() {
		$('#nav-login').children().toggleClass('hidden');
	});

	//this handles any forms that should be submitted to the Ajax Controller
	//they -must- have a route in routes.php, action, and method
	$('.axform').submit(function(e) {
		submitAjax($(this));
		e.preventDefault();
	});
});

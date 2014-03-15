$(function() {
	$('#nav-login a').click(function() {
		$('#nav-login').children().toggleClass('hidden');
	});

    $('#request-exam').click(function(e) {
        submitAjax($(this));
        e.preventDefault();
        console.log('click');
    });
});

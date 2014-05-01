$(function() {
	//this handles any forms that should be submitted to the Ajax Controller
	//they -must- have a route in routes.php, action, and method
	$('.axform').submit(function(e) {
		submitAjax($(this));
		e.preventDefault();
	});

    $('.file-form').submit(function(e) {
        e.preventDefault();
        $(this).children('button').innerHTML = 'Uploading...';
    });

    $('#request-training').submit(function(e) {
        e.preventDefault();

        var now = new Date();
        var month = now.getMonth();
        var date = now.getDate();
        var year = now.getFullYear();
        var hour = now.getHours();
        var minutes = now.getMinutes();

        var start = $('.datepick:eq(0)').val();
        if(start == '') { start = year + "-" + month + "-" + date + " " + hour + ":" + minutes + ":00"; }
        var end = $('.datepick:eq(1)').val();
        if(end == '') { end = year + "-" + month + "-" + date + " " + hour + ":" + minutes + ":00"; }
        $.ajax({
            url: '/t/request/new',
            type: 'post',
            data: {
                'start': start,
                'end': end,
                'user': document.getElementById('userid').value,
                'cert': document.getElementById('examid').value
            }
        }).done(function(msg) {
                msg = JSON.parse(msg);
                if(msg.success)
                {
                    $('#flash').prepend(msg.message);
                }
                else $('#flash').prepend(msg.message);
            });
    });

    $('#pm-reply').submit(function(e) {
        if(! validateCC($(this)))
        {
            e.preventDefault();
        }

    });
});

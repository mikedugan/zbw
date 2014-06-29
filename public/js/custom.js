$(function() {
    $('.file-control').bootstrapFileInput({'data-filename-placement': 'inside'});
    //$('input[type=file]').bootstrapFileInput();
    highlightCorrect();
    $('.datepick').datetimepicker({
        language: 'en',
        inline: true,
        minDate:'0',
        maxDate: '+1970/01/30',
        onChangeDateTime: function(dp, $input)
        {
            var field = $(this.prev()[0]).data('field');
            document.getElementById(field).value = $input.val();
        }
    });

	$('#slideshow').slidesjs({
		width: 900,
		height: 400,
		pagination: {
			active: false
		},
		play: {
			active: false,
			// [boolean] Generate the play and stop buttons.
			// You cannot use your own buttons. Sorry.
			interval: 4000,
			// [number] Time spent on each slide in milliseconds.
			auto: true,
			// [boolean] Start playing the slideshow on load.
			swap: false,
			// [boolean] show/hide stop and play buttons
			pauseOnHover: true,
			// [boolean] pause a playing slideshow on hover
			restartDelay: 2500
			// [number] restart delay on inactive slideshow
		},
		effect: {
			slide: {
				speed: 2000
			},
			fade: {
				speed: 2000,
				crossfade: true
			}
		}
	});
    if($('#training'))
    {
        var nVal = $('#training .progress-bar').attr('aria-valuenow');
        var width = (nVal / 58 ) * 100;
        $('#training .progress-bar').css('width', width + '%');
    }

    $('.editor').redactor({
        buttons: ['bold', 'italic', 'underline', 'unorderedlist', 'orderedlist', 'outdent', 'indent',
        'image', 'link']
    });
    $('.raptor').raptor();
});

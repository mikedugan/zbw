$(function() {
	$('#slideshow').slidesjs({
		width: 900,
		height: 400,
		pagination: {
			active: true,
			effect: "slide"
		},
		play: {
			active: true,
			// [boolean] Generate the play and stop buttons.
			// You cannot use your own buttons. Sorry.
			interval: 4000,
			// [number] Time spent on each slide in milliseconds.
			auto: true,
			// [boolean] Start playing the slideshow on load.
			swap: true,
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
});

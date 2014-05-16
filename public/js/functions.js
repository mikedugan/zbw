/**
 * @short submits ajax forms where no user input is required
 * @param form jQuery form object
 */
function submitAjax(form)
{
    $.ajax({
        url: $(form).attr('action'),
        type: $(form).attr('method')
        //data: { type: $('subType').value, id: $('subId').value },
        //dataType: "json"
    })
        .done(function(msg) {
            msg = JSON.parse(msg);
            if(msg.success)
            {
                $('.ajax-success').removeClass('hidden');
                $('.ajax-success .message').text(msg.message);
            }
            else
            {
                $('.ajax-error').removeClass('hidden');
                $('.ajax-error .message').text(msg.message);
            }
        });
}

/**
 *
 */
function highlightCorrect()
{
    var ca = $('.correct-answer').toArray();
    ca.forEach(function(a) {
        var v = $(a)[0].value;
        var correct = $(a).next().children('li')[v - 1];
        $(correct).addClass('correct');
    });
}

/**
 *
 * @param number
 * @returns {string}
 */
function pad2(number) {
    return (number < 10 ? '0' : '') + number
}

/**
 *
 * @param sH    start hour
 * @param eH    end hour
 * @param sM    start minute
 * @param eM    end minute
 * @returns {number}
 */
function getTotalTime(sH, eH, sM, eM) {
    var t = (eH - sH) * 60 + (eM - sM);
    console.log(t);
    return t;
}

/**
 * @short validates a cc line from a reply form
 * @param form jQuery object
 */
function validateCC(form)
{
    if(form.find('#cc').val() == '') return true;
    var message = "Are you sure you want to CC the following: \r\n";
    var userstring = form.find('#cc').val().replace(' ', '').split(',');
    userstring.forEach(function(v, k)
    {
        var user = $('#userlist').find('[data-initials="'+v+'"]');
        message += ' '+user.data('name')+'('+v+')'+"\r\n";
    });
    return window.confirm(message);
}

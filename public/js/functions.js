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

function getCarbonDate(addHours)
{
    var now = new Date();
    var year = now.getFullYear();
    var month = pad2(now.getMonth());
    var day = pad2(now.getDate());
    var h = pad2(now.getHours());
    var m = pad2(now.getMinutes());
    var s = pad2(now.getSeconds());
    return month+'-'+day+'-'+year+' '+h+':'+m+':'+s;
}

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

/**
 * this registers a listener to prevent users from submitting training requests without changing the date
 */
function createDateChangeListener()
{
    var start_change = 0;
    var end_change = 0;

    $('#session_end').on('change', function(e) {
        end_change++;
    });
    $('#session_start').on('change', function(e) {
        start_change++;
    });
    $('.datepick').on('change', function(e) {
        if(start_change > 0 && end_change > 0) {
            $('button[type=submit]').removeAttr('disabled');
        }
    });
}

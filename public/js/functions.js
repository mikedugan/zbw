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
                $('#flash').prepend(msg.message);
            }
            else $('#flash').prepend(msg.message);
        });
}

function highlightCorrect()
{
    var ca = $('.correct-answer').toArray();
    ca.forEach(function(a) {
        var v = $(a)[0].value;
        var correct = $(a).next().children('li')[v - 1];
        $(correct).addClass('correct');
    });
}

function pad2(number) {
    return (number < 10 ? '0' : '') + number
}

function getTotalTime(sH, eH, sM, eM) {
    var t = (eH - sH) * 60 + (eM - sM);
    console.log(t);
    return t;
}

function validateCC(form)
{
    var message = "Are you sure you want to CC the following: \r\n";
    var userstring = form.find('#cc').val().replace(' ', '').split(',');
    userstring.forEach(function(v, k)
    {
        var user = $('#userlist').find('[data-initials="'+v+'"]');
        message += ' '+user.data('name')+'('+v+')'+"\r\n";
    });
    window.confirm(message);
}

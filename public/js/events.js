$(function() {
    $('form').submit(function(e) {
        $this = $(this);
        var selects = $this.find('select');
        if(selects.length > 0) {
            for(var i = 0; i < selects.length; i++) {
                if(selects[i].value == 'reqd') {
                    alert('Please make sure all dropdowns have a selected value');
                    e.preventDefault();
                    return false;
                }
            }
        }
    });


    //this handles any forms that should be submitted to the Ajax Controller
    //they -must- have a route in routes.php, action, and method
    $('.axform').submit(function (e){
            submitAjax($(this));
            setTimeout(function() { location.reload(); }, 2000);
            e.preventDefault();
    });

    $('.confirm').submit(function (e){
            var message = 'Are you sure?\n' + $(this).data('warning');
            return window.confirm(message);
    });

    $('.file-form').submit(function (e){
            e.preventDefault();
            $(this).children('button').innerHTML = 'Uploading...';
    });

    $('button[type="reset"]').click(function (e){
            $('.editor').val('');
    });
    $('#visit #cid').keyup(function (){
        var $this = $(this);
        if ($this.val() > 100000 && $this.length < 9999999) {
            var data = '';
            $(this).parent().removeClass('has-error').addClass('has-success');
            if ($('.spinner').length == 0) {
                $(this).parent().after('<div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>');
            }
            $.get(
                'http://' + window.location.host + '/status/' + $this.val(),
                data,
                function (msg)
                {
                    msg = $.parseXML(msg);
                    $msg = $(msg);
                    var ln = $msg.find('name_last').text();
                    var fn = $msg.find('name_first').text();
                    var rating = $msg.find('rating').text();
                    var home = $msg.find('division').text();
                    $('.spinner').remove();
                    $('#fname').val(fn).parent().removeClass('hidden');
                    $('#lname').val(ln).parent().removeClass('hidden');
                    $('#rating').val(rating).parent().removeClass('hidden');
                    $('#home').val(home).parent().removeClass('hidden');
                    $('#artcc').parent().removeClass('hidden');
                }
            );
        } else {
            $(this).parent().addClass('has-feedback has-error');
            $('#fname').parent().addClass('hidden');
            $('#lname').parent().addClass('hidden');
            $('#rating').parent().addClass('hidden');
            $('#home').parent().addClass('hidden');
            $('#artcc').parent().addClass('hidden');
        }
    });

    $('#visit #artcc').keyup(function (){
            var artcc = $(this).val();
            $('#fname').parent().addClass('hidden');
            $('#lname').parent().addClass('hidden');
            $('#rating').parent().addClass('hidden');
            $('#home').parent().addClass('hidden');
            if (artcc.length > 2) {
                $('#email').parent().removeClass('hidden');
            } else {
                $('#email').parent().addClass('hidden');
            }
    });
    $('#visit #email').keyup(function (){
            var email = $(this).val();
            $('#artcc').parent().addClass('hidden');
            if (validateEmail(email)) {
                $(this).parent().removeClass('has-error').addClass('has-success');
                $('#visit button[type="submit"]').removeClass('hidden');
                $('#visit #message').parent().removeClass('hidden');
            }
            else {
                $('#visit button[type="submit"]').addClass('hidden');
                $(this).parent().addClass('has-feedback has-error');
                $('#visit #message').parent().addClass('hidden');
            }
    });

    $('#request-training').submit(function (e) {
            e.preventDefault();

            var now = new Date();
            var month = now.getMonth();
            var date = now.getDate();
            var year = now.getFullYear();
            var hour = now.getHours();
            var minutes = now.getMinutes();

            var start = $('.datepick:eq(0)').val();
            if (start == '') {
                start = year + "-" + month + "-" + date + " " + hour + ":" + minutes + ":00";
            }
            var end = $('.datepick:eq(1)').val();
            if (end == '') {
                end = year + "-" + month + "-" + date + " " + hour + ":" + minutes + ":00";
            }

            $.ajax(
                {
                    url: '/me/request-training',
                    type: 'post',
                    data: {
                        'start': start,
                        'end': end,
                        'user': document.getElementById('cid').value,
                        'cert': document.getElementById('cert').value,
                        'comment':document.getElementById('comment').value
                    }
                }
            ).done(
                function (msg)
                {
                    if (msg.success) {
                        $('.ajax-success').removeClass('hidden');
                        $('.ajax-success .message').text(msg.message);
                    }
                    else {
                        $('.ajax-error').removeClass('hidden');
                        $('.ajax-error .message').text(msg.message);
                    }
                }
            );
        }
    );

    $('.visitor-comment').click(
        function (e)
        {
            $(this).parent().children('.visitor-deny-form').addClass('hidden');
            $(this).parent().children('.visitor-lor-form').addClass('hidden');
            $(this).parent().children('.visitor-comment-form').toggleClass('hidden');
        }
    );

    $('.visitor-lor').click(
        function (e)
        {
            $(this).parent().children('.visitor-comment-form').addClass('hidden');
            $(this).parent().children('.visitor-deny-form').addClass('hidden');
            $(this).parent().children('.visitor-lor-form').toggleClass('hidden');
        }
    );

    $('.visitor-deny').click(
        function (e)
        {
            $(this).parent().children('.visitor-lor-form').addClass('hidden');
            $(this).parent().children('.visitor-comment-form').addClass('hidden');
            $(this).parent().children('.visitor-deny-form').toggleClass('hidden');
        }
    )

    $('#pm-reply').submit(
        function (e)
        {
            if (!validateCC($(this))) {
                e.preventDefault();
            }

        }
    );

    $('#page-create').click(
        function ()
        {
            $('#published').val('1');
        }
    )
    $('#page-draft').click(
        function ()
        {
            $('#published').val('0');
        }
    )
});

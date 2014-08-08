 $(function() {
    $('.file-control').bootstrapFileInput({'data-filename-placement': 'inside'});
    //$('input[type=file]').bootstrapFileInput();
    highlightCorrect();
    $('.datepick').datetimepicker({
        language: 'en',
        format: 'm-d-Y H:i:s',
        inline: true,
        minDate:'0',
        maxDate: '+1970/01/30',
        onChangeDateTime: function(dp, $input)
        {
            var field = $(this.prev()[0]).data('field');
            document.getElementById(field).value = $input.val();
        }
    });
     $('.datepickopen').datetimepicker({
         language: 'en',
         format: 'm-d-Y H:i:s',
         inline: true,
         onChangeDateTime: function(dp, $input)
         {
             var field = $(this.prev()[0]).data('field');
             document.getElementById(field).value = $input.val();
         }
     });

     $('.bsv').bootstrapValidator();

    if($('#training'))
    {
        var nVal = $('#training .progress-bar').attr('aria-valuenow');
        var width = (nVal / 58 ) * 100;
        //$('#training .progress-bar').css('width', width + '%');
    }

    $('.editor').redactor({
        buttons: ['bold', 'italic', 'underline', 'unorderedlist', 'orderedlist', 'outdent', 'indent',
        'image', 'link']
    });
    /*$('.raptor').raptor();*/

     if(window.location.pathname == '/training/request/new') {
         createDateChangeListener();
     }
});

var ladda = Ladda.create(document.querySelector('.ladda-button'));
var form = '#confirmed-password-form';
$(document).on('click', '.uninstall-shopify', function(){
    $('input[name=password]').removeClass('is-invalid');
    $('#uninstall-shopify-id').val($(this).attr('id'));
    $('.bd-uninstall-modal-sm').modal();
})
$(document).on('click', '#uninstall-shopify', function(){

    $(form).submit();
})
$(document).on('submit', form, function(e){

	$.ajax({
            url: '/app/shopify/uninstall',
            type: 'post',
            dataType: 'json',
            data:$(form).serialize(),
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
            	$('input[name=password]').removeClass('is-invalid');
            	ladda.start();
            },
            success: function (data) {
                if(data.status){
                    location.reload();
                } else {
                    $('input[name=password]').addClass('is-invalid');
                }

                ladda.stop();
            },
        });
    return false;
})
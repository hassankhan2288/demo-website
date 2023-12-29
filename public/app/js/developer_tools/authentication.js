var ladda = Ladda.create(document.querySelector('.ladda-button'));
$(document).on('click', '#generate-token', function(){

	$.ajax({
            url: '/developer-tools/generate-secret',
            type: 'post',
            dataType: 'json',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            contentType: 'application/json',
            beforeSend: function(){
            	
            	ladda.start();
            },
            success: function (data) {
                if(data.secret){
                	$('#api-secret').val(data.secret);
                }
                ladda.stop();
            },
        });
})
var ladda = Ladda.create(document.querySelector('.ladda-button'));
$(document).on('click', '.ladda-button', function(){

	$.ajax({
            url: $('#push-form').attr('action'),
            type: 'POST',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data:$('#push-form').serialize(),
            beforeSend: function(){
            	
            	ladda.start();
            },
            success: function (data) {
                ladda.stop();
                toastr.success("Push messages successfully saved", "Saved", {
                  timeOut: "3000"
                });
            },
            error: function (data, error) {
                ladda.stop();
                var time = 10000;
                $.each(data.responseJSON.errors, function(i, row){
                    time += 1000;
                    toastr.error(row[0], "Error!", {
                      timeOut: time
                    });
                })
            }
        });
})
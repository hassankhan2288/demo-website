var ladda = Ladda.create(document.querySelector('.ladda-button'));
$(document).on('click', '.ladda-button', function(){

    $.ajax({
            url: $('#account-settings').attr('action'),
            type: 'POST',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            data:$('#account-settings').serialize(),
            beforeSend: function(){
                
                ladda.start();
            },
            success: function (data) {
                ladda.stop();
                toastr.success("Settings successfully saved", "Saved", {
                  timeOut: "3000"
                });
                $('input[type=password]').val('');
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
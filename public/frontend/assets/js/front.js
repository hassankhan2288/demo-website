let token = '';
$(document).ready(function () {

    $.ajax({
        type: "GET",
        url: "/ajax_cart",
        success: function(result) {
            // var ct = typeof(result);
            console.log(result);
            if(result.check){
                console.log('we are inside');
                document.getElementById("items_count").innerHTML = result.cart_product_count+" Item";
                document.getElementById("circle_cart_count").innerHTML = result.cart_product_count;
                document.getElementById("total_cart_amount").innerHTML = "£"+result.totalCartPrice;
                document.getElementById("insert_cart_objects").innerHTML = result.html;
            }

        },
        error: function (error) {
            console.log(error);
        }
    });

    $('.selfpickup_option').on('click', function(){

        $('.delivery_section').css('height',0);
        $('.delivery_section').css('opacity',0);
        $('.delivery_section').css('position','absolute');

        $('.pickup_section').css('height','auto');
        $('.pickup_section').css('opacity','1');
        $('.pickup_section').css('position','relative');

        $('input[name="phone"]').removeAttr('required');

        $('.show_on_delivery').addClass('hide');

        const delivery_charges = parseFloat($('#delivery_charges_input').val());
        const actual_chares = parseFloat($('#without_delivery').val());
        const grantotal = actual_chares - delivery_charges;

        $('.delivery_additional span').html('£'+actual_chares);

    });
    $('.delivery_option').on('click', function(){
        $('.pickup_section').css('height',0);
        $('.pickup_section').css('opacity',0);
        $('.pickup_section').css('position','absolute');

        $('.delivery_section').css('height','auto');
        $('.delivery_section').css('opacity','1');
        $('.delivery_section').css('position','unset');

        $('input[name="phone"]').prop('required',true);

        $('.show_on_delivery').removeClass('hide');
        //Calculate the price for delivery charges
        const delivery_charges =parseFloat($('#delivery_charges_input').val());
        const actual_chares = parseFloat($('#without_delivery').val());
        const grantotal = delivery_charges + actual_chares;

        $('.delivery_additional span').html('£'+grantotal);


    });

    $('#change_shipping').on('click', function(){
        var aprt = $('#apartment').val();
        var street = $('#street').val();
        var address = $('#address_modal').val();

        $('.custom_address_button').html('Edit Address');

        const ifElement = document.getElementsByClassName('newAddress');
        if(ifElement.length > 0){
            // alert('here');
            const complete_address = aprt+', '+street+', '+address;
            document.getElementById('dynamic_textarea').value = complete_address;
            // console.log(complete_address);
            // document.getElementByClassName('newAddress').innerHTML = complete_address;
            // ifElement.innerHTML = complete_address;
        }else{

            const div = document.createElement('div');

            div.classList.add('lg:col-span-6', 'md:col-span-6', 'red_border_shine');

            const label = document.createElement('label');
            const close = document.createElement('label');
            label.textContent = 'Shipping Address 2';
            close.textContent = 'x';
            close.setAttribute('id','delete_dom');
            const span = document.createElement('span');
            span.textContent = '*';
            label.appendChild(span);
            div.appendChild(label);
            div.appendChild(close);

            const textarea = document.createElement('textarea');
            textarea.classList.add('w-full', '!border', '!border-[#ce1212]/10', 'hover:border-[#ce1212]/50', '!outline-0', 'rounded-[5px]', 'p-[8px_15px]','disabled', 'newAddress');
            textarea.setAttribute('name', 'address3');
            textarea.setAttribute('id','dynamic_textarea');
            textarea.setAttribute('placeholder', '');
            textarea.setAttribute('readonly', '');
            textarea.textContent = aprt+', '+street+', '+address;
            div.appendChild(textarea);

            const targetElement = document.querySelector('.insert_after_here');
            targetElement.insertAdjacentElement('afterend', div);
        }

        $('#new_address_modal').modal('hide');

        // alert(aprt+', '+street+', '+address);
    });

    $(document).on('click','#delete_dom',function(){
        // console.log('work');
        $(".red_border_shine").remove();
        $('.custom_address_button').html('Add Other Address +');
    });
    $(document).on('click','.btn_container > button',function(){
        const type = $(this).attr('data-type');
        $('.btn_container > button').removeClass('selected_price');
        $(this).addClass('selected_price');
        $('input[name="type"]').val(type);
        // if(type="CASE"){

        // }else{
        // }
    });
    $(document).on('click','#pay_in_store',function(){
        $('input[name="paid_by"]').val('cash_on_pickup');
        var hasChildDiv = document.getElementById("slots-container").querySelector("#pick_time");
        if (hasChildDiv == null) {
            alert('Please select a date first');
        }else{
            $("#proceed_to_checkout").click();
        }
    });
    $(document).on('click','#proceed_payment',function(){
        $('.custom_spinner').css('top', '0%');
        $('.custom_spinner').css('position', 'fixed');
        var preference = $('#get_preference').val();
       //alert(preference);

        if(preference.includes("pickup")){
            var parentH = document.getElementById("slots-container");
            if(parentH){
                var hasChildDiv =parentH.querySelector("#pick_time");
            }else{
                var hasChildDiv = null;
            }
            // var hasChildDiv = document.getElementById("slots-container").querySelector("#pick_time");
            // alert(hasChildDiv);
            if (hasChildDiv == null) {
                var check = true; //validate_before_payment();
            }else{
                var check = false;
            }
        }else{
            var parentH = document.getElementById("slots-container");
            var check = false;
        }

        var env_variable = $('#env_variable').val();
        var url;
        var authToken;
        var jsonData;
        var minor_unit_amount;
        var site_url = $('#env_url').val();
        var user_id = $('#user_id').val();
        var reference_no = "ORD-"+Date.now();

        if(check){
            $('.custom_spinner').css('top', '300%');
            $('.custom_spinner').css('position', 'fixed');
            alert("Please Select an option first");
        }else{
            //var amount = $('.delivery_additional span').html();
           // var total_amount =  parseFloat(amount.replace('£',''));
            var amount = $('.delivery_additional span').attr('data-price');
            var total_amount =  parseFloat(amount);
            minor_unit_amount = total_amount * 100;
            if(env_variable == "local"){
                url = "https://e.test.connect.paymentsense.cloud/v1/access-tokens";
                authToken = "Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJjb25uZWN0LWUtZGV2QGFwcHNwb3QuZ3NlcnZpY2VhY2NvdW50LmNvbSIsImF1ZCI6Imh0dHBzOi8vZS50ZXN0LmNvbm5lY3QucGF5bWVudHNlbnNlLmNsb3VkIiwiZXhwIjoyMzgzMDQ4NDAxLCJpYXQiOjE2MjYxODQ0MDEsInN1YiI6ImNvbm5lY3QtZS1kZXZAYXBwc3BvdC5nc2VydmljZWFjY291bnQuY29tIiwiYXBpS2V5IjoiMTM3ODQyOGMtYTMxNC00NTA5LWFjYTEtNmRhY2EzNGNiM2QyIiwiZW1haWwiOiJjb25uZWN0LWUtZGV2QGFwcHNwb3QuZ3NlcnZpY2VhY2NvdW50LmNvbSJ9.IKX_Kou8grA5_UTkiC4wREq8yYL4gj1W9UG6lXArlm_DQiv1eL26kMfsbzN3dfUWO-H7BJHs8zMX-EN2fXocNq16aUTrdLHtSczVSLbt8kizHcVsOMYotW3syw897vpXJBDe2xWihKMBrr6P1uBFKnx_bDeMR67wvE3-5XIh_zV9hteFneuN9QmEW-QyGEJ9RpyKwrpGKU60SPYM1WO_6L72CgkxSATLwHThsEnUQCsZoOZc058lHzjyVww0T_y7QLYsooXQo2WJy5TIunE3xjf6srZnE6yeQu_0wouUJ_m64y9lmlUNXGzAzNvmgfnDZ1IqhWdfVDiIE6ZOa__H4w";
                jsonData = {
                    "merchantUrl": "demo-dot-connect-e-build-non-pci.appspot.com",
                    "merchantTransactionId" : reference_no,
                    "currencyCode": "826",
                    "amount": minor_unit_amount,
                    "transactionType": "SALE",
                    "orderId": reference_no,
                    "orderDescription": "Example description.",
                    'webHookUrl': site_url+'/front/payment/webhook'
                };

            }else{
                url = "https://e.connect.paymentsense.cloud/v1/access-tokens";
                authToken = "Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJjb25uZWN0LWUtcHJvZEBhcHBzcG90LmdzZXJ2aWNlYWNjb3VudC5jb20iLCJhdWQiOiJodHRwczovL2UuY29ubmVjdC5wYXltZW50c2Vuc2UuY2xvdWQiLCJleHAiOjI0Mzk0NzMwMzEsImlhdCI6MTY4MjYwOTAzMSwic3ViIjoiY29ubmVjdC1lLXByb2RAYXBwc3BvdC5nc2VydmljZWFjY291bnQuY29tIiwiYXBpS2V5IjoiMzM0OGFkOGUtMTIxZi00MjNiLWI2YWItMmMyYjYyZTI4Y2M1IiwiZW1haWwiOiJjb25uZWN0LWUtcHJvZEBhcHBzcG90LmdzZXJ2aWNlYWNjb3VudC5jb20ifQ.el09Mxw-y4xyCrRI8BUkHLIPRnp3s9Hsf1i16g4AkXY4A6EqMv2jV8chdJNg7YvS-glcuLPO-CD-egJaqouwbPREihVX7Zuq1FilpqhP4Whs3dhxsicBDSoFXWqThRMx_FyttIX60l8uDhCy6SSnE93Ru82D1Z8FbVjSc24xejkzIIzz94jV5hdJ7Uep-g6zGZhoZlX_O_VNEw-ZeRi3dU7ePkIdFo554gDGCqOJsBL5qbLCimQ2YdmsVqQSzB6uy1D9m1TgA0V6Yf2zcm5SNPaR2WnoqnU7zB86rz2Mct8qT2isHgSCwp2NgwFNS5mLlJc3y1m0Pt9R2pyEdHdrZQ";
                jsonData = {
                    "merchantUrl": "https://www.caterchoice.com",
                    "merchantTransactionId" : reference_no,
                    "currencyCode": "826",
                    "amount": minor_unit_amount,
                    "transactionType": "SALE",
                    "orderId": reference_no,
                    "orderDescription": "Live payment",
                    'webHookUrl': site_url+'/front/payment/webhook'
                };

            }
            // const url = "https://e.test.connect.paymentsense.cloud/v1/access-tokens";
            // const authToken = "Bearer eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJjb25uZWN0LWUtZGV2QGFwcHNwb3QuZ3NlcnZpY2VhY2NvdW50LmNvbSIsImF1ZCI6Imh0dHBzOi8vZS50ZXN0LmNvbm5lY3QucGF5bWVudHNlbnNlLmNsb3VkIiwiZXhwIjoyMzgzMDQ4NDAxLCJpYXQiOjE2MjYxODQ0MDEsInN1YiI6ImNvbm5lY3QtZS1kZXZAYXBwc3BvdC5nc2VydmljZWFjY291bnQuY29tIiwiYXBpS2V5IjoiMTM3ODQyOGMtYTMxNC00NTA5LWFjYTEtNmRhY2EzNGNiM2QyIiwiZW1haWwiOiJjb25uZWN0LWUtZGV2QGFwcHNwb3QuZ3NlcnZpY2VhY2NvdW50LmNvbSJ9.IKX_Kou8grA5_UTkiC4wREq8yYL4gj1W9UG6lXArlm_DQiv1eL26kMfsbzN3dfUWO-H7BJHs8zMX-EN2fXocNq16aUTrdLHtSczVSLbt8kizHcVsOMYotW3syw897vpXJBDe2xWihKMBrr6P1uBFKnx_bDeMR67wvE3-5XIh_zV9hteFneuN9QmEW-QyGEJ9RpyKwrpGKU60SPYM1WO_6L72CgkxSATLwHThsEnUQCsZoOZc058lHzjyVww0T_y7QLYsooXQo2WJy5TIunE3xjf6srZnE6yeQu_0wouUJ_m64y9lmlUNXGzAzNvmgfnDZ1IqhWdfVDiIE6ZOa__H4w";
            // const jsonData = {
            // "merchantUrl": "demo-dot-connect-e-build-non-pci.appspot.com",
            // "currencyCode": "826",
            // "amount": "100",
            // "transactionType": "SALE",
            // "orderId": "ORD00001",
            // "orderDescription": "Example description."
            // };

            // console.log(jsonData);
            $.ajax({
                url: url,
                method: 'POST',
                headers: {
                'Authorization': authToken,
                'Content-Type': 'application/json'
                },
                data: JSON.stringify(jsonData),
                // data: JSON.stringify({
                // "merchantUrl": "demo-dot-connect-e-build-non-pci.appspot.com",
                // "currencyCode": "826",
                // "amount": "${total_amount}",
                // "transactionType": "SALE",
                // "orderId": "ORD00001",
                // "orderDescription": "Example description."
                // }),
                success: function(response) {
                //   console.log('Response:', response);
                $('.spinner_div').css('opacity', 0);
                $('.payment_section').css('top','40vh');
                $('.payment_section').css('position','fixed');

                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", "reference_no");
                input.setAttribute("value", "ORD"+Date.now());
                document.getElementById("checkout_form").appendChild(input);

                var input = document.createElement("input");
                input.setAttribute("type", "hidden");
                input.setAttribute("name", "paymensense_token");
                input.setAttribute("value", response.id);
                document.getElementById("checkout_form").appendChild(input);

                var csrf_token = $('input[name="_token"]').val();

                document.getElementById("demo-payment").innerHTML ='';
                const token = response.id;
                if(env_variable == "local"){
                    var formHtml = `
                                    <form id="paymemtForm" action="javascript:formSubmit()" method="post">
                                    <input type="hidden" name="_token" value="${csrf_token}" />
                                        <script src="https://web.e.test.connect.paymentsense.cloud/assets/js/checkout.js"
                                            data-amount="${total_amount}"
                                            data-access-token="${token}"
                                            data-currency-code="826"
                                            data-description="Demo Payment of ${total_amount} GBP"
                                            data-button-text="Start Payment"
                                            data-submit-button-text="Pay ${total_amount} GBP"
                                            class="connect-checkout-btn"></script>
                                        <div class="text-center">Amount: ${total_amount} GBP</div>
                                    </form>
                                `;
                }else{
                    var formHtml = `
                                    <form id="paymemtForm" action="javascript:formSubmit()"  method="post">
                                    <input type="hidden" name="_token" value="${csrf_token}" />
                                        <script src="https://web.e.connect.paymentsense.cloud/assets/js/checkout.js"
                                            data-amount="${total_amount}"
                                            data-access-token="${token}"
                                            data-currency-code="826"
                                            data-description="Payment of ${total_amount} GBP"
                                            data-button-text="Start Payment"
                                            data-submit-button-text="Pay ${total_amount} GBP"
                                            class="connect-checkout-btn"></script>
                                        <div class="text-center">Amount: ${total_amount} GBP</div>
                                    </form>
                                `;

                }
                //   console.log(response.id);
                            $('#paymentFormContainer').html(formHtml);
                //   const pay = '<script src="https://web.e.test.connect.paymentsense.cloud/assets/js/checkout.js" data-amount="100" data-access-token="'+token+'" data-currency-code="826" data-description="Demo Payment of 1.00 GBP" data-button-text="Start Payment" data-submit-button-text="Pay 1.00 GBP" class="connect-checkout-btn"></script>';

                //   $('#testForm').html(pay);
                //   const payConfig = {
                //     paymentDetails: {
                //         paymentToken: token,
                //     },
                //     containerId: "demo-payment",
                //     fontCss: ['https://fonts.googleapis.com/css?family=Do+Hyeon'],
                //     styles: {
                //         base: {
                //             default: {
                //                 color: "black",
                //                 textDecoration: "none",
                //                 fontFamily: "'Do Hyeon', sans-serif",
                //                 boxSizing: "border-box",
                //                 padding: ".375rem .75rem",
                //                 boxShadow: 'none',
                //                 fontSize: '1rem',
                //                 borderRadius: '.25rem',
                //                 lineHeight: '1.5',
                //                 backgroundColor: '#fff',

                //             },
                //             focus: {
                //                 color: '#495057',
                //                 borderColor: '#80bdff',
                //             },
                //             error: {
                //                 color: "#B00",
                //                 borderColor: "#B00"
                //             },
                //             valid: {
                //                 color: "green",
                //                 borderColor: 'green'
                //             },
                //             label: {
                //                 display: 'none'
                //             }
                //         },
                //         cv2: {
                //             container: {
                //                 width: "25%",
                //                 float: "left",
                //                 boxSizing: "border-box"
                //             },
                //             default: {
                //                 borderRadius: "0 .25rem .25rem 0"
                //             }
                //         },
                //         expiryDate: {
                //             container: {
                //                 width: "25%",
                //                 float: "left",
                //                 borderRadius: '0rem',
                //             },
                //             default: {
                //                 borderRadius: "0",
                //                 borderRight: "none"
                //             },
                //         },

                //         cardNumber: {
                //             container: {
                //                 width: "50%",
                //                 float: "left",
                //             },
                //             default: {
                //                 borderRadius: ".25rem 0 0 .25rem",
                //                 borderRight: "none"
                //             },
                //         }
                //     }
                //  }

                //  const connectE = new Connect.ConnectE(payConfig, displayErrors);
                //  const btnTestPay = document.getElementById("testPay");
                //  btnTestPay.onclick = () =>{
                //     btnTestPay.innerText = 'loading';
                //     btnTestPay.setAttribute("disabled", "true");
                //     connectE.executePayment()
                //         .then(function(data) {
                //             // document.getElementById("status-code").innerText = '';
                //             // document.getElementById("auth-code").innerText = '';
                //             // document.getElementById("auth-code").innerText = '';


                //             document.getElementById("demo-payment").hidden = true;
                //             btnTestPay.remove();
                //             document.getElementById("demo-result").hidden = false;
                //             document.getElementById("status-code").innerText = data.statusCode;
                //             document.getElementById("auth-code").innerText = data.authCode;
                //             $('.payment_section').css('top','300%');
                //             $('.payment_section').css('position', 'fixed');
                //             $('.custom_spinner').css('position', 'fixed');
                //             $('.custom_spinner').css('top','300%');
                //             $('.spinner_div').css('opacity', 1);
                //             // $('#checkout_form').submit();
                //             $("#proceed_to_checkout").click();
                //             console.log('INNER ');
                //         }).catch(function(data) {
                //                 console.log('Payment Request failed: ' + data);
                //                 btnTestPay.innerText = 'Pay';
                //                 btnTestPay.removeAttribute("disabled");
                //                 if (typeof data === 'string') {
                //                     document.getElementById("errors").innerText = data;
                //                 }
                //                 if (data && data.message) {
                //                     document.getElementById("errors").innerText = data.message;
                //                 }

                //                 $('.payment_section').css('top','300%');
                //                 $('.custom_spinner').css('top','300%');
                //                 $('.spinner_div').css('opacity', 1);
                //             }
                //         );
                //     };
                //   $(this).css('top', '300%');
                // handle success
                },
                error: function(error) {
                console.error('Error:', error);
                $(this).css('top', '300%');
                // handle error
                }
            });
        }


    });
    $(document).on('click','.custom_spinner',function(){
        $(this).css('top', '300%');
        $(this).css('display', 'fixed');

        $('.payment_section').css('top', '300%');
        $('.payment_section').css('display', 'fixed');
        location.reload();//i have added this option to refresh other wise card ifram stuck some time.

    });

    $("#form").submit(function (event) {
        //alert(88);
        var formData = {
        //name: $("#name").val(),
        email: $("#email").val(),
        // superheroAlias: $("#superheroAlias").val(),
        };

        $.ajax({
        type: "POST",
        url: '{{route("subscribe")}}',
        data: formData,
        dataType: "json",
        encode: true,
        }).done(function (data) {
        console.log(data);
        });

        event.preventDefault();
    });
    var dateToday = new Date();
    var dateTodayInYMD = jQuery.datepicker.formatDate('yy-mm-dd', dateToday);
    var currentTime = formatAMPM(dateToday);
    $('#date').datepicker({
        minDate: dateToday,
        dateFormat: 'dd-mm-yy',
        beforeShowDay: function(date){
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [ array.indexOf(string) == -1 ]
        },
        onSelect: function (date, datepicker) {
            var warehouse_id = $('#warehouse_id').val();

            $.ajax({
                type: "GET",
                url: "slots_generater",
                data: {
                    warehouse_id : warehouse_id,
                    date: date,
                    dateTodayInYMD : dateTodayInYMD,
                    currentTime: currentTime,
                },
                success: function(result) {
                    // console.log(typeof result);
                    $('#slots_description').remove();
                    if(result == false){
                        $('#noslots').remove();
                     //   $('#slots-container').remove();
                        $( "#slots-container" ).after( '<p id="noslots">No Slots Available</p>' );
                    }else{
                        $('#noslots').remove();
                      //  $('#slots-container').remove();
                        $(".slots_container_hm").empty();
                        const slotsContainer = document.getElementById("slots-container");
                        const select = document.createElement("select");
                        select.setAttribute("class", "w-full !border !border-[#ce1212]/10 hover:border-[#ce1212]/50 !outline-0 rounded-[5px] p-[8px_15px]");
                        select.setAttribute("name", "pick_time");
                        select.setAttribute("id", "pick_time");
                        const slots = JSON.parse(result);
                        slots.forEach((slot, index) => {
                            var optionElement = document.createElement("option");
                            optionElement.value = slot;
                            optionElement.text = slot;
                            select.appendChild(optionElement);
                        });
                        // slots.forEach((slot, index) => {
                        //     const label = document.createElement("label");
                        //     label.setAttribute("class", "flex items-center cursor-pointer relative text-black text-[16px]");
                        //     label.setAttribute("for", "flexRadioDefault2" + index);

                        //     const input = document.createElement("input");
                        //     input.setAttribute("class", "absolute opacity-0 z-[0] peer");
                        //     input.setAttribute("type", "radio");
                        //     input.setAttribute("id", "flexRadioDefault2" + index);
                        //     input.setAttribute("name", "pick_time");
                        //     input.setAttribute("value", slot);

                        //     const span = document.createElement("span");
                        //     span.setAttribute("class", "peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]");

                        //     const text = document.createTextNode(slot);

                        //     label.appendChild(input);
                        //     label.appendChild(span);
                        //     label.appendChild(text);

                            slotsContainer.appendChild(select);
                        // });
                    }
                    // var html;
                    // html = '<div class="lg:col-span-12 md:col-span-12 !mt-6"><label class="text-[20px] font-semibold !mb-4">Pickup Time</label><div class="grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4">';
                    // for (let i = 0; i < result.length; i++) {
                    // 	html += '<label class="flex items-center cursor-pointer relative text-black text-[16px]" for="flexRadioDefault2'+result[i]+'" value="'+result[i]+'">';
                    // 	html += '<input class="absolute opacity-0 z-[0] peer" type="radio" id="flexRadioDefault2'+result[i]+'" name="pick_time" />';
                    // 	html += '<span class="peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>';
                    // 	html += result[i]+ '</label></div></div>';
                    // }
                    // $( "#warehouse_id" ).after( html );
                },
                error: function (error) {
                    console.log(error);
                }
            });

        }
    // format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {

    });

    const check =  $('meta[name="csrf-token"]').attr("content");
    // console.log(check);
    //Datatable for orders
    $('#customer_order_table').DataTable( {
        "processing": true,
        "serverSide": true,
        "searching": false,
        "responsive": true,
        "ajax":{
            url:"/customer/orders/ajax",
            data:{
                '_token': check
                // all_permission: all_permission,
                // starting_date: starting_date,
                // ending_date: ending_date,
                // warehouse_id: warehouse_id,
                // sale_status: sale_status,
                // payment_status: payment_status,
                // company_id : company_id
            },
            dataType: "json",
            type:"post"
        },
        /*rowId: function(data) {
              return 'row_'+data['id'];
        },*/
        // "createdRow": function( row, data, dataIndex ) {
        //     console.log(data);
        //     $(row).addClass('sale-link');
        //     $(row).attr('data-sale', data['sale']);
        // },
        "columns": [
            // {"data": "key"},
            {"data": "id"},
            {"data": "total_qty"},
            {"data": "grand_total"},
            {"data": "payment_status"},
            // {"data": "id"},
            // {"data": "options"},
        ],
        'language': {

            'lengthMenu': '_MENU_ Records Per Page',
             "info":      '<small>Showing _START_ - _END_ (_TOTAL_)</small>',
            "search":  'Search:',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        order:[['0', 'desc']],
        columnDefs: [
            {
              responsivePriority: 1, targets: 0
            },
            {  responsivePriority: 2,

                targets: 4,
                data: function(row, type, val, meta){
                    if(row.payment_status == "Pending"){
                        return '<a href="/checkout/payment?order_id='+row.id+'" class="btn btn-link btnview" target="_blank"> <i class="fa fa-credit-card-alt" aria-hidden="true"></i> Pay Now</a><a href="/customer/report/'+row.id+'" class="btn btn-link btnview" target="_blank"><i class="fa fa-eye"></i> View</a>';
                    }else{
                        return '<a href="/customer/report/'+row.id+'" class="btn btn-link btnview" target="_blank"><i class="fa fa-eye"></i> View</a>';
                    }
                },
                // defaultContent: '<a href="/report/">Click!</a>',
            },
        ],
    } );

    const password1 = document.getElementById("password");
    const password2 = document.getElementById("password-confirm");
    const loginButton = document.getElementById("RegisterButton");

    // Function to compare the two passwords
    function comparePasswords() {
    if (password1.value !== password2.value) {
        // password2.setCustomValidity("Passwords do not match.");
        $('#password_message').html('Passwords do not match.');
        loginButton.disabled = true;
    } else {
        // password2.setCustomValidity("");
        $('#password_message').html('Passwords match.');
        loginButton.disabled = false;
    }
    }

    // Add event listeners to compare the passwords on key up and focus out
    password1.addEventListener("keyup", comparePasswords);
    password2.addEventListener("keyup", comparePasswords);

    password1.addEventListener("focusout", comparePasswords);
    password2.addEventListener("focusout", comparePasswords);

    // Disable login button on page load
    loginButton.disabled = true;

    getAddress.autocomplete(
        'postcode',
        'ZptSRYXSCkq0HrUlrREwGQ39578',
        /*options*/{
            output_fields:{
                formatted_address_0:'address',  /* The id of the element bound to 'formatted_address[0]' */
                formatted_address_1:'address_2',  /* The id of the element bound to 'formatted_address[1]' */
                // formatted_address_2:'formatted_address_2',  /* The id of the element bound to 'formatted_address[2]' */
                // formatted_address_3:'formatted_address_3',  /* The id of the element bound to 'formatted_address[3]' */
                // formatted_address_4:'formatted_address_4',  /* The id of the element bound to 'formatted_address[4]' */
                // line_1:'line_1',  /* The id of the element bound to 'line_1' */
                // line_2:'line_2',  /* The id of the element bound to 'line_2' */
                // line_3:'line_3',  /* The id of the element bound to 'line_3' */
                // line_4:'line_4',  /* The id of the element bound to 'line_4' */
                // latitude:'latitude',  /* The id of the element bound to 'latitude' */
                // longitude:'longitude',  /* The id of the element bound to 'longitude' */
                town_or_city:'city',  /* The id of the element bound to 'town_or_city' */
                // building_number:'building_number',  /* The id of the element bound to 'building_number' */
                // building_name:'building_name',  /* The id of the element bound to 'building_name' */
                // sub_building_number:'sub_building_number',  /* The id of the element bound to 'sub_building_number' */
                // sub_building_name:'sub_building_name',  /* The id of the element bound to 'sub_building_name' */
                // thoroughfare:'thoroughfare',  /* The id of the element bound to 'thoroughfare' */
                // county:'county',  /* The id of the element bound to 'county' */
                // country:'country',  /* The id of the element bound to 'country' */
                // district:'district',  /* The id of the element bound to 'district' */
                // locality:'locality',  /* The id of the element bound to 'locality' */
                postcode:'postcode',  /* The id of the element bound to 'postcode' */
                // residential:'residential'  /* The id of the element bound to 'residential' */
            },
        },
    );


});
function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return strTime;
}

function formSubmit(){
     // Get the form element
     var form = document.getElementById("paymemtForm");

     // Create a new FormData object
     var formData = new FormData(form);
     var check_val = formData.get('connectStatusCode');
     var check_val_two = formData.get('connectAuthCode');
     console.log(check_val);
     console.log(check_val_two);

     if(check_val == 0){
        var thankyou_url = $('#thankYou_url').val();
        swal({
            title: "Payment Successful",
            text: "Processing further",
            icon: "success",
            button: false,
            timer: 3000
        });
        window.location.href = thankyou_url;
        // $("#proceed_to_checkout").click();
     }else{
        var checkout_url = $('#checkout_url').val();
        swal({
            title: "Payment Failed",
            text: "There was something wrong, please try again",
            icon: "warning",
            dangerMode: true,
            button: "OK",
          }).then((value) => {
            window.location.href = checkout_url;
          });
     }
    //  console.log(check_val);
    //  for (var pair of formData.entries()) {
    //     var key = pair[0];
    //     var value = pair[1];
    //     console.log(key + ": " + value);
    // }
}
//payment



 function displayErrors(errors) {
    const errorsDiv = document.getElementById('errors');
    errorsDiv.innerHTML = '';
    if (errors && errors.length) {
        const list = document.createElement("ul");
        for (const error of errors){
            const item = document.createElement("li");
            item.innerText = error.message;
            list.appendChild(item);
        }
        errorsDiv.appendChild(list);
    }
 }

 var $sel = $('.selecdel').on('change', function(){
    var value = $('.selecdel :selected').val();
    $.ajax({
        type: "GET",
        url: "/ajax_cart",
        success: function(result) {
            // var ct = typeof(result);
            console.log(result);
            if(result.check){
                if (confirm('Your cart will be emptied, sure you want to continue?')) {
                    $.ajax({
                        type: "GET",
                        url: "/ajax_cartEmptyAndChangePreference",
                        success: function(result) {
                            // var ct = typeof(result);
                            console.log(result);
                            window.location.href=value;
                            // $sel.trigger('update');

                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                } else {
                     // reset
                     $sel.val( $sel.data('currVal'));
                }

            }else{
                window.location.href=value;
            }

        },
        error: function (error) {
            console.log(error);
        }
    });

}).on('update', function(){
    $(this).data('currVal', $(this).val())
}).trigger('update');

//  function changePreference(value){
//     var preference = $('.selecdel :selected').attr('data-reverTo');
//     alert(preference);
//     $.ajax({
//         type: "GET",
//         url: "/ajax_cart",
//         success: function(result) {
//             // var ct = typeof(result);
//             console.log(result);
//             if(result.check){
//                if(confirm('Your cart will be emptied, sure you want to continue?')){
//                 $.ajax({
//                     type: "GET",
//                     url: "/ajax_cartEmptyAndChangePreference",
//                     success: function(result) {
//                         // var ct = typeof(result);
//                         console.log(result);
//                         window.location.href=value;

//                     },
//                     error: function (error) {
//                         console.log(error);
//                     }
//                 });
//                }

//             }

//         },
//         error: function (error) {
//             console.log(error);
//         }
//     });
//  }


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
	<link rel="stylesheet" href="{{asset('app/css/themes/lite-purple.min.css')}}">
	<style type="text/css">
		#demo-payment iframe { width: 100%; }

		#demo-result, #demo-payment, #recurring-demo-payment, #recurring-payment { padding: 5px; }

		#errors li { color: #B00; }

		iframe.threeDs {
		    width: 400px;
		    height: 400px;
		    margin: 100px 0 0 -175px;
		    position: fixed;
		    top: 0;
		    left: 50%;
		    box-shadow: 0 0 15px rgba(0, 0, 0, 0.6);
		    background-color: white;
		}
	</style>
</head>
<body class="m-4">
	<div class="d-flex justify-content-center">
        <img src="{{asset('frontend/assets/img/cater-logo.png')}}" class="sm:w-[170px] w-[150px]" alt="">
    </div>

	<div id="demo-payment"></div>
	  <div id="errors"></div>
	  <button id="testPay" class="btn-danger btn pull-right"
	          data-loading-text="Processing...">Pay £{{$sale->grand_total}}</button>
	  <div class="alert alert-success" role="alert" id="demo-result" style="display: none">
	     Payment Complete
	  </div> 

</body>
<script src="https://web.e.test.connect.paymentsense.cloud/assets/js/client.js"></script>
<script type="text/javascript">
	const payConfig = {
   paymentDetails: {
       paymentToken:"{{$sale->payment_token}}"
   },
   containerId: "demo-payment",
   fontCss: ['https://fonts.googleapis.com/css?family=Do+Hyeon'],
   styles: {
       base: {
           default: {
               color: "black",
               textDecoration: "none",
               fontFamily: "'Do Hyeon', sans-serif",
               boxSizing: "border-box",
               padding: ".375rem .75rem",
               boxShadow: 'none',
               fontSize: '1rem',
               borderRadius: '.25rem',
               lineHeight: '1.5',
               backgroundColor: '#fff',

           },
           focus: {
               color: '#495057',
               borderColor: '#80bdff',
           },
           error: {
               color: "#B00",
               borderColor: "#B00"
           },
           valid: {
               color: "green",
               borderColor: 'green'
           },
           label: {
               display: 'none'
           }
       },
       cv2: {
           container: {
               width: "25%",
               float: "left",
               boxSizing: "border-box"
           },
           default: {
               borderRadius: "0 .25rem .25rem 0"
           }
       },
       expiryDate: {
           container: {
               width: "25%",
               float: "left",
               borderRadius: '0rem',
           },
           default: {
               borderRadius: "0",
               borderRight: "none"
           },
       },

       cardNumber: {
           container: {
               width: "50%",
               float: "left",
           },
           default: {
               borderRadius: ".25rem 0 0 .25rem",
               borderRight: "none"
           },
       }
   }
}

const connectE = new Connect.ConnectE(payConfig, displayErrors);
const btnTestPay = document.getElementById("testPay");

btnTestPay.onclick = () =>{
   btnTestPay.innerText = 'loading';
   btnTestPay.setAttribute("disabled", "true");
   connectE.executePayment()
       .then(function(data) {
        console.log("data", data)
           document.getElementById("demo-payment").hidden = true;
           btnTestPay.remove();
           document.getElementById("demo-result").style.display = "block";
       }).catch(function(data) {
               console.log('Payment Request failed: ' + data);
               btnTestPay.innerText = 'Pay £{{$sale->grand_total}}';
               btnTestPay.removeAttribute("disabled");
               if (typeof data === 'string') {
                   document.getElementById("errors").innerText = data;
               }
               if (data && data.message) {
                   document.getElementById("errors").innerText = data.message;
               }
           }
       );
   };
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
</script>
</html>
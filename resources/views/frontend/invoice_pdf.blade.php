{{-- <!DOCTYPE HTML>
<html lang="eng">
<head>
<title>Invoice</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link href="{{ asset('css/bootstrap-v4.css') }}" rel="stylesheet" />
<link href="{{ asset('app/css/invoice.css') }}" rel="stylesheet" />
<style type="text/css">
@media print {
  .printPageButton {
    display: none;
  }
}
</style>
</head>
<body>
<section class="main-body p-t-10">
	<div class="container">
			<!-- Right -->
		<div class="row">
			<div class="col-md-12">
				<center class="mb-4 mt-2 printPageButton">
					<a href="{{route('customer.orders')}}" class="btn btn-info">Back</a>
					<button class="btn btn-primary  m-r-10"  onclick="CreatePDFfromHTML()"   ><i class="far fa-file-pdf"></i> &nbsp; PDF</button>
					<button  onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
																	</center>

				<div class="index-boxes m-t-20 p-20" id="downloadContainer2">
					<div class="row">
						<div class="col-md-3">
							<img src="{{asset('img/cater-mail-logo.jpeg')}}" style="width:150px;">
						</div>
						<div class="col-md-6">

						</div>
						<div class="col-md-3">
							<div style="width:100%;text-align: right;"><h4>#{{$sale->reference_no}}</h4></div>
							<svg id="barcode" class="float-right"></svg>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<i><b>From</b></i>
							<p><b>{{$sale->user->name??""}}</b><br>
							<p><b>{{$sale->user->address??""}}</b><br>
							 Phone:{{$sale->user->phone??""}}<br>
							 Email:{{$sale->user->email??""}}</p>
						</div>
						<div class="col-md-4">
							<i><b>Buyer Details</b></i>
							<p><b>{{$sale->branch->name??""}}</b><br>
							<p><b>{{$sale->branch->address??""}}</b><br>
							 Phone:{{$sale->branch->phone??""}}<br>
							 Email:{{$sale->branch->email??""}}</p>
						</div>
						<div class="col-md-4">
							<p>
								<b>Order No #{{$sale->reference_no}}</b><br>
								Purchase Status : <small><span style="border:1px solid Green;color:Green;padding: 3px;border-radius: 4px;"><i class="fas fa-times-circle"></i> {{$sale->payment_status}}</span></small><br>
								Invoice Date : {{$sale->created_att}}
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table style="width:100%" id="tbl1" border="1" >
								<thead>
									<tr>
										<th style="padding:4px">#</th>
										<th style="padding:4px">Item Details & Description</th>

										<th style="padding:4px">Qty</th>
										<th style="padding:4px;text-align:right">Unit</th>
										<th style="padding:4px;text-align:right">VAT</th>
										<th style="padding:4px;text-align:right">Total</th>
									</tr>
								</thead>
								<tbody>
									@if($items)
									@foreach($items as $item)
												<tr>
													<td style="padding:4px" valign="top">1</td>
													<td style="padding:4px" valign="top">{{$item->product->name??""}} <small>(#{{$item->product->code??""}})</small> ({{ ($item->type == "CASE")?"PACK":$item->type }})</td>

													<td style="padding:4px" valign="top">{{$item->qty??1}}</td>
													<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format($item->net_unit_price,2)}}</td>
													<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format($item->tax,2)}}</td>
													<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format((number_format($item->total,2)) + (number_format($item->tax,2)),2)}}</td>
												</tr>
												@endforeach
												@endif
									</tbody>
								<tfoot>
									<tr>
										<th colspan="5" style="text-align:right">Pickup Date : &nbsp;</th>
										<th style="text-align:right">{{$sale->pick_date}}</th>
									</tr>
									<tr>
										<th colspan="5" style="text-align:right">Pickup Time : &nbsp;</th>
										<th style="text-align:right">{{$sale->pick_time}}</th>
									</tr>
									<tr>
										<th colspan="5" style="text-align:right">Total Order Qty : &nbsp;</th>
										<th style="text-align:right">{{$sale->total_qty}}</th>
									</tr>
									<tr>
										<th colspan="5" style="text-align:right">Sub Total : &nbsp;</th>
										<th style="text-align:right">{{currency()}}{{number_format($sale->total_price,2)}}</th>
									</tr>
									<tr>
										<th colspan="5" style="text-align:right">VAT : &nbsp;</th>
										<th style="text-align:right">{{currency()}}{{number_format($sale->total_tax,2)}}</th>
									</tr>
									<tr>
										<th colspan="5" style="text-align:right">Delivery Charges : &nbsp;</th>
										<th style="text-align:right">{{currency()}}{{number_format($sale->delivery_charges,2)}}</th>
									</tr>
									<tr>
										<th colspan="5" style="text-align:right">Grand Total : &nbsp;</th>
										<th style="text-align:right">{{currency()}}{{number_format($sale->grand_total + $sale->delivery_charges,2)}}</th>
									</tr>
								</tfoot>
							</table>
							<hr>
							<center>
								<small>All goods remain the	property of ICS (UK) LTD until paid in full</small><br>
								<small>For support : E-mail support@icsukltd.co.uk | Download team viewer on the computer/laptop</small>
							</center>

						</div>
					</div>
				</div>
				<div class="index-boxes m-t-20 p-20" style=" min-width: 1200px; display: none;" id="downloadContainer">
					<div class="row">
						<div class="col">
							<img src="{{asset('img/cater-mail-logo.jpeg')}}" style="width:150px;">
						</div>
						<div class="col-md-6 col-sm-6">

						</div>
						<div class="col">
							<div style="width:100%;text-align: right;"><h4>#{{$sale->reference_no}}</h4></div>
							<svg id="barcode" class="float-right"></svg>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<i><b>From</b></i>
							<p><b>{{$sale->user->name??""}}</b><br>
							<p><b>{{$sale->user->address??""}}</b><br>
								Phone:{{$sale->user->phone??""}}<br>
								Email:{{$sale->user->email??""}}</p>
						</div>
						<div class="col">
							<i><b>Buyer Details</b></i>
							<p><b>{{$sale->branch->name??""}}</b><br>
							<p><b>{{$sale->branch->address??""}}</b><br>
								Phone:{{$sale->branch->phone??""}}<br>
								Email:{{$sale->branch->email??""}}</p>
						</div>
						<div class="col">
							<p>
								<b>Order No #{{$sale->reference_no}}</b><br>
								Purchase Status : <small><span style="border:1px solid Green;color:Green;padding: 3px;border-radius: 4px;"><i class="fas fa-times-circle"></i> {{$sale->payment_status}}</span></small><br>
								Invoice Date : {{$sale->created_att}}
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<table style="width:100%" id="tbl1" border="1" >
								<thead>
								<tr>
									<th style="padding:4px">#</th>
									<th style="padding:4px">Item Details $ Description</th>

									<th style="padding:4px">Qty</th>
									<th style="padding:4px;text-align:right">Unit</th>
									<th style="padding:4px;text-align:right">VAT</th>
									<th style="padding:4px;text-align:right">Total</th>
								</tr>
								</thead>
								<tbody>
								@if($items)
									@foreach($items as $item)
										<tr>
											<td style="padding:4px" valign="top">1</td>
											<td style="padding:4px" valign="top">{{$item->product->name??""}} <small>(#{{$item->product->code??""}})</small> ({{ ($item->type == "CASE")?"PACK":$item->type }})</td>

											<td style="padding:4px" valign="top">{{$item->qty??1}}</td>
											<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format($item->net_unit_price,2)}}</td>
											<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format($item->tax,2)}}</td>
											<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format((number_format($item->total,2)) + (number_format($item->tax,2)),2)}}</td>
										</tr>
									@endforeach
								@endif
								</tbody>
								<tfoot>
								<tr>
									<th colspan="5" style="text-align:right">Pickup Date : &nbsp;</th>
									<th style="text-align:right">{{$sale->pick_date}}</th>
								</tr>
								<tr>
									<th colspan="5" style="text-align:right">Pickup Time : &nbsp;</th>
									<th style="text-align:right">{{$sale->pick_time}}</th>
								</tr>
								<tr>
									<th colspan="5" style="text-align:right">Total Order Qty : &nbsp;</th>
									<th style="text-align:right">{{$sale->total_qty}}</th>
								</tr>
								<tr>
									<th colspan="5" style="text-align:right">Sub Total : &nbsp;</th>
									<th style="text-align:right">{{currency()}}{{number_format($sale->total_price,2)}}</th>
								</tr>
								<tr>
									<th colspan="5" style="text-align:right">VAT : &nbsp;</th>
									<th style="text-align:right">{{currency()}}{{number_format($sale->total_tax,2)}}</th>
								</tr>
								<tr>
									<th colspan="5" style="text-align:right">Delivery Charges : &nbsp;</th>
									<th style="text-align:right">{{currency()}}{{number_format($sale->delivery_charges,2)}}</th>
								</tr>
								<tr>
									<th colspan="5" style="text-align:right">Grand Total : &nbsp;</th>
									<th style="text-align:right">{{currency()}}{{number_format($sale->grand_total + $sale->delivery_charges,2)}}</th>
								</tr>
								</tfoot>
							</table>
							<hr>
							<center>
								<small>All goods remain the	property of ICS (UK) LTD until paid in full</small><br>
								<small>For support : E-mail support@icsukltd.co.uk | Download team viewer on the computer/laptop</small>
							</center>

						</div>
					</div>
				</div>
			</div>
			<!-- Right -->
		</div>
	</div>
</section>
<script src="{{ asset('app/js/plugins/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/barcode.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function(){
	JsBarcode("#barcode", "OR004324", {
	  lineColor: "#000",
	  width: 1.5,
	  height: 20,
	  displayValue: false
	});
});
</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
<script type="text/javascript">
function CreatePDFfromHTML() {
	$("#downloadContainer").show();
    var HTML_Width = $("#downloadContainer").width();
    var HTML_Height = $("#downloadContainer").height();
    var top_left_margin = 15;
    var PDF_Width = HTML_Width + (top_left_margin * 2);
    var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
    var canvas_image_width = HTML_Width;
    var canvas_image_height = HTML_Height;

    var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

    html2canvas($("#downloadContainer")[0]).then(function (canvas) {
        var imgData = canvas.toDataURL("image/jpeg", 1.0);
        var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
        pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
        for (var i = 1; i <= totalPDFPages; i++) {
            pdf.addPage(PDF_Width, PDF_Height);
            pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
        }
        pdf.save("purchase-order.pdf");
		$("#downloadContainer").hide();
        // $("#report-workplace").hide();
    });
}
</script>
			</body>
			</html> --}}
			<!DOCTYPE HTML>
			<html lang="eng">
			<head>
			<title>Invoice</title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta charset="utf-8">
			<link href="{{ asset('css/bootstrap-v4.css') }}" rel="stylesheet" />
			<link href="{{ asset('app/css/invoice.css') }}" rel="stylesheet" />
			<style type="text/css">
			body{
				font-family: 'Helvetica';
				font-size: 13px;
				text-transform: uppercase;
				letter-spacing: 0.3px;
			}
			@media print {
			  .printPageButton {
				display: none;
			  }
			}
			.greentext{
				color: #2d4936;
			}
			.greenbgset{
				background-color: #2d4936;
				color: #fff;
			}
			.tabledata th{
				background-color: #2d4936;
				color: #fff;
				padding: 0px;
			}
			.tabledata td{
				border-bottom:1px solid #ccc; 
			}
			.tabledata tfoot td{
				border-bottom:none;
			}
			
			.paymentstatus{
				border:1px solid {{($sale->payment_status='paid')?'green':'red'}};
				color:{{($sale->payment_status='paid')?'green':'red'}};
				padding: 3px;
				border-radius: 4px;
			}
			</style>
			
			</head>
			<body>
				</section>
				<section class="main-body p-t-10">
					<div class="container" style="background-color: #fff; background-color: #fff;
					padding: 30px;
					max-width: 980px;">
					
					  <table style="width: 100%">
						<tr style="border-bottom:3px solid #2d4936; middle-align:center">
							<td><img src="https://sale.cater-choice.com/frontend/assets/img/cater-logo.png" style="width:250px;"></td>
							<td style="text-align: right">
								<h4 class="greentext">{{$sale->reference_no}}</h4>
								Purchase Status : <small><span class="paymentstatus">
									<i class="fas fa-times-circle"></i> {{$sale->payment_status}}</span></small></td>
						</tr>
					  </table>
					  <br> <br>
					  <table style="width: 100%">
					<tr style="vertical-align: top;">
						<td style="width: 40%">
							<strong>TO :</strong><br>
							<b>{{$sale->branch->name??""}}</b><br>
							{{$sale->branch->address??""}}<br>
							{{$sale->branch->city??""}}<br>
							{{$sale->branch->postal_code??""}}</b><br>
							Great Britain</b>
						</td>
						<td style="width: 40%">
							<strong>Delivery Address:</strong><br>
							<b>{{$sale->branch->name??""}}</b><br>
							{{$sale->branch->address??""}}<br>
							{{$sale->branch->city??""}}<br>
							{{$sale->branch->postal_code??""}}</b><br>
							Great Britain</b></td>
			
							<td style="text-align: right;"><strong>From:</strong><br>
								<b>{{$sale->user->name??""}}</b><br>
								{{$sale->user->address??""}}<br>
							
					</tr>
					</table>
					<hr style="border: 1px solid #ccc;">
					<table style="width: 100%; margin-top:30px; ">
						<tr>
							<td style="vertical-align: top;">
								<table style="width: 100%; ">
									<tr>
										<td>Contact Name</td>
										<td>{{$sale->branch->name??""}}</td>
									</tr>
									<tr>
										<td><b>Email</b></td>
										<td>{{$sale->branch->email??""}}</td>
									</tr>
									<tr>
										<td><b>Phone</b></td>
										<td>{{$sale->branch->phone??""}}</td>
									</tr>
								</table>
							</td>
			
							<td style="text-align: right; vertical-align: top;">
								<table style="width: 100%">
									<tr>
										<td>Vat Reg. No.</td>
										<td>721264562</td>
									</tr>
									<tr>
										<td><b>Salesperson</b></td>
										<td><b>Website</b></td>
									</tr>
									<tr>
										<td><b>Email</b></td>
										<td><b>sales@icsukltd.co.uk</b></td>
									</tr>
									<tr>
										<td><b>Mobile</b></td>
										<td><b>07425791477</b></td>
									</tr>
									<tr>
										<td><b>Telephone</b></td>
										<td><b>01213579100</b></td>
									</tr>
								   </table>
								</td>
						</tr>
					</table>
					<table style="width: 100%; margin-top:50px;text-align:center; border-spacing: 3px;
					border-collapse: separate;" >
						<thead>
							<tr>
								<th class="greenbgset">Pickup Date</th>
								<th class="greenbgset">Pickup Time</th>
								<th class="greenbgset">Order Date</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>{{$sale->pick_date}}</td>
								<td>{{$sale->pick_time}}</td>
								<td>{{$sale->created_at}}</td>
							</tr>
						</tbody>
					</table>
			
					<table class="tabledata" style="width: 100%; margin-top:20px;text-align:center; border-spacing: 3px; border-collapse: separate;">
						<thead>
							<tr>
								<th style="padding:4px">Item No</th>
								<th style="padding:4px">Description</th>
								<th style="padding:4px">Type</th>
								<th style="padding:4px">Qty</th>
								<th style="padding:4px;text-align:right">Unit</th>
								<th style="padding:4px;text-align:right">VAT</th>
								<th style="padding:4px;text-align:right">Total</th>
							</tr>
						</thead>
						<tbody>
							@if($items)
							@foreach($items as $item)
										<tr>
											<td style="padding:4px" valign="top">{{$item->product->ms_id??""}}</td>
											<td style="padding:4px" valign="top">{{$item->product->name??""}}({{ ($item->type == "CASE")?"PACK":$item->type }})</td>
											<td style="padding:4px" valign="top">{{$item->type??""}}</td>
											<td style="padding:4px" valign="top">{{$item->qty??1}}</td>
											<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format($item->net_unit_price,2)}}</td>
											<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format($item->tax,2)}}</td>
											<td style="padding:4px;text-align:right" valign="top"><i class="fas fa-pound-sign"></i> {{currency()}}{{number_format((number_format($item->total,2)) + (number_format($item->tax,2)),2)}}</td>
										</tr>
										@endforeach
										@endif
							</tbody>
						<tfoot>
							
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<th style="text-align:right">Total Order Qty : &nbsp;</th>
								<td style="text-align:right;font-size:14px;font-weight:bold">{{$sale->total_qty}}</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<th style="text-align:right">Sub Total : &nbsp;</th>
								<td style="text-align:right;font-size:14px;font-weight:bold">{{currency()}}{{number_format($sale->total_price,2)}}</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<th style="text-align:right">VAT : &nbsp;</th>
								<td style="text-align:right;font-size:14px;font-weight:bold">{{currency()}}{{number_format($sale->total_tax,2)}}</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<th style="text-align:right">Delivery Charges : &nbsp;</th>
								<td style="text-align:right;font-size:14px;font-weight:bold">{{currency()}}{{number_format($sale->delivery_charges,2)}}</td>
							</tr>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<th style="text-align:right">Grand Total : &nbsp;</th>
								<td style="text-align:right;font-size:14px;font-weight:bold">{{currency()}}{{number_format($sale->grand_total + $sale->delivery_charges,2)}}</td>
							</tr>
						</tfoot>
					</table>
					<table class="tabledata" style="width: 100%; margin-top:20px;text-align:center; border-spacing: 3px; border-collapse: separate;">
						<tr>
							<td><hr>
										<center>
											<small>All goods remain the	property of ICS (UK) LTD until paid in full</small><br>
											<small>For support : E-mail support@icsukltd.co.uk | Download team viewer on the computer/laptop</small>
										</center>
										</td>
						</tr>
					</table>
					</div>
				</section>
			
			
						</body>
						</html>
			
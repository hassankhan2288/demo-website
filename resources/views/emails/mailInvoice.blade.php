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
			</style>
			
			</head>
			<body>
				<section class="main-body p-t-10">
					<div class="container" style="background-color: #fff; background-color: #fff;
					padding: 30px;
					max-width: 980px;">
					
					  <table style="width: 100%">
						<tr style="border-bottom:3px solid #2d4936; middle-align:center">
							<td><img src="{{asset('frontend/assets/img/demo.png')}}" style="width:250px;"></td>
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

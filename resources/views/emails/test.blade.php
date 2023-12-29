<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8" />
  </head>
  <body>
    <div style="text-align: center; width:80%;">
      <img src="https://cater-choice.com/frontend/assets/img/cater-mail-logo.jpeg" alt="cater choice logo">
    </div>
    <div style="text-align: left;">
      {{-- <h2>Cater Choice Order</h2> --}}
      <p>Dear, {{ $name }}</p>
      <p>{{ $test_message }}</p>
      <br>
      <p>Thank you.</p>
      <br>
      <p>Regards,</p>
      <p>Cater Choice Team</p>
    </div>
    <br><br><br>
    <section style="display: block;">
      <div style="width: 90%;padding-right: 15px;padding-left: 15px; margin-right: auto; margin-left: auto;float:left;">
          <!-- Right -->
        <div style="width:100%; display:inline-block;" class="row">
          <div style="max-width: 100%;">
            <div style="" class="index-boxes m-t-20 p-20" id="downloadContainer">
              <div style="width:100%; display:inline-block;" class="row">
                <div style="width:50%; display:inline-block;float:left;" class="col-md-3">
                  <img src="https://cater-choice.com/frontend/assets/img/cater-mail-logo.jpeg" style="width:150px;">
                </div>
                <div style="width:50%; display:inline-block;float:left;" class="col-md-3">
                  <div style="width:100%;text-align: right;"><h4>#{{$sale->reference_no}}</h4></div>
                </div>
              </div>
              <div style="width:100%; display:inline-block;float:left;" class="row">
                <div style="width:33.33%; display:inline-block;" class="col-md-4">
                  <i><b>From</b></i>
                  <p><b>{{$sale->user->name??""}}</p>
                  <p><b>{{$sale->user->address??""}}</b><br>
                   Phone:{{$sale->user->phone??""}}<br>
                   Email:{{$sale->user->email??""}}</p>
                </div>
                <div style="width:33.33%; display:inline-block;float:left;" class="col-md-4">
                  <i><b>Buyer Details</b></i>
                  <p><b>{{$sale->branch->name??""}}</p>
                  <p><b>{{$sale->branch->address??""}}</b><br>
                   Phone:{{$sale->branch->phone??""}}<br>
                   Email:{{$sale->branch->email??""}}</p>
                </div>
                <div style="width:33.33%; display:inline-block;float:left;" class="col-md-4">
                  <p>
                    <b>Order No #{{$sale->reference_no}}</b><br>
                    Purchase Status : <small><span style="border:1px solid red;color:red;padding: 3px;border-radius: 4px;"><i class="fas fa-times-circle"></i> {{$sale->payment_status}}</span></small><br>
                    Invoice Date : {{$sale->created_att}}
                  </p>
                </div>
              </div>
              <div style="width:100%; display:inline-block;" class="row">
                <div style="width:100%" class="col-md-12">
                  <table style="width:100%" id="tbl1" border="1" >
                    <thead>
                      <tr>
                        <th style="padding:4px">#</th>
                        <th style="padding:4px">Item Details &amp; Description</th>
                        
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
  </body>
</html>
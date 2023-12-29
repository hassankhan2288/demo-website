@extends('layouts.branch')

@section('content')
@if($errors->has('phone_number'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('phone_number') }}</div>
@endif
@if(session()->has('message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section class="forms pos-section">
    <div class="container-fluid">
        <div class="row">
            <audio id="mysoundclip1" preload="auto">
                <source src="{{url('public/beep/beep-timber.mp3')}}"></source>
            </audio>
            <audio id="mysoundclip2" preload="auto">
                <source src="{{url('public/beep/beep-07.mp3')}}"></source>
            </audio>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body" style="padding-bottom: 0">
                        {!! Form::open(['route' => 'pos.sales.store', 'method' => 'post', 'files' => true, 'class' => 'payment-form']) !!}
                        @php
                           
                                $keybord_active = 0;

                            $customer_active = DB::table('permissions')
                              ->join('role_has_permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                              ->where([
                                ['permissions.name', 'customers-add'],
                                ['role_id', \Auth::user()->role_id] ])->first();
                        @endphp
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <input type="text" name="created_at" class="form-control date" placeholder="Choose date" onkeyup='saveValue(this);'/>
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-group">
                                          <input type="text" id="reference-no" name="reference_no" class="form-control" placeholder="Type reference number" onkeyup='saveValue(this);'/>
                                      </div>
                                      @if($errors->has('reference_no'))
                                       <span>
                                           <strong>{{ $errors->first('reference_no') }}</strong>
                                        </span>
                                        @endif
                                    </div>

    
                                    
                                    <div class="col-md-12">
                                        <div class="search-box form-group">
                                            <input type="text" name="product_code_name" id="lims_productcodeSearch" placeholder="Scan/Search product by name/code" class="form-control"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="table-responsive transaction-list">
                                        <table id="myTable" class="table table-hover table-striped order-list table-fixed">
                                            <thead>
                                                <tr>
                                                    <th class="col-sm-2">{{trans('file.product')}}</th>
                                                    <th class="col-sm-2">{{trans('file.Batch No')}}</th>
                                                    <th class="col-sm-2">{{trans('file.Price')}}</th>
                                                    <th class="col-sm-3">{{trans('file.Quantity')}}</th>
                                                    <th class="col-sm-3">{{trans('file.Subtotal')}}</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody-id">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="row" style="display: none;">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_qty" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_discount" value="0.00" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_tax" value="0.00"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="total_price" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="item" />
                                            <input type="hidden" name="order_tax" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <input type="hidden" name="grand_total" />
                                            <input type="hidden" name="used_points" />
                                            <input type="hidden" name="coupon_discount" />
                                            <input type="hidden" name="sale_status" value="1" />
                                            <input type="hidden" name="coupon_active">
                                            <input type="hidden" name="coupon_id">
                                            <input type="hidden" name="coupon_discount" />

                                            <input type="hidden" name="pos" value="1" />
                                            <input type="hidden" name="draft" value="0" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 totals" style="border-top: 2px solid #e4e6fc; padding-top: 10px;">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <span class="totals-title">{{trans('file.Items')}}</span><span id="item">0</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="totals-title">{{trans('file.Total')}}</span><span id="subtotal">0.00</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="totals-title">{{trans('file.Discount')}} <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#order-discount-modal"> <i class="dripicons-document-edit"></i></button></span><span id="discount">0.00</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="totals-title">{{trans('file.Coupon')}} <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#coupon-modal"><i class="dripicons-document-edit"></i></button></span><span id="coupon-text">0.00</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="totals-title">{{trans('file.Tax')}} <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#order-tax"><i class="dripicons-document-edit"></i></button></span><span id="tax">0.00</span>
                                        </div>
                                        <div class="col-sm-4">
                                            <span class="totals-title">{{trans('file.Shipping')}} <button type="button" class="btn btn-link btn-sm" data-toggle="modal" data-target="#shipping-cost-modal"><i class="dripicons-document-edit"></i></button></span><span id="shipping-cost">0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="payment-amount">
                        <h2>{{trans('file.grand total')}} <span id="grand-total">0.00</span></h2>
                    </div>
                    <div class="payment-options">
                        <div class="column-5">
                            <button style="background: #0984e3" type="button" class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="credit-card-btn"><i class="fa fa-credit-card"></i> {{trans('file.Card')}}</button>
                        </div>
                        <div class="column-5">
                            <button style="background: #00cec9" type="button" class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="cash-btn"><i class="fa fa-money"></i> {{trans('file.Cash')}}</button>
                        </div>
                        <div class="column-5">
                            <button style="background-color: #213170" type="button" class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="paypal-btn"><i class="fa fa-paypal"></i> {{trans('file.PayPal')}}</button>
                        </div>
                        <div class="column-5">
                            <button style="background-color: #e28d02" type="button" class="btn btn-custom" id="draft-btn"><i class="dripicons-flag"></i> {{trans('file.Draft')}}</button>
                        </div>
                        <div class="column-5">
                            <button style="background-color: #fd7272" type="button" class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="cheque-btn"><i class="fa fa-money"></i> {{trans('file.Cheque')}}</button>
                        </div>
                        <div class="column-5">
                            <button style="background-color: #5f27cd" type="button" class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="gift-card-btn"><i class="fa fa-credit-card-alt"></i> {{trans('file.Gift Card')}}</button>
                        </div>
                        <div class="column-5">
                            <button style="background-color: #b33771" type="button" class="btn btn-custom payment-btn" data-toggle="modal" data-target="#add-payment" id="deposit-btn"><i class="fa fa-university"></i> {{trans('file.Deposit')}}</button>
                        </div>
 
                        <div class="column-5">
                            <button style="background-color: #d63031;" type="button" class="btn btn-custom" id="cancel-btn" onclick="return confirmCancel()"><i class="fa fa-close"></i> {{trans('file.Cancel')}}</button>
                        </div>
                        <div class="column-5">
                            <button style="background-color: #ffc107;" type="button" class="btn btn-custom" data-toggle="modal" data-target="#recentTransaction"><i class="dripicons-clock"></i> {{trans('file.Recent Transaction')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- payment modal -->
            <div id="add-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Finalize Sale')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6 mt-1">
                                            <label>{{trans('file.Recieved Amount')}} *</label>
                                            <input type="text" name="paying_amount" class="form-control numkey" required step="any">
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>{{trans('file.Paying Amount')}} *</label>
                                            <input type="text" name="paid_amount" class="form-control numkey"  step="any">
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <label>{{trans('file.Change')}} : </label>
                                            <p id="change" class="ml-2">0.00</p>
                                        </div>
                                        <div class="col-md-6 mt-1">
                                            <input type="hidden" name="paid_by_id">
                                            <label>{{trans('file.Paid By')}}</label>
                                            <select name="paid_by_id_select" class="form-control selectpicker">
                                                <option value="1">Cash</option>
                                                <option value="2">Gift Card</option>
                                                <option value="3">Credit Card</option>
                                                <option value="4">Cheque</option>
                                                <option value="5">Paypal</option>
                                                <option value="6">Deposit</option>
                 
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12 mt-3">
                                            <div class="card-element form-control">
                                            </div>
                                            <div class="card-errors" role="alert"></div>
                                        </div>
                                        <div class="form-group col-md-12 gift-card">
                                            <label> {{trans('file.Gift Card')}} *</label>
                                            <input type="hidden" name="gift_card_id">
                                            <select id="gift_card_id_select" name="gift_card_id_select" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Gift Card..."></select>
                                        </div>
                                        <div class="form-group col-md-12 cheque">
                                            <label>{{trans('file.Cheque Number')}} *</label>
                                            <input type="text" name="cheque_no" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>{{trans('file.Payment Note')}}</label>
                                            <textarea id="payment_note" rows="2" class="form-control" name="payment_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                       <div class="col-md-6 form-group">
                                            <label>{{trans('file.Sale Note')}}</label>
                                            <textarea rows="3" class="form-control" name="sale_note"></textarea>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>{{trans('file.Staff Note')}}</label>
                                            <textarea rows="3" class="form-control" name="staff_note"></textarea>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button id="submit-btn" type="button" class="btn btn-primary">{{trans('file.submit')}}</button>
                                    </div>
                                </div>
                                <div class="col-md-2 qc" data-initial="1">
                                    <h4><strong>{{trans('file.Quick Cash')}}</strong></h4>
                                    <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="10" type="button">10</button>
                                    <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="20" type="button">20</button>
                                    <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="50" type="button">50</button>
                                    <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="100" type="button">100</button>
                                    <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="500" type="button">500</button>
                                    <button class="btn btn-block btn-primary qc-btn sound-btn" data-amount="1000" type="button">1000</button>
                                    <button class="btn btn-block btn-danger qc-btn sound-btn" data-amount="0" type="button">{{trans('file.Clear')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- order_discount modal -->
            <div id="order-discount-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('file.Order Discount')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Order Discount Type')}}</label>
                                    <select id="order-discount-type" name="order_discount_type_select" class="form-control">
                                      <option value="Flat">{{trans('file.Flat')}}</option>
                                      <option value="Percentage">{{trans('file.Percentage')}}</option>
                                    </select>
                                    <input type="hidden" name="order_discount_type">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>{{trans('file.Value')}}</label>
                                    <input type="text" name="order_discount_value" class="form-control numkey" id="order-discount-val" onkeyup='saveValue(this);'>
                                    <input type="hidden" name="order_discount" class="form-control" id="order-discount" onkeyup='saveValue(this);'>
                                </div>
                            </div>
                            <button type="button" name="order_discount_btn" class="btn btn-primary" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- coupon modal -->
            <div id="coupon-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('file.Coupon Code')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" id="coupon-code" class="form-control" placeholder="Type Coupon Code...">
                            </div>
                            <button type="button" class="btn btn-primary coupon-check" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- order_tax modal -->
            <div id="order-tax" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('file.Order Tax')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" name="order_tax_rate">
                                <select class="form-control" name="order_tax_rate_select" id="order-tax-rate-select">
                                    <option value="0">No Tax</option>
                                    @foreach($lims_tax_list as $tax)
                                    <option value="{{$tax->rate}}">{{$tax->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="button" name="order_tax_btn" class="btn btn-primary" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- shipping_cost modal -->
            <div id="shipping-cost-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{trans('file.Shipping Cost')}}</h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" name="shipping_cost" class="form-control numkey" id="shipping-cost-val" step="any" onkeyup='saveValue(this);'>
                            </div>
                            <button type="button" name="shipping_cost_btn" class="btn btn-primary" data-dismiss="modal">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
            </div>

            {!! Form::close() !!}
            <!-- product list -->
            
            <!-- product edit modal -->
            <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 id="modal_header" class="modal-title"></h5>
                            <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row modal-element">
                                    <div class="col-md-4 form-group">
                                        <label>{{trans('file.Quantity')}}</label>
                                        <input type="text" name="edit_qty" class="form-control numkey">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{trans('file.Unit Discount')}}</label>
                                        <input type="text" name="edit_discount" class="form-control numkey">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>{{trans('file.Unit Price')}}</label>
                                        <input type="text" name="edit_unit_price" class="form-control numkey" step="any">
                                    </div>
                                    <?php
                                        $tax_name_all[] = 'No Tax';
                                        $tax_rate_all[] = 0;
                                        foreach($lims_tax_list as $tax) {
                                            $tax_name_all[] = $tax->name;
                                            $tax_rate_all[] = $tax->rate;
                                        }
                                    ?>
                                    <div class="col-md-4 form-group">
                                        <label>{{trans('file.Tax Rate')}}</label>
                                        <select name="edit_tax_rate" class="form-control selectpicker">
                                            @foreach($tax_name_all as $key => $name)
                                            <option value="{{$key}}">{{$name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div id="edit_unit" class="col-md-4 form-group">
                                        <label>{{trans('file.Product Unit')}}</label>
                                        <select name="edit_unit" class="form-control selectpicker">
                                        </select>
                                    </div>
                                </div>
                                <button type="button" name="update_btn" class="btn btn-primary">{{trans('file.update')}}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- recent transaction modal -->
        
  
            <!-- cash register details modal -->
            <div id="register-details-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Cash Register Details')}}</h5>
                      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                      <p>{{trans('file.Please review the transaction and payments.')}}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                          <td>{{trans('file.Cash in Hand')}}:</td>
                                          <td id="cash_in_hand" class="text-right">0</td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Total Sale Amount')}}:</td>
                                          <td id="total_sale_amount" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Total Payment')}}:</td>
                                          <td id="total_payment" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Cash Payment')}}:</td>
                                          <td id="cash_payment" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Credit Card Payment')}}:</td>
                                          <td id="credit_card_payment" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Cheque Payment')}}:</td>
                                          <td id="cheque_payment" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Gift Card Payment')}}:</td>
                                          <td id="gift_card_payment" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Deposit Payment')}}:</td>
                                          <td id="deposit_payment" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Paypal Payment')}}:</td>
                                          <td id="paypal_payment" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Total Sale Return')}}:</td>
                                          <td id="total_sale_return" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Total Expense')}}:</td>
                                          <td id="total_expense" class="text-right"></td>
                                        </tr>
                                        <tr>
                                          <td><strong>{{trans('file.Total Cash')}}:</strong></td>
                                          <td id="total_cash" class="text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <!-- today sale modal -->
            <div id="today-sale-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Today Sale')}}</h5>
                      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                      <p>{{trans('file.Please review the transaction and payments.')}}</p>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                          <td>{{trans('file.Total Sale Amount')}}:</td>
                                          <td class="total_sale_amount text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Cash Payment')}}:</td>
                                          <td class="cash_payment text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Credit Card Payment')}}:</td>
                                          <td class="credit_card_payment text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Cheque Payment')}}:</td>
                                          <td class="cheque_payment text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Gift Card Payment')}}:</td>
                                          <td class="gift_card_payment text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Deposit Payment')}}:</td>
                                          <td class="deposit_payment text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Paypal Payment')}}:</td>
                                          <td class="paypal_payment text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Total Payment')}}:</td>
                                          <td class="total_payment text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Total Sale Return')}}:</td>
                                          <td class="total_sale_return text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Total Expense')}}:</td>
                                          <td class="total_expense text-right"></td>
                                        </tr>
                                        <tr>
                                          <td><strong>{{trans('file.Total Cash')}}:</strong></td>
                                          <td class="total_cash text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
            <!-- today profit modal -->
            <div id="today-profit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                <div role="document" class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Today Profit')}}</h5>
                      <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12 mt-2">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                          <td>{{trans('file.Product Revenue')}}:</td>
                                          <td class="product_revenue text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Product Cost')}}:</td>
                                          <td class="product_cost text-right"></td>
                                        </tr>
                                        <tr>
                                          <td>{{trans('file.Expense')}}:</td>
                                          <td class="expense_amount text-right"></td>
                                        </tr>
                                        <tr>
                                          <td><strong>{{trans('file.Profit')}}:</strong></td>
                                          <td class="profit text-right"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection


@section('scripts')">
<script src="{{ asset('vendor/jquery/jquery-ui.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('vendor/keyboard/js/jquery.keyboard.js') }}"></script>
<script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
<script type="text/javascript">

    $("ul#sale").siblings('a').attr('aria-expanded','true');
    $("ul#sale").addClass("show");
    $("ul#sale #sale-pos-menu").addClass("active");

    var public_key = "";
    var alert_product = {};
    var currency = "";
    var valid;

// array data depend on warehouse
var lims_product_array = [];
var product_code = [];
var product_name = [];
var product_qty = [];
var product_type = [];
var product_id = [];
var product_list = [];
var qty_list = [];

// array data with selection
var product_price = [];
var product_discount = [];
var tax_rate = [];
var tax_name = [];
var tax_method = [];
var unit_name = [];
var unit_operator = [];
var unit_operation_value = [];
var is_imei = [];
var is_variant = [];
var gift_card_amount = [];
var gift_card_expense = [];

// temporary array
var temp_unit_name = [];
var temp_unit_operator = [];
var temp_unit_operation_value = [];

var deposit = {};
var points = 0;
var reward_point_setting = {};

var product_row_number = 0;
var rowindex;
var customer_group_rate;
var row_product_price;
var pos;
var keyboard_active = {}
var role_id = 0;
var warehouse_id = 0;
var biller_id = 0;
var coupon_list = [];
var currency = {'exchange_rate':0};

var localStorageQty = [];
var localStorageProductId = [];
var localStorageProductDiscount = [];
var localStorageTaxRate = [];
var localStorageNetUnitPrice = [];
var localStorageTaxValue = [];
var localStorageTaxName = [];
var localStorageTaxMethod = [];
var localStorageSubTotalUnit = [];
var localStorageSubTotal = [];
var localStorageProductCode = [];
var localStorageSaleUnit = [];
var localStorageTempUnitName = [];
var localStorageSaleUnitOperator = [];
var localStorageSaleUnitOperationValue = [];

$("#reference-no").val(getSavedValue("reference-no"));
$("#order-discount").val(getSavedValue("order-discount"));
$("#order-discount-val").val(getSavedValue("order-discount-val"));
$("#order-discount-type").val(getSavedValue("order-discount-type"));
$("#order-tax-rate-select").val(getSavedValue("order-tax-rate-select"));


$("#shipping-cost-val").val(getSavedValue("shipping-cost-val"));

if(localStorage.getItem("tbody-id")) {
  $("#tbody-id").html(localStorage.getItem("tbody-id"));
}

function saveValue(e) {
    var id = e.id;  // get the sender's id to save it.
    var val = e.value; // get the value.
    localStorage.setItem(id, val);// Every time user writing something, the localStorage's value will override.
}
//get the saved value function - return the value of "v" from localStorage.
function getSavedValue  (v) {
    if (!localStorage.getItem(v)) {
        return "";// You can change this to your defualt value.
    }
    return localStorage.getItem(v);
}

if(getSavedValue("localStorageQty")) {
  localStorageQty = getSavedValue("localStorageQty").split(",");
  localStorageProductDiscount = getSavedValue("localStorageProductDiscount").split(",");
  localStorageTaxRate = getSavedValue("localStorageTaxRate").split(",");
  localStorageNetUnitPrice = getSavedValue("localStorageNetUnitPrice").split(",");
  localStorageTaxValue = getSavedValue("localStorageTaxValue").split(",");
  localStorageTaxName = getSavedValue("localStorageTaxName").split(",");
  localStorageTaxMethod = getSavedValue("localStorageTaxMethod").split(",");
  localStorageSubTotalUnit = getSavedValue("localStorageSubTotalUnit").split(",");
  localStorageSubTotal = getSavedValue("localStorageSubTotal").split(",");
  localStorageProductId = getSavedValue("localStorageProductId").split(",");
  localStorageProductCode = getSavedValue("localStorageProductCode").split(",");
  localStorageSaleUnit = getSavedValue("localStorageSaleUnit").split(",");
  localStorageTempUnitName = getSavedValue("localStorageTempUnitName").split(",,");
  localStorageSaleUnitOperator = getSavedValue("localStorageSaleUnitOperator").split(",,");
  localStorageSaleUnitOperationValue = getSavedValue("localStorageSaleUnitOperationValue").split(",,");
  /*localStorageQty.pop();
  localStorage.setItem("localStorageQty", localStorageQty);*/
  for(var i = 0; i < localStorageQty.length; i++) {
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ') .qty').val(localStorageQty[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.discount-value').val(localStorageProductDiscount[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-rate').val(localStorageTaxRate[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.net_unit_price').val(localStorageNetUnitPrice[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-value').val(localStorageTaxValue[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-name').val(localStorageTaxName[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-method').val(localStorageTaxMethod[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.product-price').text(localStorageSubTotalUnit[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sub-total').text(localStorageSubTotal[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.subtotal-value').val(localStorageSubTotal[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.product-id').val(localStorageProductId[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.product-code').val(localStorageProductCode[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit').val(localStorageSaleUnit[i]);
    if(i==0) {
      localStorageTempUnitName[i] += ',';
      localStorageSaleUnitOperator[i] += ',';
      localStorageSaleUnitOperationValue[i] += ',';
    }
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit-operator').val(localStorageSaleUnitOperator[i]);
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit-operation-value').val(localStorageSaleUnitOperationValue[i]);

    product_price.push(parseFloat($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.product_price').val()));
    var quantity = parseFloat($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.qty').val());
    product_discount.push(parseFloat(localStorageProductDiscount[i] / localStorageQty[i]).toFixed(2));
    tax_rate.push(parseFloat($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-rate').val()));
    tax_name.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-name').val());
    tax_method.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.tax-method').val());
    temp_unit_name = $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit').val().split(',');
    unit_name.push(localStorageTempUnitName[i]);
    unit_operator.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit-operator').val());
    unit_operation_value.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit-operation-value').val());
    $('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.sale-unit').val(temp_unit_name[0]);
    calculateTotal();
    //calculateRowProductData(localStorageQty[i]);
  }
}


$('.selectpicker').selectpicker({
  style: 'btn-link',
});

if(keyboard_active==1){

    $("input.numkey:text").keyboard({
        usePreview: false,
        layout: 'custom',
        display: {
        'accept'  : '&#10004;',
        'cancel'  : '&#10006;'
        },
        customLayout : {
          'normal' : ['1 2 3', '4 5 6', '7 8 9','0 {dec} {bksp}','{clear} {cancel} {accept}']
        },
        restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
        preventPaste : true,  // prevent ctrl-v and right click
        autoAccept : true,
        css: {
            // input & preview
            // keyboard container
            container: 'center-block dropdown-menu', // jumbotron
            // default state
            buttonDefault: 'btn btn-default',
            // hovered button
            buttonHover: 'btn-primary',
            // Action keys (e.g. Accept, Cancel, Tab, etc);
            // this replaces "actionClass" option
            buttonAction: 'active'
        },
    });

    $('input[type="text"]').keyboard({
        usePreview: false,
        autoAccept: true,
        autoAcceptOnEsc: true,
        css: {
            // input & preview
            // keyboard container
            container: 'center-block dropdown-menu', // jumbotron
            // default state
            buttonDefault: 'btn btn-default',
            // hovered button
            buttonHover: 'btn-primary',
            // Action keys (e.g. Accept, Cancel, Tab, etc);
            // this replaces "actionClass" option
            buttonAction: 'active',
            // used when disabling the decimal button {dec}
            // when a decimal exists in the input area
            buttonDisabled: 'disabled'
        },
        change: function(e, keyboard) {
                keyboard.$el.val(keyboard.$preview.val())
                keyboard.$el.trigger('propertychange')
              }
    });

    $('textarea').keyboard({
        usePreview: false,
        autoAccept: true,
        autoAcceptOnEsc: true,
        css: {
            // input & preview
            // keyboard container
            container: 'center-block dropdown-menu', // jumbotron
            // default state
            buttonDefault: 'btn btn-default',
            // hovered button
            buttonHover: 'btn-primary',
            // Action keys (e.g. Accept, Cancel, Tab, etc);
            // this replaces "actionClass" option
            buttonAction: 'active',
            // used when disabling the decimal button {dec}
            // when a decimal exists in the input area
            buttonDisabled: 'disabled'
        },
        change: function(e, keyboard) {
                keyboard.$el.val(keyboard.$preview.val())
                keyboard.$el.trigger('propertychange')
              }
    });

    $('#lims_productcodeSearch').keyboard().autocomplete().addAutocomplete({
        // add autocomplete window positioning
        // options here (using position utility)
        position: {
          of: '#lims_productcodeSearch',
          my: 'top+18px',
          at: 'center',
          collision: 'flip'
        }
    });
}

  $("li#notification-icon").on("click", function (argument) {
      $.get('notifications/mark-as-read', function(data) {
          $("span.notification-number").text(alert_product);
      });
  });

  $("#register-details-btn").on("click", function (e) {
      e.preventDefault();
      $.ajax({
          url: 'cash-register/showDetails/'+warehouse_id,
          type: "GET",
          success:function(data) {
              $('#register-details-modal #cash_in_hand').text(data['cash_in_hand']);
              $('#register-details-modal #total_sale_amount').text(data['total_sale_amount']);
              $('#register-details-modal #total_payment').text(data['total_payment']);
              $('#register-details-modal #cash_payment').text(data['cash_payment']);
              $('#register-details-modal #credit_card_payment').text(data['credit_card_payment']);
              $('#register-details-modal #cheque_payment').text(data['cheque_payment']);
              $('#register-details-modal #gift_card_payment').text(data['gift_card_payment']);
              $('#register-details-modal #deposit_payment').text(data['deposit_payment']);
              $('#register-details-modal #paypal_payment').text(data['paypal_payment']);
              $('#register-details-modal #total_sale_return').text(data['total_sale_return']);
              $('#register-details-modal #total_expense').text(data['total_expense']);
              $('#register-details-modal #total_cash').text(data['total_cash']);
              $('#register-details-modal input[name=cash_register_id]').val(data['id']);
          }
      });
      $('#register-details-modal').modal('show');
  });

  $("#today-sale-btn").on("click", function (e) {
      e.preventDefault();
      $.ajax({
          url: 'sales/today-sale/',
          type: "GET",
          success:function(data) {
              $('#today-sale-modal .total_sale_amount').text(data['total_sale_amount']);
              $('#today-sale-modal .total_payment').text(data['total_payment']);
              $('#today-sale-modal .cash_payment').text(data['cash_payment']);
              $('#today-sale-modal .credit_card_payment').text(data['credit_card_payment']);
              $('#today-sale-modal .cheque_payment').text(data['cheque_payment']);
              $('#today-sale-modal .gift_card_payment').text(data['gift_card_payment']);
              $('#today-sale-modal .deposit_payment').text(data['deposit_payment']);
              $('#today-sale-modal .paypal_payment').text(data['paypal_payment']);
              $('#today-sale-modal .total_sale_return').text(data['total_sale_return']);
              $('#today-sale-modal .total_expense').text(data['total_expense']);
              $('#today-sale-modal .total_cash').text(data['total_cash']);
          }
      });
      $('#today-sale-modal').modal('show');
  });

  $("#today-profit-btn").on("click", function (e) {
      e.preventDefault();
      calculateTodayProfit(0);
  });

  $("#today-profit-modal select[name=warehouseId]").on("change", function() {
      calculateTodayProfit($(this).val());
  });

  function calculateTodayProfit(warehouse_id) {
      $.ajax({
            url: 'sales/today-profit/' + warehouse_id,
            type: "GET",
            success:function(data) {
                $('#today-profit-modal .product_revenue').text(data['product_revenue']);
                $('#today-profit-modal .product_cost').text(data['product_cost']);
                $('#today-profit-modal .expense_amount').text(data['expense_amount']);
                $('#today-profit-modal .profit').text(data['profit']);
            }
        });
      $('#today-profit-modal').modal('show');
  }

if(role_id > 2){
    $('#biller_id').addClass('d-none');
    $('#warehouse_id').addClass('d-none');
    $('select[name=warehouse_id]').val(warehouse_id);
    $('select[name=biller_id]').val(biller_id);
    isCashRegisterAvailable(warehouse_id);
}
else {
    if(getSavedValue("warehouse_id")){
      warehouse_id = getSavedValue("warehouse_id");
    }
    else {
      warehouse_id = $("input[name='warehouse_id_hidden']").val();
    }

    if(getSavedValue("biller_id")){
      biller_id = getSavedValue("biller_id");
    }
    else {
      biller_id = $("input[name='biller_id_hidden']").val();
    }
    $('select[name=warehouse_id]').val(warehouse_id);
    $('select[name=biller_id]').val(biller_id);
}

  if(getSavedValue("biller_id")) {
    $('select[name=customer_id]').val(getSavedValue("customer_id"));
  }
  else {
    $('select[name=customer_id]').val($("input[name='customer_id_hidden']").val());
  }

$('.selectpicker').selectpicker('refresh');

var id = $("#customer_id").val();

var id = $("#warehouse_id").val();
$.get('sales/getproduct', function(data) {
    lims_product_array = [];
    product_code = data[0];
    product_name = data[1];
    product_qty = data[2];
    product_type = data[3];
    product_id = data[4];
    product_list = data[5];
    qty_list = data[6];
    product_warehouse_price = data[7];
    batch_no = data[8];
    product_batch_id = data[9];
    is_embeded = data[11];
    $.each(product_code, function(index) {
        if(is_embeded[index])
            lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')|' + is_embeded[index]);
        else
            lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
    });
});

//isCashRegisterAvailable(id);

function isCashRegisterAvailable(warehouse_id) {
    $.ajax({
        url: 'cash-register/check-availability/'+warehouse_id,
        type: "GET",
        success:function(data) {
            if(data == 'false') {
              $("#register-details-btn").addClass('d-none');
              $('#cash-register-modal select[name=warehouse_id]').val(warehouse_id);

              if(role_id <= 2)
                $("#cash-register-modal .warehouse-section").removeClass('d-none');
              else
                $("#cash-register-modal .warehouse-section").addClass('d-none');

              $('.selectpicker').selectpicker('refresh');
              $("#cash-register-modal").modal('show');
            }
            else
              $("#register-details-btn").removeClass('d-none');
        }
    });
}

if(keyboard_active==1){
    $('#lims_productcodeSearch').bind('keyboardChange', function (e, keyboard, el) {
        var customer_id = $('#customer_id').val();
        var warehouse_id = $('select[name="warehouse_id"]').val();
        temp_data = $('#lims_productcodeSearch').val();
        if(!customer_id){
            //$('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            //alert('Please select Customer!');
        }
        else if(!warehouse_id){
            //$('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            //alert('Please select Warehouse!');
        }
    });
}
else{
    $('#lims_productcodeSearch').on('input', function(){
        var customer_id = $('#customer_id').val();
        var warehouse_id = $('#warehouse_id').val();
        temp_data = $('#lims_productcodeSearch').val();
        if(!customer_id){
            //$('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            //alert('Please select Customer!');
        }
        else if(!warehouse_id){
            //$('#lims_productcodeSearch').val(temp_data.substring(0, temp_data.length - 1));
            //alert('Please select Warehouse!');
        }

    });
}

$("#print-btn").on("click", function(){
      var divToPrint=document.getElementById('sale-details');
      var newWin=window.open('','Print-Window');
      newWin.document.open();
      newWin.document.write('<link rel="stylesheet" href="<?php echo asset('vendor/bootstrap/css/bootstrap.min.css') ?>" type="text/css"><style type="text/css">@media print {.modal-dialog { max-width: 1000px;} }</style><body onload="window.print()">'+divToPrint.innerHTML+'</body>');
      newWin.document.close();
      setTimeout(function(){newWin.close();},10);
});

$('body').on('click', function(e){
    $('.filter-window').hide('slide', {direction: 'right'}, 'fast');
});

$('#category-filter').on('click', function(e){
    e.stopPropagation();
    $('.filter-window').show('slide', {direction: 'right'}, 'fast');
    $('.category').show();
    $('.brand').hide();
});

$('.category-img').on('click', function(){
    var category_id = $(this).data('category');
    var brand_id = 0;

    $(".table-container").children().remove();
    $.get('sales/getproduct/' + category_id + '/' + brand_id, function(data) {
        populateProduct(data);
    });
});

$('#brand-filter').on('click', function(e){
    e.stopPropagation();
    $('.filter-window').show('slide', {direction: 'right'}, 'fast');
    $('.brand').show();
    $('.category').hide();
});

$('.brand-img').on('click', function(){
    var brand_id = $(this).data('brand');
    var category_id = 0;

    $(".table-container").children().remove();
    $.get('sales/getproduct/' + category_id + '/' + brand_id, function(data) {
        populateProduct(data);
    });
});

$('#featured-filter').on('click', function(){
    $(".table-container").children().remove();
    $.get('sales/getfeatured', function(data) {
        populateProduct(data);
    });
});

function populateProduct(data) {
    var tableData = '<table id="product-table" class="table no-shadow product-list"> <thead class="d-none"> <tr> <th></th> <th></th> <th></th> <th></th> <th></th> </tr></thead> <tbody><tr>';

    if (Object.keys(data).length != 0) {
        $.each(data['name'], function(index) {
            var product_info = data['code'][index]+' (' + data['name'][index] + ')';
            if(index % 5 == 0 && index != 0)
                tableData += '</tr><tr><td class="product-img sound-btn" title="'+data['name'][index]+'" data-product = "'+product_info+'"><img  src="public/images/product/'+data['image'][index]+'" width="100%" /><p>'+data['name'][index]+'</p><span>'+data['code'][index]+'</span></td>';
            else
                tableData += '<td class="product-img sound-btn" title="'+data['name'][index]+'" data-product = "'+product_info+'"><img  src="public/images/product/'+data['image'][index]+'" width="100%" /><p>'+data['name'][index]+'</p><span>'+data['code'][index]+'</span></td>';
        });

        if(data['name'].length % 5){
            var number = 5 - (data['name'].length % 5);
            while(number > 0)
            {
                tableData += '<td style="border:none;"></td>';
                number--;
            }
        }

        tableData += '</tr></tbody></table>';
        $(".table-container").html(tableData);
        $('#product-table').DataTable( {
          "order": [],
          'pageLength': product_row_number,
           'language': {
              'paginate': {
                  'previous': '<i class="fa fa-angle-left"></i>',
                  'next': '<i class="fa fa-angle-right"></i>'
              }
          },
          dom: 'tp'
        });
        $('table.product-list').hide();
        $('table.product-list').show(500);
    }
    else{
        tableData += '<td class="text-center">No data avaialable</td></tr></tbody></table>'
        $(".table-container").html(tableData);
    }
}


$('select[name="biller_id"]').on('change', function() {
    saveValue(this);
});

$('select[name="warehouse_id"]').on('change', function() {
    saveValue(this);
    warehouse_id = $(this).val();
    $.get('sales/getproduct', function(data) {
        lims_product_array = [];
        product_code = data[0];
        product_name = data[1];
        product_qty = data[2];
        product_type = data[3];
        product_id = data[4];
        product_list = data[5];
        qty_list = data[6];
        product_warehouse_price = data[7];
        batch_no = data[8];
        product_batch_id = data[9];
        is_embeded = data[11];
        $.each(product_code, function(index) {
            if(is_embeded[index])
                lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')|' + is_embeded[index]);
            else
                lims_product_array.push(product_code[index] + ' (' + product_name[index] + ')');
        });
    });

    isCashRegisterAvailable(warehouse_id);
});

var lims_productcodeSearch = $('#lims_productcodeSearch');

lims_productcodeSearch.autocomplete({
    source: function(request, response) {
        var matcher = new RegExp(".?" + $.ui.autocomplete.escapeRegex(request.term), "i");
        response($.grep(lims_product_array, function(item) {
            return matcher.test(item);
        }));
    },
    response: function(event, ui) {
        if (ui.content.length == 1) {
            var data = ui.content[0].value;
            $(this).autocomplete( "close" );
            productSearch(data);
        }
        else if(ui.content.length == 0 && $('#lims_productcodeSearch').val().length == 13) {
          productSearch($('#lims_productcodeSearch').val()+'|'+1);
        }
    },
    select: function(event, ui) {
        var data = ui.item.value;
        productSearch(data);
    },
});

$('#myTable').keyboard({
    accepted : function(event, keyboard, el) {
      checkQuantity(el.value, true);
  }
});

$("#myTable").on('click', '.plus', function() {
    rowindex = $(this).closest('tr').index();
    var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val();
    if(!qty)
      qty = 1;
    else
      qty = parseFloat(qty) + 1;
    if(is_variant[rowindex])
        checkQuantity(String(qty), true);
    else
        checkDiscount(qty, true);
});

$("#myTable").on('click', '.minus', function() {
    rowindex = $(this).closest('tr').index();
    var qty = parseFloat($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val()) - 1;
    if (qty > 0) {
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
    } else {
        qty = 1;
    }
    if(is_variant[rowindex])
        checkQuantity(String(qty), true);
    else
        checkDiscount(qty, true);
});

$("#myTable").on("change", ".batch-no", function () {
    rowindex = $(this).closest('tr').index();
    var product_id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-id').val();
    var warehouse_id = $('#warehouse_id').val();
    $.get('check-batch-availability/' + product_id + '/' + $(this).val() + '/' + warehouse_id, function(data) {
        if(data['message'] != 'ok') {
            alert(data['message']);
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.batch-no').val('');
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-batch-id').val('');
        }
        else {
            $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-batch-id').val(data['product_batch_id']);
            code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
            pos = product_code.indexOf(code);
            product_qty[pos] = data['qty'];
        }
    });
});

//Change quantity
$("#myTable").on('input', '.qty', function() {
    rowindex = $(this).closest('tr').index();
    if($(this).val() < 0 && $(this).val() != '') {
      $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(1);
      alert("Quantity can't be less than 0");
    }
    if(is_variant[rowindex])
        checkQuantity($(this).val(), true);
    else
        checkDiscount($(this).val(), true);
});

$("#myTable").on('click', '.qty', function() {
    rowindex = $(this).closest('tr').index();
});

$(document).on('click', '.sound-btn', function() {
    var audio = $("#mysoundclip1")[0];
    audio.play();
});

$(document).on('click', '.product-img', function() {
    var customer_id = $('#customer_id').val();
    var warehouse_id = $('select[name="warehouse_id"]').val();
    if(!customer_id)
        alert('Please select Customer!');
    else if(!warehouse_id)
        alert('Please select Warehouse!');
    else{
        var data = $(this).data('product');
        product_info = data.split(" ");
        pos = product_code.indexOf(product_info[0]);
        if(pos < 0)
            alert('Product is not avaialable in the selected warehouse');
        else{
            productSearch(data);
        }
    }
});
//Delete product
$("table.order-list tbody").on("click", ".ibtnDel", function(event) {
    var audio = $("#mysoundclip2")[0];
    audio.play();
    rowindex = $(this).closest('tr').index();
    product_price.splice(rowindex, 1);
    product_discount.splice(rowindex, 1);
    tax_rate.splice(rowindex, 1);
    tax_name.splice(rowindex, 1);
    tax_method.splice(rowindex, 1);
    unit_name.splice(rowindex, 1);
    unit_operator.splice(rowindex, 1);
    unit_operation_value.splice(rowindex, 1);

    localStorageProductId.splice(rowindex, 1);
    localStorageQty.splice(rowindex, 1);
    localStorageSaleUnit.splice(rowindex, 1);
    localStorageProductDiscount.splice(rowindex, 1);
    localStorageTaxRate.splice(rowindex, 1);
    localStorageNetUnitPrice.splice(rowindex, 1);
    localStorageTaxValue.splice(rowindex, 1);
    localStorageSubTotalUnit.splice(rowindex, 1);
    localStorageSubTotal.splice(rowindex, 1);
    localStorageProductCode.splice(rowindex, 1);

    localStorageTaxName.splice(rowindex, 1);
    localStorageTaxMethod.splice(rowindex, 1);
    localStorageTempUnitName.splice(rowindex, 1);
    localStorageSaleUnitOperator.splice(rowindex, 1);
    localStorageSaleUnitOperationValue.splice(rowindex, 1);

    localStorage.setItem("localStorageProductId", localStorageProductId);
    localStorage.setItem("localStorageQty", localStorageQty);
    localStorage.setItem("localStorageSaleUnit", localStorageSaleUnit);
    localStorage.setItem("localStorageProductCode", localStorageProductCode);
    localStorage.setItem("localStorageProductDiscount", localStorageProductDiscount);
    localStorage.setItem("localStorageTaxRate", localStorageTaxRate);
    localStorage.setItem("localStorageTaxName", localStorageTaxName);
    localStorage.setItem("localStorageTaxMethod", localStorageTaxMethod);
    localStorage.setItem("localStorageTempUnitName", localStorageTempUnitName);
    localStorage.setItem("localStorageSaleUnitOperator", localStorageSaleUnitOperator);
    localStorage.setItem("localStorageSaleUnitOperationValue", localStorageSaleUnitOperationValue);
    localStorage.setItem("localStorageNetUnitPrice", localStorageNetUnitPrice);
    localStorage.setItem("localStorageTaxValue", localStorageTaxValue);
    localStorage.setItem("localStorageSubTotalUnit", localStorageSubTotalUnit);
    localStorage.setItem("localStorageSubTotal", localStorageSubTotal);

    $(this).closest("tr").remove();
    localStorage.setItem("tbody-id", $("table.order-list tbody").html());
    calculateTotal();
});

//Edit product
$("table.order-list").on("click", ".edit-product", function() {
    rowindex = $(this).closest('tr').index();
    edit();
});

//Update product
$('button[name="update_btn"]').on("click", function() {
    if(is_imei[rowindex]) {
        var imeiNumbers = $("#editModal input[name=imei_numbers]").val();
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.imei-number').val(imeiNumbers);
    }

    var edit_discount = $('input[name="edit_discount"]').val();
    var edit_qty = $('input[name="edit_qty"]').val();
    var edit_unit_price = $('input[name="edit_unit_price"]').val();

    if (parseFloat(edit_discount) > parseFloat(edit_unit_price)) {
        alert('Invalid Discount Input!');
        return;
    }

    if(edit_qty < 1) {
        $('input[name="edit_qty"]').val(1);
        edit_qty = 1;
        alert("Quantity can't be less than 1");
    }

    var tax_rate_all = <?php echo json_encode($tax_rate_all) ?>;

    tax_rate[rowindex] = localStorageTaxRate[rowindex] = parseFloat(tax_rate_all[$('select[name="edit_tax_rate"]').val()]);
    tax_name[rowindex] = localStorageTaxName[rowindex] = $('select[name="edit_tax_rate"] option:selected').text();

    product_discount[rowindex] = $('input[name="edit_discount"]').val();
    if(product_type[pos] == 'standard'){
        var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
        var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));
        if (row_unit_operator == '*') {
            product_price[rowindex] = $('input[name="edit_unit_price"]').val() / row_unit_operation_value;
        } else {
            product_price[rowindex] = $('input[name="edit_unit_price"]').val() * row_unit_operation_value;
        }
        var position = $('select[name="edit_unit"]').val();
        var temp_operator = temp_unit_operator[position];
        var temp_operation_value = temp_unit_operation_value[position];
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sale-unit').val(temp_unit_name[position]);
        temp_unit_name.splice(position, 1);
        temp_unit_operator.splice(position, 1);
        temp_unit_operation_value.splice(position, 1);

        temp_unit_name.unshift($('select[name="edit_unit"] option:selected').text());
        temp_unit_operator.unshift(temp_operator);
        temp_unit_operation_value.unshift(temp_operation_value);

        unit_name[rowindex] = localStorageTempUnitName[rowindex] = temp_unit_name.toString() + ',';
        unit_operator[rowindex] = localStorageSaleUnitOperator[rowindex] = temp_unit_operator.toString() + ',';
        unit_operation_value[rowindex] = localStorageSaleUnitOperationValue[rowindex] = temp_unit_operation_value.toString() + ',';

        localStorage.setItem("localStorageTaxRate", localStorageTaxRate);
        localStorage.setItem("localStorageTaxName", localStorageTaxName);
        localStorage.setItem("localStorageTempUnitName", localStorageTempUnitName);
        localStorage.setItem("localStorageSaleUnitOperator", localStorageSaleUnitOperator);
        localStorage.setItem("localStorageSaleUnitOperationValue", localStorageSaleUnitOperationValue);
    }
    else {
        product_price[rowindex] = $('input[name="edit_unit_price"]').val();
    }
    checkDiscount(edit_qty, false);
});

$('button[name="order_discount_btn"]').on("click", function() {
    calculateGrandTotal();
});

$('button[name="shipping_cost_btn"]').on("click", function() {
    calculateGrandTotal();
});

$('button[name="order_tax_btn"]').on("click", function() {
    calculateGrandTotal();
});

$(".coupon-check").on("click",function() {
    couponDiscount();
});

$(".payment-btn").on("click", function() {
    var audio = $("#mysoundclip2")[0];
    audio.play();
    $('input[name="paid_amount"]').val($("#grand-total").text());
    $('input[name="paying_amount"]').val($("#grand-total").text());
    $('.qc').data('initial', 1);
});

$("#draft-btn").on("click",function(){
    var audio = $("#mysoundclip2")[0];
    audio.play();
    $('input[name="sale_status"]').val(3);
    $('input[name="paying_amount"]').prop('required',false);
    $('input[name="paid_amount"]').prop('required',false);
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
    }
    else
        $('.payment-form').submit();
});

$("#submit-btn").on("click", function() {
    $('.payment-form').submit();
});

$("#gift-card-btn").on("click",function() {
    $('select[name="paid_by_id_select"]').val(2);
    $('.selectpicker').selectpicker('refresh');
    $('div.qc').hide();
    giftCard();
});

$("#credit-card-btn").on("click",function() {
    $('select[name="paid_by_id_select"]').val(3);
    $('.selectpicker').selectpicker('refresh');
    $('div.qc').hide();
    creditCard();
});

$("#cheque-btn").on("click",function() {
    $('select[name="paid_by_id_select"]').val(4);
    $('.selectpicker').selectpicker('refresh');
    $('div.qc').hide();
    cheque();
});

$("#cash-btn").on("click",function() {
    $('select[name="paid_by_id_select"]').val(1);
    $('.selectpicker').selectpicker('refresh');
    $('div.qc').show();
    hide();
});

$("#paypal-btn").on("click",function() {
    $('select[name="paid_by_id_select"]').val(5);
    $('.selectpicker').selectpicker('refresh');
    $('div.qc').hide();
    hide();
});

$("#deposit-btn").on("click",function() {
    $('select[name="paid_by_id_select"]').val(6);
    $('.selectpicker').selectpicker('refresh');
    $('div.qc').hide();
    hide();
    deposits();
});

$("#point-btn").on("click",function() {
    $('select[name="paid_by_id_select"]').val(7);
    $('.selectpicker').selectpicker('refresh');
    $('div.qc').hide();
    hide();
    pointCalculation();
});

$('select[name="paid_by_id_select"]').on("change", function() {
    var id = $(this).val();
    $(".payment-form").off("submit");
    if(id == 2) {
        $('div.qc').hide();
        giftCard();
    }
    else if (id == 3) {
        $('div.qc').hide();
        creditCard();
    } else if (id == 4) {
        $('div.qc').hide();
        cheque();
    } else {
        hide();
        if(id == 1)
            $('div.qc').show();
        else if(id == 6) {
            $('div.qc').hide();
            deposits();
        }
        else if(id == 7) {
            $('div.qc').hide();
            pointCalculation();
        }
    }
});

$('#add-payment select[name="gift_card_id_select"]').on("change", function() {
    var balance = gift_card_amount[$(this).val()] - gift_card_expense[$(this).val()];
    $('#add-payment input[name="gift_card_id"]').val($(this).val());
    if($('input[name="paid_amount"]').val() > balance){
        alert('Amount exceeds card balance! Gift Card balance: '+ balance);
    }
});

$('#add-payment input[name="paying_amount"]').on("input", function() {
    change($(this).val(), $('input[name="paid_amount"]').val());
});

$('input[name="paid_amount"]').on("input", function() {
    if( $(this).val() > parseFloat($('input[name="paying_amount"]').val()) ) {
        alert('Paying amount cannot be bigger than recieved amount');
        $(this).val('');
    }
    else if( $(this).val() > parseFloat($('#grand-total').text()) ){
        alert('Paying amount cannot be bigger than grand total');
        $(this).val('');
    }

    change( $('input[name="paying_amount"]').val(), $(this).val() );
    var id = $('select[name="paid_by_id_select"]').val();
    if(id == 2){
        var balance = gift_card_amount[$("#gift_card_id_select").val()] - gift_card_expense[$("#gift_card_id_select").val()];
        if($(this).val() > balance)
            alert('Amount exceeds card balance! Gift Card balance: '+ balance);
    }
    else if(id == 6){
        if( $('input[name="paid_amount"]').val() > deposit[$('#customer_id').val()] )
            alert('Amount exceeds customer deposit! Customer deposit : '+ deposit[$('#customer_id').val()]);
    }
});

$('.transaction-btn-plus').on("click", function() {
    $(this).addClass('d-none');
    $('.transaction-btn-close').removeClass('d-none');
});

$('.transaction-btn-close').on("click", function() {
    $(this).addClass('d-none');
    $('.transaction-btn-plus').removeClass('d-none');
});

$('.coupon-btn-plus').on("click", function() {
    $(this).addClass('d-none');
    $('.coupon-btn-close').removeClass('d-none');
});

$('.coupon-btn-close').on("click", function() {
    $(this).addClass('d-none');
    $('.coupon-btn-plus').removeClass('d-none');
});

$(document).on('click', '.qc-btn', function(e) {
    if($(this).data('amount')) {
        if($('.qc').data('initial')) {
            $('input[name="paying_amount"]').val( $(this).data('amount').toFixed(2) );
            $('.qc').data('initial', 0);
        }
        else {
            $('input[name="paying_amount"]').val( (parseFloat($('input[name="paying_amount"]').val()) + $(this).data('amount')).toFixed(2) );
        }
    }
    else
        $('input[name="paying_amount"]').val('0.00');
    change( $('input[name="paying_amount"]').val(), $('input[name="paid_amount"]').val() );
});

function change(paying_amount, paid_amount) {
    $("#change").text( parseFloat(paying_amount - paid_amount).toFixed(2) );
}

function confirmDelete() {
    if (confirm("Are you sure want to delete?")) {
        return true;
    }
    return false;
}

function productSearch(data) {
    var product_info = data.split(" ");
    var product_code = product_info[0];
    var pre_qty = 0;
    $(".product-code").each(function(i) {
        if ($(this).val() == product_code) {
            rowindex = i;
            pre_qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val();
        }
    });
    data += '?'+$('#customer_id').val()+'?'+(parseFloat(pre_qty) + 1);
    $.ajax({
        type: 'GET',
        url: 'sales/lims_product_search',
        data: {
            data: data
        },
        success: function(data) {
            console.log(pre_qty);
            var flag = 1;
            if (pre_qty > 0) {
                /*if(pre_qty)
                    var qty = parseFloat(pre_qty) + data[15];
                else*/
                    var qty = data[15];
                $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
                pos = product_code.indexOf(data[1]);
                if(!data[11] && product_warehouse_price[pos]) {
                    //product_price[rowindex] = parseFloat(product_warehouse_price[pos] * currency['exchange_rate']) + parseFloat(product_warehouse_price[pos] * currency['exchange_rate'] * customer_group_rate);
                    product_price[rowindex] = 90;
                }
                else{
                    //product_price[rowindex] = parseFloat(data[2] * currency['exchange_rate']) + parseFloat(data[2] * currency['exchange_rate'] * customer_group_rate);
                    product_price[rowindex] = 90;
                }
                flag = 0;
                checkQuantity(String(qty), true);
                flag = 0;
                localStorage.setItem("tbody-id", $("table.order-list tbody").html());
            }
            $("input[name='product_code_name']").val('');
            if(flag){
                addNewProduct(data);
            }
        }
    });
}

function addNewProduct(data){
    var newRow = $("<tr>");
    var cols = '';
    temp_unit_name = (data[6]).split(',');
    pos = product_code.indexOf(data[1]);
    cols += '<td class="col-sm-2 product-title"><button type="button" class="edit-product btn btn-link" data-toggle="modal" data-target="#editModal"><strong><span class="product-name">' + data[0] + '</span></strong></button><br>' + data[1] + '<p>In Stock: <span class="in-stock"></span></p></td>';
    if(data[12]) {
        cols += '<td class="col-sm-2"><input type="text" class="form-control batch-no" value="'+batch_no[pos]+'" required/> <input type="hidden" class="product-batch-id" name="product_batch_id[]" value="'+product_batch_id[pos]+'"/> </td>';
    }
    else {
        cols += '<td class="col-sm-2"><input type="text" class="form-control batch-no" disabled/> <input type="hidden" class="product-batch-id" name="product_batch_id[]"/> </td>';
    }
    cols += '<td class="col-sm-2 product-price"></td>';
    cols += '<td class="col-sm-3"><div class="input-group"><span class="input-group-btn"><button type="button" class="btn btn-default minus"><span class="dripicons-minus"></span></button></span><input type="text" name="qty[]" class="form-control qty numkey input-number" step="any" value="'+data[15]+'" required><span class="input-group-btn"><button type="button" class="btn btn-default plus"><span class="dripicons-plus"></span></button></span></div></td>';
    cols += '<td class="col-sm-2 sub-total"></td>';
    cols += '<td class="col-sm-1"><button type="button" class="ibtnDel btn btn-danger btn-sm"><i class="dripicons-cross"></i></button></td>';
    cols += '<input type="hidden" class="product-code" name="product_code[]" value="' + data[1] + '"/>';
    cols += '<input type="hidden" class="product-id" name="product_id[]" value="' + data[9] + '"/>';
    cols += '<input type="hidden" class="product_price" />';
    cols += '<input type="hidden" class="sale-unit" name="sale_unit[]" value="' + temp_unit_name[0] + '"/>';
    cols += '<input type="hidden" class="net_unit_price" name="net_unit_price[]" />';
    cols += '<input type="hidden" class="discount-value" name="discount[]" />';
    cols += '<input type="hidden" class="tax-rate" name="tax_rate[]" value="' + data[3] + '"/>';
    cols += '<input type="hidden" class="tax-value" name="tax[]" />';
    cols += '<input type="hidden" class="tax-name" value="'+data[4]+'" />';
    cols += '<input type="hidden" class="tax-method" value="'+data[5]+'" />';
    cols += '<input type="hidden" class="sale-unit-operator" value="'+data[7]+'" />';
    cols += '<input type="hidden" class="sale-unit-operation-value" value="'+data[8]+'" />';
    cols += '<input type="hidden" class="subtotal-value" name="subtotal[]" />';
    cols += '<input type="hidden" class="imei-number" name="imei_number[]" />';

    newRow.append(cols);
    if(keyboard_active==1) {
        $("table.order-list tbody").prepend(newRow).find('.qty').keyboard({usePreview: false, layout: 'custom', display: { 'accept'  : '&#10004;', 'cancel'  : '&#10006;' }, customLayout : {
          'normal' : ['1 2 3', '4 5 6', '7 8 9','0 {dec} {bksp}','{clear} {cancel} {accept}']}, restrictInput : true, preventPaste : true, autoAccept : true, css: { container: 'center-block dropdown-menu', buttonDefault: 'btn btn-default', buttonHover: 'btn-primary',buttonAction: 'active', buttonDisabled: 'disabled'},});
    }
    else
        $("table.order-list tbody").prepend(newRow);

    rowindex = newRow.index();

    if(!data[11] && product_warehouse_price[pos]) {
        product_price.splice(rowindex, 0, parseFloat(product_warehouse_price[pos] * currency['exchange_rate']) + parseFloat(product_warehouse_price[pos] * currency['exchange_rate'] * customer_group_rate));
    }
    else {
        product_price.splice(rowindex, 0, parseFloat(data[2]));
    }
    product_discount.splice(rowindex, 0, '0.00');
    tax_rate.splice(rowindex, 0, parseFloat(data[3]));
    tax_name.splice(rowindex, 0, data[4]);
    tax_method.splice(rowindex, 0, data[5]);
    unit_name.splice(rowindex, 0, data[6]);
    unit_operator.splice(rowindex, 0, data[7]);
    unit_operation_value.splice(rowindex, 0, data[8]);
    is_imei.splice(rowindex, 0, data[13]);
    is_variant.splice(rowindex, 0, data[14]);
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product_price').val(product_price[rowindex]);
    localStorageQty.splice(rowindex, 0, data[15]);
    localStorageProductId.splice(rowindex, 0, data[9]);
    localStorageProductCode.splice(rowindex, 0, data[1]);
    localStorageSaleUnit.splice(rowindex, 0, temp_unit_name[0]);
    localStorageProductDiscount.splice(rowindex, 0, product_discount[rowindex]);
    localStorageTaxRate.splice(rowindex, 0, tax_rate[rowindex].toFixed(2));
    localStorageTaxName.splice(rowindex, 0, data[4]);
    localStorageTaxMethod.splice(rowindex, 0, data[5]);
    localStorageTempUnitName.splice(rowindex, 0, data[6]);
    localStorageSaleUnitOperator.splice(rowindex, 0, data[7]);
    localStorageSaleUnitOperationValue.splice(rowindex, 0, data[8]);
    //put some dummy value
    localStorageNetUnitPrice.splice(rowindex, 0, '0.00');
    localStorageTaxValue.splice(rowindex, 0, '0.00');
    localStorageSubTotalUnit.splice(rowindex, 0, '0.00');
    localStorageSubTotal.splice(rowindex, 0, '0.00');

    localStorage.setItem("localStorageProductId", localStorageProductId);
    localStorage.setItem("localStorageSaleUnit", localStorageSaleUnit);
    localStorage.setItem("localStorageProductCode", localStorageProductCode);
    localStorage.setItem("localStorageTaxName", localStorageTaxName);
    localStorage.setItem("localStorageTaxMethod", localStorageTaxMethod);
    localStorage.setItem("localStorageTempUnitName", localStorageTempUnitName);
    localStorage.setItem("localStorageSaleUnitOperator", localStorageSaleUnitOperator);
    localStorage.setItem("localStorageSaleUnitOperationValue", localStorageSaleUnitOperationValue);
    checkQuantity(data[15], true);
    localStorage.setItem("tbody-id", $("table.order-list tbody").html());
    if(data[13]) {
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.edit-product').click();
    }
}

function edit(){
    $(".imei-section").remove();
    if(is_imei[rowindex]) {
        var imeiNumbers = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.imei-number').val();

        htmlText = '<div class="col-md-12 form-group imei-section"><label>IMEI or Serial Numbers</label><input type="text" name="imei_numbers" value="'+imeiNumbers+'" class="form-control imei_number" placeholder="Type imei or serial numbers and separate them by comma. Example:1001,2001" step="any"></div>';
        $("#editModal .modal-element").append(htmlText);
    }

    var row_product_name_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-name').text();
    $('#modal_header').text(row_product_name_code);

    var qty = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val();
    $('input[name="edit_qty"]').val(qty);

    $('input[name="edit_discount"]').val(parseFloat(product_discount[rowindex]).toFixed(2));

    var tax_name_all = <?php echo json_encode($tax_name_all) ?>;
    pos = tax_name_all.indexOf(tax_name[rowindex]);
    $('select[name="edit_tax_rate"]').val(pos);

    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
    pos = product_code.indexOf(row_product_code);
    if(product_type[pos] == 'standard'){
        unitConversion();
        temp_unit_name = (unit_name[rowindex]).split(',');
        temp_unit_name.pop();
        temp_unit_operator = (unit_operator[rowindex]).split(',');
        temp_unit_operator.pop();
        temp_unit_operation_value = (unit_operation_value[rowindex]).split(',');
        temp_unit_operation_value.pop();
        $('select[name="edit_unit"]').empty();
        $.each(temp_unit_name, function(key, value) {
            $('select[name="edit_unit"]').append('<option value="' + key + '">' + value + '</option>');
        });
        $("#edit_unit").show();
    }
    else{
        row_product_price = product_price[rowindex];
        $("#edit_unit").hide();
    }
    $('input[name="edit_unit_price"]').val(row_product_price.toFixed(2));
    $('.selectpicker').selectpicker('refresh');
}

function couponDiscount() {
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
    }
    else if($("#coupon-code").val() != ''){
        valid = 0;
        $.each(coupon_list, function(key, value) {
            if($("#coupon-code").val() == value['code']){
                valid = 1;
                todyDate = <?php echo json_encode(date('Y-m-d'))?>;
                if(parseFloat(value['quantity']) <= parseFloat(value['used']))
                    alert('This Coupon is no longer available');
                else if(todyDate > value['expired_date'])
                    alert('This Coupon has expired!');
                else if(value['type'] == 'fixed'){
                    if(parseFloat($('input[name="grand_total"]').val()) >= value['minimum_amount']) {
                        $('input[name="grand_total"]').val($('input[name="grand_total"]').val() - value['amount']);
                        $('#grand-total').text(parseFloat($('input[name="grand_total"]').val()).toFixed(2));
                        if(!$('input[name="coupon_active"]').val())
                            alert('Congratulation! You got '+value['amount']+' '+currency+' discount');
                        $(".coupon-check").prop("disabled",true);
                        $("#coupon-code").prop("disabled",true);
                        $('input[name="coupon_active"]').val(1);
                        $("#coupon-modal").modal('hide');
                        $('input[name="coupon_id"]').val(value['id']);
                        $('input[name="coupon_discount"]').val(value['amount']);
                        $('#coupon-text').text(parseFloat(value['amount']).toFixed(2));
                    }
                    else
                        alert('Grand Total is not sufficient for discount! Required '+value['minimum_amount']+' '+currency);
                }
                else{
                    var grand_total = $('input[name="grand_total"]').val();
                    var coupon_discount = grand_total * (value['amount'] / 100);
                    grand_total = grand_total - coupon_discount;
                    $('input[name="grand_total"]').val(grand_total);
                    $('#grand-total').text(parseFloat(grand_total).toFixed(2));
                    if(!$('input[name="coupon_active"]').val())
                            alert('Congratulation! You got '+value['amount']+'% discount');
                    $(".coupon-check").prop("disabled",true);
                    $("#coupon-code").prop("disabled",true);
                    $('input[name="coupon_active"]').val(1);
                    $("#coupon-modal").modal('hide');
                    $('input[name="coupon_id"]').val(value['id']);
                    $('input[name="coupon_discount"]').val(coupon_discount);
                    $('#coupon-text').text(parseFloat(coupon_discount).toFixed(2));
                }
            }
        });
        if(!valid)
            alert('Invalid coupon code!');
    }
}

function checkDiscount(qty, flag) {
    var customer_id = $('#customer_id').val();
    var product_id = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .product-id').val();
    if(flag) {
        $.ajax({
            type: 'GET',
            async: false,
            url: 'sales/check-discount?qty='+qty+'&customer_id='+customer_id+'&product_id='+product_id,
            success: function(data) {
                //console.log(data);
                pos = product_code.indexOf($('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .product-code').val());
                product_price[rowindex] = parseFloat(data[0] * currency['exchange_rate']) + parseFloat(data[0] * currency['exchange_rate'] * customer_group_rate);
            }
        });
    }
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ') .qty').val(qty);
    checkQuantity(String(qty), flag);
    localStorage.setItem("tbody-id", $("table.order-list tbody").html());
}

function checkQuantity(sale_qty, flag) {
    var row_product_code = $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-code').val();
    pos = product_code.indexOf(row_product_code);
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.in-stock').text(product_qty[pos]);
    localStorageQty[rowindex] = sale_qty;
    localStorage.setItem("localStorageQty", localStorageQty);
    if(product_type[pos] == 'standard') {
        var operator = unit_operator[rowindex].split(',');
        var operation_value = unit_operation_value[rowindex].split(',');
        if(operator[0] == '*')
            total_qty = sale_qty * operation_value[0];
        else if(operator[0] == '/')
            total_qty = sale_qty / operation_value[0];
        if (total_qty > parseFloat(product_qty[pos])) {
            alert('Quantity exceeds stock quantity!');
            if (flag) {
                sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                localStorageQty[rowindex] = sale_qty;
                localStorage.setItem("localStorageQty", localStorageQty);
                checkQuantity(sale_qty, true);
            } 
            else {
                localStorageQty[rowindex] = sale_qty;
                localStorage.setItem("localStorageQty", localStorageQty);
                edit();
                return;
            }
        }
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
    }
    else if(product_type[pos] == 'combo'){
        child_id = product_list[pos].split(',');
        child_qty = qty_list[pos].split(',');
        $(child_id).each(function(index) {
            var position = product_id.indexOf(parseInt(child_id[index]));
            if( parseFloat(sale_qty * child_qty[index]) > product_qty[position] ) {
                alert('Quantity exceeds stock quantity!');
                if (flag) {
                    sale_qty = sale_qty.substring(0, sale_qty.length - 1);
                    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
                }
                else {
                    edit();
                    flag = true;
                    return false;
                }
            }
        });
    }

    if(!flag){
        $('#editModal').modal('hide');
        $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.qty').val(sale_qty);
    }
    calculateRowProductData(sale_qty);
}

function unitConversion() {
    var row_unit_operator = unit_operator[rowindex].slice(0, unit_operator[rowindex].indexOf(","));
    var row_unit_operation_value = unit_operation_value[rowindex].slice(0, unit_operation_value[rowindex].indexOf(","));

    if (row_unit_operator == '*') {
        row_product_price = product_price[rowindex] * row_unit_operation_value;
    } else {
        row_product_price = product_price[rowindex] / row_unit_operation_value;
    }
}

function calculateRowProductData(quantity) {
    if(product_type[pos] == 'standard')
        unitConversion();
    else
        row_product_price = product_price[rowindex];
    if (tax_method[rowindex] == 1) {
        var net_unit_price = row_product_price - product_discount[rowindex];
        var tax = net_unit_price * quantity * (tax_rate[rowindex] / 100);
        var sub_total = (net_unit_price * quantity) + tax;

        if(parseFloat(quantity))
            var sub_total_unit = sub_total / quantity;
        else
            var sub_total_unit = sub_total;
    }
    else {
        var sub_total_unit = row_product_price - product_discount[rowindex];
        var net_unit_price = (100 / (100 + tax_rate[rowindex])) * sub_total_unit;
        var tax = (sub_total_unit - net_unit_price) * quantity;
        var sub_total = sub_total_unit * quantity;
    }

    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.discount-value').val((product_discount[rowindex] * quantity).toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-rate').val(tax_rate[rowindex].toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.net_unit_price').val(net_unit_price.toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.tax-value').val(tax.toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.product-price').text(sub_total_unit.toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.sub-total').text(sub_total.toFixed(2));
    $('table.order-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.subtotal-value').val(sub_total.toFixed(2));

    localStorageProductDiscount.splice(rowindex, 1, (product_discount[rowindex] * quantity).toFixed(2));
    localStorageTaxRate.splice(rowindex, 1, tax_rate[rowindex].toFixed(2));
    localStorageNetUnitPrice.splice(rowindex, 1, net_unit_price.toFixed(2));
    localStorageTaxValue.splice(rowindex, 1, tax.toFixed(2));
    localStorageSubTotalUnit.splice(rowindex, 1, sub_total_unit.toFixed(2));
    localStorageSubTotal.splice(rowindex, 1, sub_total.toFixed(2));
    localStorage.setItem("localStorageProductDiscount", localStorageProductDiscount);
    localStorage.setItem("localStorageTaxRate", localStorageTaxRate);
    localStorage.setItem("localStorageNetUnitPrice", localStorageNetUnitPrice);
    localStorage.setItem("localStorageTaxValue", localStorageTaxValue);
    localStorage.setItem("localStorageSubTotalUnit", localStorageSubTotalUnit);
    localStorage.setItem("localStorageSubTotal", localStorageSubTotal);

    calculateTotal();
}

function calculateTotal() {
    //Sum of quantity
    var total_qty = 0;
    $("table.order-list tbody .qty").each(function(index) {
        if ($(this).val() == '') {
            total_qty += 0;
        } else {
            total_qty += parseFloat($(this).val());
        }
    });
    $('input[name="total_qty"]').val(total_qty);

    //Sum of discount
    var total_discount = 0;
    $("table.order-list tbody .discount-value").each(function() {
        total_discount += parseFloat($(this).val());
    });

    $('input[name="total_discount"]').val(total_discount.toFixed(2));

    //Sum of tax
    var total_tax = 0;
    $(".tax-value").each(function() {
        total_tax += parseFloat($(this).val());
    });

    $('input[name="total_tax"]').val(total_tax.toFixed(2));

    //Sum of subtotal
    var total = 0;
    $(".sub-total").each(function() {
        total += parseFloat($(this).text());
    });
    $('input[name="total_price"]').val(total.toFixed(2));

    calculateGrandTotal();
}

function calculateGrandTotal() {
    var item = $('table.order-list tbody tr:last').index();
    var total_qty = parseFloat($('input[name="total_qty"]').val());
    var subtotal = parseFloat($('input[name="total_price"]').val());
    var order_tax = parseFloat($('select[name="order_tax_rate_select"]').val());
    var order_discount_type = $('select[name="order_discount_type_select"]').val();
    var order_discount_value = parseFloat($('input[name="order_discount_value"]').val());

    if (!order_discount_value)
        order_discount_value = 0.00;

    if(order_discount_type == 'Flat')
        var order_discount = parseFloat(order_discount_value);
    else
        var order_discount = parseFloat(subtotal * (order_discount_value / 100));

    localStorage.setItem("order-tax-rate-select", order_tax);
    localStorage.setItem("order-discount-type", order_discount_type);
    $("#discount").text(order_discount.toFixed(2));
    $('input[name="order_discount"]').val(order_discount);
    $('input[name="order_discount_type"]').val(order_discount_type);

    var shipping_cost = parseFloat($('input[name="shipping_cost"]').val());
    if (!shipping_cost)
        shipping_cost = 0.00;

    item = ++item + '(' + total_qty + ')';
    //order_tax = (subtotal - order_discount) * (order_tax / 100);
    order_tax = 0;
    var grand_total = (subtotal + order_tax + shipping_cost) - order_discount;
    $('input[name="grand_total"]').val(grand_total.toFixed(2));

    //couponDiscount();
    var coupon_discount = parseFloat($('input[name="coupon_discount"]').val());
    if (!coupon_discount)
        coupon_discount = 0.00;
    grand_total -= coupon_discount;

    $('#item').text(item);
    $('input[name="item"]').val($('table.order-list tbody tr:last').index() + 1);
    $('#subtotal').text(subtotal.toFixed(2));
    $('#tax').text(order_tax.toFixed(2));
    $('input[name="order_tax"]').val(order_tax.toFixed(2));
    $('#shipping-cost').text(shipping_cost.toFixed(2));
    $('#grand-total').text(grand_total.toFixed(2));
    $('input[name="grand_total"]').val(grand_total.toFixed(2));
}

function hide() {
    $(".card-element").hide();
    $(".card-errors").hide();
    $(".cheque").hide();
    $(".gift-card").hide();
    $('input[name="cheque_no"]').attr('required', false);
}

function giftCard() {
    $(".gift-card").show();
    $.ajax({
        url: 'sales/get_gift_card',
        type: "GET",
        dataType: "json",
        success:function(data) {
            $('#add-payment select[name="gift_card_id_select"]').empty();
            $.each(data, function(index) {
                gift_card_amount[data[index]['id']] = data[index]['amount'];
                gift_card_expense[data[index]['id']] = data[index]['expense'];
                $('#add-payment select[name="gift_card_id_select"]').append('<option value="'+ data[index]['id'] +'">'+ data[index]['card_no'] +'</option>');
            });
            $('.selectpicker').selectpicker('refresh');
            $('.selectpicker').selectpicker();
        }
    });
    $(".card-element").hide();
    $(".card-errors").hide();
    $(".cheque").hide();
    $('input[name="cheque_no"]').attr('required', false);
}

function cheque() {
    $(".cheque").show();
    $('input[name="cheque_no"]').attr('required', true);
    $(".card-element").hide();
    $(".card-errors").hide();
    $(".gift-card").hide();
}

function creditCard() {
    $.getScript( "public/vendor/stripe/checkout.js" );
    $(".card-element").show();
    $(".card-errors").show();
    $(".cheque").hide();
    $(".gift-card").hide();
    $('input[name="cheque_no"]').attr('required', false);
}

function deposits() {
    if($('input[name="paid_amount"]').val() > deposit[$('#customer_id').val()]){
        alert('Amount exceeds customer deposit! Customer deposit : '+ deposit[$('#customer_id').val()]);
    }
    $('input[name="cheque_no"]').attr('required', false);
    $('#add-payment select[name="gift_card_id_select"]').attr('required', false);
}

function pointCalculation() {
    paid_amount = $('input[name=paid_amount]').val();
    required_point = Math.ceil(paid_amount / reward_point_setting['per_point_amount']);
    if(required_point > points[$('#customer_id').val()]) {
      alert('Customer does not have sufficient points. Available points: '+points[$('#customer_id').val()]);
    }
    else {
      $("input[name=used_points]").val(required_point);
    }
}

function cancel(rownumber) {
    while(rownumber >= 0) {
        product_price.pop();
        product_discount.pop();
        tax_rate.pop();
        tax_name.pop();
        tax_method.pop();
        unit_name.pop();
        unit_operator.pop();
        unit_operation_value.pop();
        $('table.order-list tbody tr:last').remove();
        rownumber--;
    }
    $('input[name="shipping_cost"]').val('');
    $('input[name="order_discount"]').val('');
    $('select[name="order_tax_rate_select"]').val(0);
    calculateTotal();
}

function confirmCancel() {
    var audio = $("#mysoundclip2")[0];
    audio.play();
    if (confirm("Are you sure want to cancel?")) {
        cancel($('table.order-list tbody tr:last').index());
    }
    return false;
}

$(document).on('submit', '.payment-form', function(e) {
    var rownumber = $('table.order-list tbody tr:last').index();
    if (rownumber < 0) {
        alert("Please insert product to order table!")
        e.preventDefault();
    }
    else if( parseFloat( $('input[name="paying_amount"]').val() ) < parseFloat( $('input[name="paid_amount"]').val() ) ){
        alert('Paying amount cannot be bigger than recieved amount');
        e.preventDefault();
    }
    else {
        $("#submit-button").prop('disabled', true);
    }
    $('input[name="paid_by_id"]').val($('select[name="paid_by_id_select"]').val());
    $('input[name="order_tax_rate"]').val($('select[name="order_tax_rate_select"]').val());

});

$('#product-table').DataTable( {
    "order": [],
    'pageLength': product_row_number,
     'language': {
        'paginate': {
            'previous': '<i class="fa fa-angle-left"></i>',
            'next': '<i class="fa fa-angle-right"></i>'
        }
    },
    dom: 'tp'
});
</script>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@endsection

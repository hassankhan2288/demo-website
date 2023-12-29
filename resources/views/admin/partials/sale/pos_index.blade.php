@extends('layouts.admin')
@section('content')
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
        </div>
    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif

    <section>
        <div class="mb-4">
            <div class="card">
                <div class="card-header mt-2">
                    {{--                    <h3 class="text-center">{{trans('file.Sale List')}}</h3> --}}
                    <h3 class="text-center">POS Sale List</h3>
                </div>
                {!! Form::open(['route' => 'admin.pos.sale.list', 'method' => 'get']) !!}
                <div class="row ml-1 mt-2">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Date') }}</strong></label>
                            <input type="text" class="daterangepicker-field form-control"
                                value="{{ $starting_date }} To {{ $ending_date }}" required />
                            <input type="hidden" name="starting_date" value="{{ $starting_date }}" />
                            <input type="hidden" name="ending_date" value="{{ $ending_date }}" />
                        </div>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Company</label>
                        <select class="form-control company" name="company-id" id="company-id">
                            <option value="">ALL</option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>{{ trans('file.Sale Status') }}</strong></label>
                            <select id="sale-status" class="form-control" name="sale_status">
                                <option value="0">{{ trans('file.All') }}</option>
                                <option value="1">{{ trans('file.Completed') }}</option>
                                <option value="2">{{ trans('file.Pending') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- <div class="col-md-3">
                        <div class="form-group">
                            <label><strong>{{trans('file.Payment Status')}}</strong></label>
                            <select id="payment-status" class="form-control" name="payment_status">
                                <option value="0">{{trans('file.All')}}</option>
                                <option value="1">{{trans('file.Pending')}}</option>
                                <option value="2">{{trans('file.Due')}}</option>
                                <option value="3">{{trans('file.Partial')}}</option>
                                <option value="4">{{trans('file.Paid')}}</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-2 mt-3">
                        <div class="form-group">
                            <button class="btn btn-primary" id="filter-btn"
                                type="submit">{{ trans('file.submit') }}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="sale-table" class="table sale-list" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="not-exported"></th>
                                <th>{{ trans('file.Date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>Dynamics Order ID</th>
                                {{-- <th>{{trans('file.Biller')}}</th>
                            <th>{{trans('file.customer')}}</th> --}}
                                <th>Company</th>
                                <th>Branch</th>
                                <th>{{ trans('file.Sale Status') }}</th>
                                {{-- <th>{{trans('file.Payment Status')}}</th>
                            <th>{{trans('file.Delivery Status')}}</th> --}}
                                <th>{{ trans('file.grand total') }}</th>
                                {{-- <th>{{trans('file.Returned Amount')}}</th>
                            <th>{{trans('file.Paid')}}</th>
                            <th>{{trans('file.Due')}}</th> --}}
                                <th>Tax</th>
                                <th>Status</th>
                                <th>Payment Status</th>
                                <th>Delivery Date</th>
                                {{-- <th>Pickup Time</th>
                            <th>Pickup Date</th> --}}
                                <th class="not-exported">{{ trans('file.action') }}</th>
                            </tr>
                        </thead>

                        <tfoot class="tfoot active">
                            <th></th>
                            <th>{{ trans('file.Total') }}</th>
                            <th></th>
                            {{-- <th></th>
                        <th></th> --}}
                            {{-- <th></th> --}}
                        <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            {{-- <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th> --}}
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div id="sale-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="container mt-3 pb-2 border-bottom">
                    <div class="row">
                        <div class="col-md-6 d-print-none">
                            <button id="print-btn" type="button" class="btn btn-default btn-sm"><i
                                    class="dripicons-print"></i> {{ trans('file.Print') }}</button>

                            {{ Form::open(['route' => 'pos.sale.sendmail', 'method' => 'post', 'class' => 'sendmail-form']) }}
                            <input type="hidden" name="sale_id">
                            <button class="btn btn-default btn-sm d-print-none"><i class="dripicons-mail"></i>
                                {{ trans('file.Email') }}</button>
                            {{ Form::close() }}
                        </div>
                        <div class="col-md-6 d-print-none">
                            <button type="button" id="close-btn" data-dismiss="modal" aria-label="Close"
                                class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                        </div>
                        <div class="col-md-12">
                            <h3 id="exampleModalLabel" class="modal-title text-center container-fluid">
                                {{ $general_setting->site_title ?? '' }}</h3>
                        </div>
                        <div class="col-md-12 text-center">
                            <i style="font-size: 15px;">{{ trans('file.Sale Details') }}</i>
                        </div>
                    </div>
                </div>
                <div id="sale-content" class="modal-body">
                </div>
                <br>
                <table class="table table-bordered product-sale-list">
                    <thead>
                        <th>#</th>
                        <th>{{ trans('file.product') }}</th>
                        <th>{{ trans('file.Batch No') }}</th>
                        <th>{{ trans('file.Qty') }}</th>
                        <th>{{ trans('file.Unit') }}</th>
                        <th>{{ trans('file.Unit Price') }}</th>
                        <th>{{ trans('file.Tax') }}</th>
                        <th>{{ trans('file.Discount') }}</th>
                        <th>{{ trans('file.Subtotal') }}</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div id="sale-footer" class="modal-body"></div>
            </div>
        </div>
    </div>

    <div id="view-payment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
        class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">{{ trans('file.All') }} {{ trans('file.Payment') }}
                    </h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span
                            aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <table class="table table-hover payment-list">
                        <thead>
                            <tr>
                                <th>{{ trans('file.date') }}</th>
                                <th>{{ trans('file.reference') }}</th>
                                <th>{{ trans('file.Account') }}</th>
                                <th>{{ trans('file.Amount') }}</th>
                                <th>{{ trans('file.Paid By') }}</th>
                                <th>{{ trans('file.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- {{ Request::segment(4) }} --}}
@endsection
@section('styles')
    <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset('vendor/daterange/css/daterangepicker.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('app/css/plugins/datatables.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

@endsection

@section('scripts')
    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterange/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterange/js/knockout-3.4.2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/daterange/js/daterangepicker.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('app/css/plugins/sweetalert2.min.css') }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/idb.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    

    <script type="text/javascript">
        $('.company').select2({
            ajax: {
                url: "{{ route('admin.report.search.company') }}",
                data: function(params) {
                    var query = {
                        search: params.term,
                    }
                    return query;
                }
            }
        });

        $("ul#sale").siblings('a').attr('aria-expanded', 'true');
        $("ul#sale").addClass("show");
        $("ul#sale #sale-list-menu").addClass("active");
        var public_key = "";
        var all_permission = "";
        var reward_point_setting = {};
        var sale_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')); ?>;
        var starting_date = <?php echo json_encode($starting_date); ?>;
        var ending_date = <?php echo json_encode($ending_date); ?>;
        var warehouse_id = <?php echo json_encode($warehouse_id); ?>;
        var sale_status = <?php echo json_encode($sale_status); ?>;
        var payment_status = <?php echo json_encode($payment_status); ?>;
        var company_id = <?php echo json_encode($company_id); ?>;
        var balance = 0;
        var expired_date = "";
        var current_date = <?php echo json_encode(date('Y-m-d')); ?>;
        var payment_date = [];
        var payment_reference = [];
        var paid_amount = [];
        var paying_method = [];
        var payment_id = [];
        var payment_note = [];
        var account = [];
        var deposit;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#warehouse_id").val(warehouse_id);
        $("#sale-status").val(sale_status);
        $("#payment-status").val(payment_status);

        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, period) {
                var starting_date = startDate.format('YYYY-MM-DD');
                var ending_date = endDate.format('YYYY-MM-DD');
                var title = starting_date + ' To ' + ending_date;
                $(this).val(title);
                $('input[name="starting_date"]').val(starting_date);
                $('input[name="ending_date"]').val(ending_date);
            }
        });

        $(".gift-card").hide();
        $(".card-element").hide();
        $("#cheque").hide();

        $('.selectpicker').selectpicker('refresh');

        $(document).on("click", "tr.sale-link td:not(:first-child, :last-child)", function() {
            var sale = $(this).parent().data('sale');
            saleDetails(sale);
        });

        $(document).on("click", ".view", function() {
            var sale = $(this).parent().parent().parent().parent().parent().data('sale');
            saleDetails(sale);
        });

        $(document).on("click", "#print-btn", function() {
            var divContents = document.getElementById("sale-details").innerHTML;
            var a = window.open('');
            a.document.write('<html>');
            a.document.write('<body>');
            a.document.write(
                '<style>body{font-family: sans-serif;line-height: 1.15;-webkit-text-size-adjust: 100%;}.d-print-none{display:none}.text-center{text-align:center}.row{width:100%;margin-right: -15px;margin-left: -15px;}.col-md-12{width:100%;display:block;padding: 5px 15px;}.col-md-6{width: 50%;float:left;padding: 5px 15px;}table{width:100%;margin-top:30px;}th{text-aligh:left}td{padding:10px}table,th,td{border: 1px solid black; border-collapse: collapse;}</style><style>@media print {.modal-dialog { max-width: 1000px;} }</style>'
                );
            a.document.write(divContents);
            a.document.write('</body></html>');
            a.document.close();
            setTimeout(function() {
                a.close();
            }, 10);
            a.print();
        });

        $(document).on("click", "table.sale-list tbody .add-payment", function() {
            $("#cheque").hide();
            $(".gift-card").hide();
            $(".card-element").hide();
            $('select[name="paid_by_id"]').val(1);
            $('.selectpicker').selectpicker('refresh');
            rowindex = $(this).closest('tr').index();
            deposit = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.deposit').val();
            var sale_id = $(this).data('id').toString();
            var balance = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('td:nth-child(12)')
                .text();
            balance = parseFloat(balance.replace(/,/g, ''));
            $('input[name="paying_amount"]').val(balance);
            $('#add-payment input[name="balance"]').val(balance);
            $('input[name="amount"]').val(balance);
            $('input[name="sale_id"]').val(sale_id);
        });

        $(document).on("click", "table.sale-list tbody .get-payment", function(event) {
            rowindex = $(this).closest('tr').index();
            deposit = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.deposit').val();
            var id = $(this).data('id').toString();
            $.get('sales/getpayment/' + id, function(data) {
                $(".payment-list tbody").remove();
                var newBody = $("<tbody>");
                payment_date = data[0];
                payment_reference = data[1];
                paid_amount = data[2];
                paying_method = data[3];
                payment_id = data[4];
                payment_note = data[5];
                cheque_no = data[6];
                gift_card_id = data[7];
                change = data[8];
                paying_amount = data[9];
                account_name = data[10];
                account_id = data[11];

                $.each(payment_date, function(index) {
                    var newRow = $("<tr>");
                    var cols = '';

                    cols += '<td>' + payment_date[index] + '</td>';
                    cols += '<td>' + payment_reference[index] + '</td>';
                    cols += '<td>' + account_name[index] + '</td>';
                    cols += '<td>' + paid_amount[index] + '</td>';
                    cols += '<td>' + paying_method[index] + '</td>';
                    cols +=
                        '<td><div class="btn-group"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ trans('file.action') }}<span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button><ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">';
                    if (paying_method[index] != 'Paypal' && all_permission.indexOf(
                            "sale-payment-edit") != -1)
                        cols +=
                        '<li><button type="button" class="btn btn-link edit-btn" data-id="' +
                        payment_id[index] +
                        '" data-clicked=false data-toggle="modal" data-target="#edit-payment"><i class="dripicons-document-edit"></i> {{ trans('file.edit') }}</button></li> ';

                    newRow.append(cols);
                    newBody.append(newRow);
                    $("table.payment-list").append(newBody);
                });
                $('#view-payment').modal('show');
            });
        });

        $("table.payment-list").on("click", ".edit-btn", function(event) {
            $(".edit-btn").attr('data-clicked', true);
            $(".card-element").hide();
            $("#edit-cheque").hide();
            $('.gift-card').hide();
            $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
            var id = $(this).data('id').toString();
            $.each(payment_id, function(index) {
                if (payment_id[index] == parseFloat(id)) {
                    $('input[name="payment_id"]').val(payment_id[index]);
                    $('#edit-payment select[name="account_id"]').val(account_id[index]);
                    if (paying_method[index] == 'Cash')
                        $('select[name="edit_paid_by_id"]').val(1);
                    else if (paying_method[index] == 'Gift Card') {
                        $('select[name="edit_paid_by_id"]').val(2);
                        $('#edit-payment select[name="gift_card_id"]').val(gift_card_id[index]);
                        $('.gift-card').show();
                        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                    } else if (paying_method[index] == 'Credit Card') {
                        $('select[name="edit_paid_by_id"]').val(3);
                        $.getScript("public/vendor/stripe/checkout.js");
                        $(".card-element").show();
                        $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', true);
                    } else if (paying_method[index] == 'Cheque') {
                        $('select[name="edit_paid_by_id"]').val(4);
                        $("#edit-cheque").show();
                        $('input[name="edit_cheque_no"]').val(cheque_no[index]);
                        $('input[name="edit_cheque_no"]').attr('required', true);
                    } else if (paying_method[index] == 'Deposit')
                        $('select[name="edit_paid_by_id"]').val(6);
                    else if (paying_method[index] == 'Points') {
                        $('select[name="edit_paid_by_id"]').val(7);
                    }

                    $('.selectpicker').selectpicker('refresh');
                    $("#payment_reference").html(payment_reference[index]);
                    $('input[name="edit_paying_amount"]').val(paying_amount[index]);
                    $('#edit-payment .change').text(change[index]);
                    $('input[name="edit_amount"]').val(paid_amount[index]);
                    $('textarea[name="edit_payment_note"]').val(payment_note[index]);
                    return false;
                }
            });
            $('#view-payment').modal('hide');
        });

        $('select[name="paid_by_id"]').on("change", function() {
            var id = $(this).val();
            $('input[name="cheque_no"]').attr('required', false);
            $('#add-payment select[name="gift_card_id"]').attr('required', false);
            $(".payment-form").off("submit");
            if (id == 2) {
                $(".gift-card").show();
                $(".card-element").hide();
                $("#cheque").hide();
                $('#add-payment select[name="gift_card_id"]').attr('required', true);
            } else if (id == 3) {
                $.getScript("public/vendor/stripe/checkout.js");
                $(".card-element").show();
                $(".gift-card").hide();
                $("#cheque").hide();
            } else if (id == 4) {
                $("#cheque").show();
                $(".gift-card").hide();
                $(".card-element").hide();
                $('input[name="cheque_no"]').attr('required', true);
            } else if (id == 5) {
                $(".card-element").hide();
                $(".gift-card").hide();
                $("#cheque").hide();
            } else {
                $(".card-element").hide();
                $(".gift-card").hide();
                $("#cheque").hide();
                if (id == 6) {
                    if ($('#add-payment input[name="amount"]').val() > parseFloat(deposit))
                        alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
                } else if (id == 7) {
                    pointCalculation($('#add-payment input[name="amount"]').val());
                }
            }
        });

        $('#add-payment select[name="gift_card_id"]').on("change", function() {
            var id = $(this).val();
            if (expired_date[id] < current_date)
                alert('This card is expired!');
            else if ($('#add-payment input[name="amount"]').val() > balance[id]) {
                alert('Amount exceeds card balance! Gift Card balance: ' + balance[id]);
            }
        });

        $('input[name="paying_amount"]').on("input", function() {
            $(".change").text(parseFloat($(this).val() - $('input[name="amount"]').val()).toFixed(2));
        });

        $('input[name="amount"]').on("input", function() {
            if ($(this).val() > parseFloat($('input[name="paying_amount"]').val())) {
                alert('Paying amount cannot be bigger than recieved amount');
                $(this).val('');
            } else if ($(this).val() > parseFloat($('input[name="balance"]').val())) {
                alert('Paying amount cannot be bigger than due amount');
                $(this).val('');
            }
            $(".change").text(parseFloat($('input[name="paying_amount"]').val() - $(this).val()).toFixed(2));
            var id = $('#add-payment select[name="paid_by_id"]').val();
            var amount = $(this).val();
            if (id == 2) {
                id = $('#add-payment select[name="gift_card_id"]').val();
                if (amount > balance[id])
                    alert('Amount exceeds card balance! Gift Card balance: ' + balance[id]);
            } else if (id == 6) {
                if (amount > parseFloat(deposit))
                    alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
            } else if (id == 7) {
                pointCalculation(amount);
            }
        });

        $('select[name="edit_paid_by_id"]').on("change", function() {
            var id = $(this).val();
            $('input[name="edit_cheque_no"]').attr('required', false);
            $('#edit-payment select[name="gift_card_id"]').attr('required', false);
            $(".payment-form").off("submit");
            if (id == 2) {
                $(".card-element").hide();
                $("#edit-cheque").hide();
                $('.gift-card').show();
                $('#edit-payment select[name="gift_card_id"]').attr('required', true);
            } else if (id == 3) {
                $(".edit-btn").attr('data-clicked', true);
                $.getScript("public/vendor/stripe/checkout.js");
                $(".card-element").show();
                $("#edit-cheque").hide();
                $('.gift-card').hide();
            } else if (id == 4) {
                $("#edit-cheque").show();
                $(".card-element").hide();
                $('.gift-card').hide();
                $('input[name="edit_cheque_no"]').attr('required', true);
            } else {
                $(".card-element").hide();
                $("#edit-cheque").hide();
                $('.gift-card').hide();
                if (id == 6) {
                    if ($('input[name="edit_amount"]').val() > parseFloat(deposit))
                        alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
                } else if (id == 7) {
                    pointCalculation($('input[name="edit_amount"]').val());
                }
            }
        });

        $('#edit-payment select[name="gift_card_id"]').on("change", function() {
            var id = $(this).val();
            if (expired_date[id] < current_date)
                alert('This card is expired!');
            else if ($('#edit-payment input[name="edit_amount"]').val() > balance[id])
                alert('Amount exceeds card balance! Gift Card balance: ' + balance[id]);
        });

        $('input[name="edit_paying_amount"]').on("input", function() {
            $(".change").text(parseFloat($(this).val() - $('input[name="edit_amount"]').val()).toFixed(2));
        });

        $('input[name="edit_amount"]').on("input", function() {
            if ($(this).val() > parseFloat($('input[name="edit_paying_amount"]').val())) {
                alert('Paying amount cannot be bigger than recieved amount');
                $(this).val('');
            }
            $(".change").text(parseFloat($('input[name="edit_paying_amount"]').val() - $(this).val()).toFixed(2));
            var amount = $(this).val();
            var id = $('#edit-payment select[name="gift_card_id"]').val();
            if (amount > balance[id]) {
                alert('Amount exceeds card balance! Gift Card balance: ' + balance[id]);
            }
            var id = $('#edit-payment select[name="edit_paid_by_id"]').val();
            if (id == 6) {
                if (amount > parseFloat(deposit))
                    alert('Amount exceeds customer deposit! Customer deposit : ' + deposit);
            } else if (id == 7) {
                pointCalculation(amount);
            }
        });

        $(document).on("click", "table.sale-list tbody .add-delivery", function(event) {
            var id = $(this).data('id').toString();
            $.get('delivery/create/' + id, function(data) {
                $('#dr').text(data[0]);
                $('#sr').text(data[1]);

                $('select[name="status"]').val(data[2]);
                $('.selectpicker').selectpicker('refresh');
                $('input[name="delivered_by"]').val(data[3]);
                $('input[name="recieved_by"]').val(data[4]);
                $('#customer').text(data[5]);
                $('textarea[name="address"]').val(data[6]);
                $('textarea[name="note"]').val(data[7]);
                $('input[name="reference_no"]').val(data[0]);
                $('input[name="sale_id"]').val(id);
                $('#add-delivery').modal('show');
            });
        });

        function pointCalculation(amount) {
            availablePoints = $('table.sale-list tbody tr:nth-child(' + (rowindex + 1) + ')').find('.points').val();
            required_point = Math.ceil(amount / reward_point_setting['per_point_amount']);
            if (required_point > availablePoints) {
                alert('Customer does not have sufficient points. Available points: ' + availablePoints +
                    '. Required points: ' + required_point);
            }
        }

        $('#sale-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{ route('admin.pos.sale.data') }}",
                data: {
                    all_permission: all_permission,
                    starting_date: starting_date,
                    ending_date: ending_date,
                    warehouse_id: warehouse_id,
                    sale_status: sale_status,
                    payment_status: payment_status,
                    company_id: company_id
                },
                dataType: "json",
                type: "post"
            },
            /*rowId: function(data) {
                  return 'row_'+data['id'];
            },*/
            "createdRow": function(row, data, dataIndex) {
                // console.log(data);
                $(row).addClass('sale-link');
                $(row).attr('data-sale', data['sale']);
            },
            "columns": [{
                    "data": "key"
                },
                {
                    "data": "date"
                },
                {
                    "data": "reference_no"
                },
                {
                    "data": "ms_order_no"
                },
                // {"data": "biller"},
                // {"data": "customer"},
                {
                    "data": "company"
                },
                {
                    "data": "branch"
                },
                {
                    "data": "sale_status"
                },
                // {"data": "payment_status"},
                // {"data": "delivery_status"},
                {
                    "data": "grand_total"
                },
                // {"data": "returned_amount"},
                // {"data": "paid_amount"},
                // {"data": "due"},
                {
                    "data": "tax"
                },
                {
                    "data": "status"
                },
                {
                    "data": "payment_status"
                },
                    // {
                    //     "data": "pick_time"
                    // },
                    // {
                    //     "data": "pick_date"
                    // },
                    {
                        "data": "delivery_date",
                        "render": function(data, type, row, meta) {
                            if (type === 'display') {
                                return '<div class="input-group date" id="deliveryDate_' + row.id + '">' +
                                    '<input type="text" value="' + data + '" data-id="' + row.id + '" class="form-control delivery-date" />' +
                                    '<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>' +
                                    '</div>';
                            }
                            return data;
                        }
                    },
                {
                    "data": "options"
                },
            ],
            order: [
                ['1', 'desc']
            ],
            'columnDefs': [{
                    "orderable": false
                    //'targets': [0, 3, 4, 5, 6, 7, 10, 11, 12,13,14]
                },
                {
                    'render': function(data, type, row, meta) {
                        if (type === 'display') {
                            data =
                                '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                        }

                        return data;
                    },
                    'checkboxes': {
                        'selectRow': true,
                        'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                    },
                    'targets': [0]
                }
            ],
            drawCallback: function() {
                var api = this.api();
                datatable_sum(api, false);
                $('.delivery-date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
            }
        });

        // $(document).on("change", '.delivery-date', function() {
        //     let id = $(this).data("id");
        //     let updatedDate = $(this).val(); // Updated date from the input field

        //     $.ajax({
        //         url: "{{ route('admin.update.deliveryDate') }}",
        //         type: "POST",
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         data: {
        //             'delivery_date': updatedDate,
        //             'id': id,
        //         },
        //         success: function(data) {
        //             console.log("Delivery date updated:", data);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error("Error updating delivery date:", error);
        //             // Handle error scenario here
        //         }
        //     });
        // });
        $(document).on("change", '.delivery-date', function() {
    let id = $(this).data("id");
    let updatedDate = $(this).val(); // Updated date from the input field

                $.ajax({
                    url: "{{ route('admin.update.deliveryDate') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'delivery_date': updatedDate,
                        'id': id,
                    },
                    success: function(data) {
                        console.log("Delivery date updated:", data);

                        // SweetAlert for success
                        swal({
                            title: "Delivery Date Updated",
                            text: "The delivery date has been updated successfully.",
                            icon: "success",
                            button: false,
                            timer: 3000
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error("Error updating delivery date:", error);
                        // SweetAlert for error
                        swal({
                            title: "Error Updating Delivery Date",
                            text: "There was an error updating the delivery date. Please try again.",
                            icon: "error",
                            button: "OK",
                        });
                    }
                });
            });



        function datatable_sum(dt_selector, is_calling_first) {
            if (dt_selector.rows('.selected').any() && is_calling_first) {
                var rows = dt_selector.rows('.selected').indexes();

                // $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
                // $( dt_selector.column( 9 ).footer() ).html(dt_selector.cells( rows, 9, { page: 'current' } ).data().sum().toFixed(2));
                // $( dt_selector.column( 10 ).footer() ).html(dt_selector.cells( rows, 10, { page: 'current' } ).data().sum().toFixed(2));
                // $( dt_selector.column( 11 ).footer() ).html(dt_selector.cells( rows, 11, { page: 'current' } ).data().sum().toFixed(2));
            } else {
                // $( dt_selector.column( 8 ).footer() ).html(dt_selector.cells( rows, 8, { page: 'current' } ).data().sum().toFixed(2));
                // $( dt_selector.column( 9 ).footer() ).html(dt_selector.cells( rows, 9, { page: 'current' } ).data().sum().toFixed(2));
                // $( dt_selector.column( 10 ).footer() ).html(dt_selector.cells( rows, 10, { page: 'current' } ).data().sum().toFixed(2));
                // $( dt_selector.column( 11 ).footer() ).html(dt_selector.cells( rows, 11, { page: 'current' } ).data().sum().toFixed(2));
            }
        }

        function saleDetails(sale) {
            $("#sale-details input[name='sale_id']").val(sale[13]);

            var htmltext = '<strong>{{ trans('file.Date') }}: </strong>' + sale[0] +
                '<br><strong>{{ trans('file.reference') }}: </strong>' + sale[1] +
                '<br><strong>{{ trans('file.Warehouse') }}: </strong>' + sale[27] +
                '<br><strong>{{ trans('file.Sale Status') }}: </strong>' + sale[2] +
                '<br><br><div class="row"><div class="col-md-6"><strong>{{ trans('file.From') }}:</strong><br>' + sale[3] +
                '<br>' + sale[4] + '<br>' + sale[5] + '<br>' + sale[6] + '<br>' + sale[7] + '<br>' + sale[8] +
                '</div><div class="col-md-6"><div class="float-right"><strong>{{ trans('file.To') }}:</strong><br>' + sale[
                    9] + '<br>' + sale[10] + '<br>' + sale[11] + '<br>' + sale[12] + '</div></div></div>';
            $.get('sales/product_sale/' + sale[13], function(data) {
                $(".product-sale-list tbody").remove();
                var name_code = data[0];
                var qty = data[1];
                var unit_code = data[2];
                var tax = data[3];
                var tax_rate = data[4];
                var discount = data[5];
                var subtotal = data[6];
                var batch_no = data[7];
                var newBody = $("<tbody>");
                $.each(name_code, function(index) {
                    var newRow = $("<tr>");
                    var cols = '';
                    cols += '<td><strong>' + (index + 1) + '</strong></td>';
                    cols += '<td>' + name_code[index] + '</td>';
                    cols += '<td>' + batch_no[index] + '</td>';
                    cols += '<td>' + qty[index] + '</td>';
                    cols += '<td>' + unit_code[index] + '</td>';
                    cols += '<td>' + parseFloat(subtotal[index] / qty[index]).toFixed(2) + '</td>';
                    cols += '<td>' + tax[index] + '(' + tax_rate[index] + '%)' + '</td>';
                    cols += '<td>' + discount[index] + '</td>';
                    cols += '<td>' + subtotal[index] + '</td>';
                    newRow.append(cols);
                    newBody.append(newRow);
                });

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=6><strong>{{ trans('file.Total') }}:</strong></td>';
                cols += '<td>' + sale[14] + '</td>';
                cols += '<td>' + sale[15] + '</td>';
                cols += '<td>' + sale[16] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=8><strong>{{ trans('file.Order Tax') }}:</strong></td>';
                cols += '<td>' + sale[17] + '(' + sale[18] + '%)' + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=8><strong>{{ trans('file.Order Discount') }}:</strong></td>';
                cols += '<td>' + sale[19] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);
                if (sale[28]) {
                    var newRow = $("<tr>");
                    cols = '';
                    cols += '<td colspan=8><strong>{{ trans('file.Coupon Discount') }} [' + sale[28] +
                        ']:</strong></td>';
                    cols += '<td>' + sale[29] + '</td>';
                    newRow.append(cols);
                    newBody.append(newRow);
                }

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=8><strong>{{ trans('file.Shipping Cost') }}:</strong></td>';
                cols += '<td>' + sale[20] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=8><strong>{{ trans('file.grand total') }}:</strong></td>';
                cols += '<td>' + sale[21] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=8><strong>{{ trans('file.Paid Amount') }}:</strong></td>';
                cols += '<td>' + sale[22] + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                var newRow = $("<tr>");
                cols = '';
                cols += '<td colspan=8><strong>{{ trans('file.Due') }}:</strong></td>';
                cols += '<td>' + parseFloat(sale[21] - sale[22]).toFixed(2) + '</td>';
                newRow.append(cols);
                newBody.append(newRow);

                $("table.product-sale-list").append(newBody);
            });
            var htmlfooter = '<p><strong>{{ trans('file.Sale Note') }}:</strong> ' + sale[23] +
                '</p><p><strong>{{ trans('file.Staff Note') }}:</strong> ' + sale[24] +
                '</p><strong>{{ trans('file.Created By') }}:</strong><br>' + sale[25] + '<br>' + sale[26];
            $('#sale-content').html(htmltext);
            $('#sale-footer').html(htmlfooter);
            $('#sale-details').modal('show');
        }

        $(document).on('submit', '.payment-form', function(e) {
            if ($('input[name="paying_amount"]').val() < parseFloat($('#amount').val())) {
                alert('Paying amount cannot be bigger than recieved amount');
                $('input[name="amount"]').val('');
                $(".change").text(parseFloat($('input[name="paying_amount"]').val() - $('#amount').val()).toFixed(
                    2));
                e.preventDefault();
            } else if ($('input[name="edit_paying_amount"]').val() < parseFloat($('input[name="edit_amount"]')
                .val())) {
                alert('Paying amount cannot be bigger than recieved amount');
                $('input[name="edit_amount"]').val('');
                $(".change").text(parseFloat($('input[name="edit_paying_amount"]').val() - $(
                    'input[name="edit_amount"]').val()).toFixed(2));
                e.preventDefault();
            }

            $('#edit-payment select[name="edit_paid_by_id"]').prop('disabled', false);
        });

        $(document).on('click', '.pushDynamics', function() {
            var sale_id = $(this).attr('data-id');
            var circle_notch = $(this).attr('data-loading');
            $(this).html(circle_notch);
            $.ajax({
                url: "/admin/pos/push_order/" + sale_id,
                type: 'GET',
                dataType: 'json', // added data type
                success: function(res) {
                    console.log(res);
                    if (res) {
                        swal({
                            title: "Pushed to Dynamics",
                            text: "Done",
                            icon: "success",
                            button: false,
                            timer: 3000
                        });

                        location.reload();
                    } else {
                        swal({
                            title: "Error Pushing in Dynamics",
                            text: "There was something wrong, please try again",
                            icon: "warning",
                            dangerMode: true,
                            button: "OK",
                        }).then((value) => {
                            location.reload();
                        });
                    }
                }
            });
        });

        if (all_permission.indexOf("sales-delete") == -1)
            $('.buttons-delete').addClass('d-none');

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        function confirmPaymentDelete() {
            if (confirm("Are you sure want to delete? If you delete this money will be refunded.")) {
                return true;
            }
            return false;
        }
    </script>
    <script>
        async function loadDatabase() {
            const db = await idb.openDB("cater_choice_store", 2, {
                upgrade(db, oldVersion, newVersion, transaction) {
                    if (newVersion == 1 || oldVersion == 0) {
                        db.createObjectStore("products", {
                            keyPath: "id",
                            autoIncrement: true,
                        });
                        db.createObjectStore("sales", {
                            keyPath: "productId",
                            autoIncrement: true,
                        });
                    }
                    if (newVersion == 2) {

                        db.createObjectStore("pauses", {
                            keyPath: "id",
                            autoIncrement: true,
                        });
                    }
                },
            });

            $(document).on("click", ".re-order", function() {
                db.clear("sales")

                var order_id = $(this).data("id");
                var user_id = $(this).data("user-id");
                var branch_id = $(this).data("branch-id");
                $.ajax({
                    url: "{{ route('admin.pos.order.by.product') }}",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'order_id': order_id,
                        'user_id': user_id,
                        'branch_id ': branch_id,
                    },
                    success: function(data) {
                        for (let product of data) {
                            db.put("sales", product)
                        }
                        var url =
                            '{{ URL::to('admin/admin-pos/' . ':order_id' . '/:user_id' . '/:branch_id') }}';
                        url = url.replace(':order_id', order_id).replace(':user_id', user_id)
                            .replace(':branch_id', branch_id);
                        window.location = url
                    }
                });
            })
        }
        loadDatabase();
        
    </script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
@endsection

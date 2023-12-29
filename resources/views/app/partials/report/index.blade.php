@extends('layouts.app')

@section('content')
<section id="pricing" class="pricing">

  <div class="row mb-4">
    <div class="col-md-12 mb-4">

      <div class="form-row">
        <div class="form-group col-lg-4">
          <label><strong>Date</strong></label>
          <input type="text" class="daterangepicker-field form-control" value="{{$starting_date}} To {{$ending_date}}" readonly />
          <input type="hidden" name="starting_date" id="starting-date" value="{{$starting_date}}" />
          <input type="hidden" name="ending_date" id="ending-date" value="{{$ending_date}}" />
        </div>
        {{-- <div class="form-group col-lg-4">
            <label for="inputPassword4">Payment</label>
            <select class="form-control" id="payment-status">
              <option value="">ALL</option>
              <option value="pending">Pending</option>
              <option value="complete">Complete</option>
              <option value="reject">Reject</option>
              
            </select>
          </div> --}}

        <div class="form-group col-lg-2">
          <label>Branch</label>
          <select class="form-control branch w-100" id="branch-id">
            <option value="">ALL</option>

          </select>
        </div>

        <div class="form-group col-lg-2 d-flex align-items-center justify-content-lg-left justify-content-end ">
          <button type="button" id="search" class="btn btn-primary mt-3">Search</button>
        </div>
      </div>




    </div>

    <div class="col-md-12 mb-3">

      <div class="card text-left">

        <div class="card-body">
          <div class="table-responsive">
            <table class="table" id="booking-datatable">
              <thead>
                <tr>
                  <th scope="col">Reference</th>
                  <th scope="col">Branch</th>
                  {{-- <th scope="col">Payment</th> --}}
                  <th scope="col">Grand Total</th>
                  <th scope="col">Tax</th>
                  <th scope="col">Paid</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
          <table class="table text-center">
            <tr>
              <th>Tax</th>
              <th id="total-tax"></th>
            </tr>
            <tr>
              <th>Total</th>
              <th id="total-amount"></th>
            </tr>
            <tr>
              <th>Profit</th>
              <th id="total-profit"></th>
            </tr>
          </table>
        </div>
      </div>
    </div>

  </div>

</section>


@endsection
@section('styles')
<link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('vendor/daterange/css/daterangepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('app/css/plugins/datatables.min.css') }}" />
@endsection
@section('scripts')
<script type="text/javascript" src="{{ asset('vendor/daterange/js/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/daterange/js/knockout-3.4.2.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/daterange/js/daterangepicker.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>

<script type="text/javascript">
  $('.branch').select2({
    ajax: {
      url: "{{route('app.report.search.branch')}}",
      data: function(params) {
        var query = {
          search: params.term,
        }
        return query;
      }
    }
  });

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

  var table = $('#booking-datatable').DataTable({
    //destroy: true,
    processing: true,
    serverSide: true,
    responsive: true,
    //bFilter:false,
    lengthChange: false,
    pageLength: 10,
    dom: 'Bfrtip',
    buttons: ['copy', 'csv', 'excel', 'pdf'],

    "ajax": {
      "url": "{{ route('app.report.ajax') }}",
      "type": "POST",
      "data": function(d) {
        d.starting_date = $('#starting-date').val();
        d.ending_date = $('#ending-date').val();
        d.payment_status = $('#payment-status').val();
        d.branch_id = $('#branch-id').val();
        d._token = $('meta[name="csrf-token"]').attr('content');
      },
      "headers": {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
      },
      "dataSrc": function(json) {
        console.log(json);
        $('#total-tax').text(json.total_tax);
        $('#total-amount').text(json.total_amount);
        $('#total-profit').text(json.total_profit);
        return json.data;
      }
    },
    columns: [{
        data: 'reference_no',
        name: 'reference_no'
      },
      {
        data: 'branch.name',
        name: 'branch.name',
        "render": function(data, type, row, meta) {
          return (row?.branch?.name || "");
        }
      },
      // {data: 'payment_status', name: 'payment_status',  "render": function ( data, type, row, meta ) {
      //   if(data=="complete"){
      //     return '<span class="badge badge-success mr-1">Complete</span>';
      //   } else if(data=="reject"){
      //     return '<span class="badge badge-danger mr-1">Reject</span>';
      //   }
      //   return '<span class="badge badge-warning mr-1">Pending</span>';

      // }},
      {
        data: 'grand_total',
        name: 'grand_total'
      },
      {
        data: 'total_tax',
        name: 'total_tax'
      },
      {
        data: 'paid_amount',
        name: 'paid_amount'
      },

      {
        data: 'action',
        name: 'action',
        orderable: true,
        searchable: true
      },
    ],
  });

  $(document).on("click", "#search", function() {
    table.draw();
  })
</script>
@endsection
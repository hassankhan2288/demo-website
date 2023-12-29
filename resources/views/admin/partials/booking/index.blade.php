@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">
   
      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table" id="booking-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">Order#</th>
                                  <th scope="col">Category</th>
                                  <th scope="col">Service</th>
                                  <th scope="col">Vehicle</th>
                                  <th scope="col">Booking Confirmation</th>
                                  <th scope="col">Document</th>
                                  <th scope="col">Certificate</th>
                                  <th scope="col">Test Status</th>
                              </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
      
  </div>

</section>


@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('app/css/plugins/datatables.min.css') }}" />
@endsection
@section('scripts')
<script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
<script type="text/javascript">
  var table = $('#booking-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.booking.ajax') }}",
            "type": "POST",
            "data": function(d){
               d._token = $('meta[name="csrf-token"]').attr('content');
            },
            "headers": {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
        },
        success: function (result) {
            //alert(result);
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'category.vehicle_type_name', name: 'category.vehicle_type_name'},
            {data: 'service.service_name', name: 'service.service_name'},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'booking_date', name: 'booking_date'},
            
            {data: 'document', name: 'document'},
            {data: 'certificate', name: 'certificate'},
            {data: 'status', name: 'status',  "render": function ( data, type, row, meta ) {
              if(data=="pass"){
                return '<span class="badge badge-success mr-1">Pass</span>';
              } else if(data=="fail"){
                return '<span class="badge badge-danger mr-1">Fail</span>';
              }
              return '<span class="badge badge-info mr-1">N/A</span>';
           
            }}
        ],
    });

</script>
@endsection

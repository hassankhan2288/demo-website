@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">

      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="card-title">Vehicle information</div>
                  <div class="row">
                    <div class="col-sm-8">
                      <div>Make #: {{$vehicle->name}}</div>
                      <div>Model: {{$vehicle->model}}</div>
                      <div>Number plate: {{$vehicle->number_plate}}</div>
                      <div>Category: {{$vehicle->category->vehicle_type_name}}</div>
                      <div>Service: @if($vehicle->services) @foreach($vehicle->services as $service) {{$service->service_name}} @endforeach @endif</div>
                      <div>VIN: {{$vehicle->vin}}</div>
                      <div>Axle: {{$vehicle->axle}}</div>
                      <div>Registration date: {{$vehicle->registration_date}}</div>
                      <div>ICS Purchase date: {{$vehicle->first_registration_date}}</div>
                      <div>Tires Front: {{$vehicle->tires_front}}</div>
                      <div>Tires Back: {{$vehicle->tires_back}}</div>
                      <div>Warranty: {{$vehicle->warranty}}</div>
                    </div>
                    <div class="col-sm-4">
                      @if($vehicle->image)
                       <img src="{{ Storage::url($vehicle->image) }}" class="mb-2 mt-2" style="width: 200px;">
                      @endif
                    </div> 
                    
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="card-title">Booking Expected</div>
                  <div class="table-responsive">
                      <table class="table" id="expected-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">Order#</th>
                                  <th scope="col">Category</th>
                                  <th scope="col">Service</th>
                                  <th scope="col">Vehicle</th>
                                  <th scope="col">Next test date</th>
                                  <th scope="col">Document</th>
                              </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>
   
      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="card-title">Booking Inspection</div>
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
                              </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
                      </table>
                  </div>
              </div>
          </div>
      </div>

      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="card-title">Booking Result</div>
                  <div class="table-responsive">
                      <table class="table" id="result-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">Order#</th>
                                  <th scope="col">Category</th>
                                  <th scope="col">Service</th>
                                  <th scope="col">Vehicle</th>
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
               d.vehicle_id = "{{$vehicle->id??""}}";
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
            {data: 'order_number', name: 'order_number'},
            {data: 'category.vehicle_type_name', name: 'category.vehicle_type_name'},
            {data: 'service.service_name', name: 'service.service_name'},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'booking_date', name: 'booking_date'},
            
            {data: 'document', name: 'document'},
        ],
    });

  var table = $('#result-datatable').DataTable({
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
               d.vehicle_id = "{{$vehicle->id??""}}";
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
            {data: 'order_number', name: 'order_number'},
            {data: 'category.vehicle_type_name', name: 'category.vehicle_type_name'},
            {data: 'service.service_name', name: 'service.service_name'},
            {data: 'vehicle.name', name: 'vehicle.name'},
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


  var table = $('#expected-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.expected.ajax') }}",
            "type": "POST",
            "data": function(d){
               d.vehicle_id = "{{$vehicle->id??""}}";
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
            {data: 'order_number', name: 'order_number'},
            {data: 'category.vehicle_type_name', name: 'category.vehicle_type_name'},
            {data: 'service.service_name', name: 'service.service_name'},
            {data: 'vehicle.name', name: 'vehicle.name'},
            {data: 'next_test_date', name: 'next_test_date'},
            
            {data: 'document', name: 'document'},
        ],
    });

</script>
@endsection

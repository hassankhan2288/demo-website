@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">
    <div class="row mb-4">
      @can("vehicle-add")
      <div class="col-md-12 mb-4">
        <a class="btn btn-primary ladda-button float-right" href="{{route('admin.vehicle.form')}}" data-style="expand-left">Add</a>
      </div>
      @endcan
   
      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table" id="vehicles-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Model</th>
                                  <th scope="col">Number</th>
                                  <th scope="col">ICS Purchase date</th>
                                  <th scope="col">Category</th>
                                  <th scope="col">Services</th>
                                  <th scope="col">Tires front</th>
                                  <th scope="col">Tires back</th>
                                  <th scope="col">Action</th>
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
<link rel="stylesheet" href="{{ asset('app/css/plugins/sweetalert2.min.css') }}" />
@endsection
@section('scripts')
<script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
<script src="{{ asset('app/js/plugins/sweetalert2.min.js') }}"></script>

<script type="text/javascript">
  var table = $('#vehicles-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.vehicle.ajax') }}",
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
            {data: 'name', name: 'name'},
            {data: 'model', name: 'model'},
            {data: 'number_plate', name: 'number_plate'},
            {data: 'first_registration_date', name: 'first_registration_date'},
            {data: 'category.vehicle_type_name', name: 'category.vehicle_type_name'},
            {data: 'services', name: 'service_name',  "render": function ( data, type, row, meta ) {
              var services = "";
              row.services.map((i,key)=>{
                services += i.service_name+", ";
              });
              return services;
           
            }},
            {data: 'tires_front', name: 'tires_front'},
            {data: 'tires_back', name: 'tires_back'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ],
    });

  $(document).on('click', '.action-delete', function(){
      var $this = $(this);
      var id = $(this).attr("id");
      swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#0CC27E',
        cancelButtonColor: '#FF586B',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mr-5',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
      }).then(function () {
        $.ajax({
              url: "{{ route('admin.vehicle.delete') }}",
              type: 'POST',
              headers: {
                  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
              },
              data:{id:id, _token:$('meta[name="csrf-token"]').attr('content')},
              beforeSend: function(){
                  
              },
              success: function (data) {
                  $this.parents("tr").remove();
              },
              error: function (data, error) {
                  
              }
          });
      });
  });

</script>
@endsection

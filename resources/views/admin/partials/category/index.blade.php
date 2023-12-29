@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">
      @can("category-add")
      <div class="col-md-12 mb-4">
        <a class="btn btn-primary ladda-button float-right" href="{{route('admin.category.form')}}" data-style="expand-left">Add</a>
      </div>
      @endcan
   
      <div class="col-md-12 mb-3">

          <div class="card text-xs-left">

              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table" id="categories-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Status</th>
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
  var table = $('#categories-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.category.ajax') }}",
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
            {data: 'vehicle_type_name', name: 'vehicle_type_name'},
            {data: 'status', name: 'status',  "render": function ( data, type, row, meta ) {
              return data==1?"Enable":"Disable";
            }},
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
              url: "{{ route('admin.category.delete') }}",
              type: 'POST',
              headers: {
                  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
              },
              data:{id:id},
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

@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">
      @can("role-add")
      <div class="col-md-12 mb-4">
        <a class="btn btn-primary ladda-button float-right" href="{{route('admin.role.form')}}" data-style="expand-left">Add</a>
      </div>
      @endcan
   
      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table" id="roles-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Permissions</th>
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
@endsection
@section('scripts')
<script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
<script type="text/javascript">
  var table = $('#roles-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.role.ajax') }}",
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
            {data: 'permissions', name: 'name',  "render": function ( data, type, row, meta ) {
              var permissions = "";
              row.permissions.map((i,key)=>{
                permissions += '<span class="badge badge-success mr-1">'+i.name+'</span>';
              });
              return permissions;
           
            }},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ],
    });

</script>
@endsection

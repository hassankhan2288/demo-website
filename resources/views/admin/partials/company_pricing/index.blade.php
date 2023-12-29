@extends('layouts.admin')

@section('content')
@if(session()->has('create_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('create_message') }}</div>
@endif
@if(session()->has('edit_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('edit_message') }}</div>
@endif
@if(session()->has('import_message'))
    <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('import_message') }}</div>
@endif
@if(session()->has('not_permitted'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
@if(session()->has('success'))
    <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('success') }}</div>
@endif
<section id="pricing" class="pricing">

    <div class="row mb-4">
      {{-- <div class="col-md-12 mb-4">
        <a class="btn btn-primary ladda-button float-right" href="{{route('admin.product_price.form')}}" data-style="expand-left">Add</a>
      </div> --}}
   
      <div class="col-md-12 mb-3">

          <div class="card text-left">

              <div class="card-body">
                  <div class="table-responsive">
                      <table class="table" id="admins-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Product Name</th>
                                  <th scope="col">Company Name</th>
                                  <th scope="col">Product Code</th>
                                  <th scope="col">Single Price</th>
                                  <th scope="col">Pack Price</th>
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
  var table = $('#admins-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.company_pricing.ajax') }}",
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
            {data: 'product_name', name: 'product_name'},
            {data: 'user_name', name: 'user_name'},
            {data: 'product_ms_id', name: 'product_ms_id'},
            {data: 'price', name: 'price'},
            {data: 'p_price', name: 'p_price'},
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

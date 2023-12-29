@extends('layouts.admin')

@section('content')
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
                                  <th scope="col">Code</th>
                                  <th scope="col">Warehouse</th>
                                  <th scope="col">Price</th>
                                  <th scope="col">Pack Price</th>
                                  <th scope="col">Single Delivery</th>
                                  <th scope="col">Pack Delivery</th>
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
            "url": "{{ route('admin.product_price.ajax') }}",
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
            {data: 'product_ms_id', name: 'product_ms_id'},
            // {data: 'warehouse_id', name: 'warehouse_id'},
            {data: 'warehouse_name', name: 'warehouse_name'},
            {data: 'price', name: 'price'},
            {data: 'p_price', name: 'p_price'},
            {data: 'delivery_single', name: 'delivery_single'},
            {data: 'delivery_pack', name: 'delivery_pack'},
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

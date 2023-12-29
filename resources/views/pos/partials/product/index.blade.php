@extends('layouts.branch')
@if ($promotions->count() > 0)
    @foreach ($promotions as $promotion)
        <div class="mb-3"
            style="background-color: {{ $promotion->color }}; padding: 8px 8px; height: unset;">
            @if ($promotion->description)
                <div class="mybanner" style="text-align: center;">{!! $promotion->description !!}</div>
            @endif
        </div>
    @endforeach
    @endif
@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">
   
      <div class="col-md-12 mb-3">

          <div class="card text-left">
            <div class="card-header">Products</div>
              <div class="card-body">
                
                  <div class="table-responsive">
                      <table class="table" id="users-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Image</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Category</th>
                                  <th scope="col">Favorite</th>
{{--                                  <th scope="col">Price</th>--}}
                                  <th scope="col">Single Price</th>
                                  <th scope="col">Pack Price</th>
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

  var table = $('#users-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "product/ajax/pos",
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
            {data: 'image', name: 'image'},
            {data: 'product.name', name: 'product.name'},
            {data: 'cate', name: 'cate'},
            {
                 data: 'id',
                 "render": function ( data, type, full, meta ) {
                     var checkboxid = full.id;
                     var checked = full.is_favorite==0?"":"checked";
                     return '<input type="checkbox" class="toggle-favorite" value='+checkboxid+' '+checked+'>';
                 },orderable:false
             },
            {data: 'price', name: 'price'},
            {data: 'p_price', name: 'p_price'},
           
        ],
    });

  $(document).on("change", '.toggle-favorite', function(){
        var id = $(this).val();
        var is_favorite = this.checked?1:0;

        $.ajax({
              url: "{{route('pos.product.add.favorite')}}",
              type: "post",
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            data: {
            'is_favorite': is_favorite,
            'id' : id,
          },
          success: function(data) {
              //userTable.draw();
          }
          });

      });

</script>
@endsection

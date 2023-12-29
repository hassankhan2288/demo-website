@extends('layouts.app')

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
                                  <th scope="col">Name</th>
                                  <th scope="col">Price</th>
                                  <th scope="col">Sale Price</th>
                                  <th scope="col">Category</th>
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
            "url": "product/ajax/branch",
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
            {data: 'product.name', name: 'product.name'},
            {data: 'company_price', name: 'company_price'},
            {data: 'price', name: 'price'},
            {data: 'cate', name: 'cate'},
           
        ],
    });




            $('#users-datatable').on("change", '.categ_sel', function(){
        //alert('ok');
        //$('.dropone').change(function() {
  //var val = $(this).val(); 

  // OR

  var val = $(this).val();
  
//})
        //let val = parseFloat($(this).data("price"));
        let id = parseFloat($(this).data("id"));
        //alert(val);
        //let price = parseFloat($(this).val());
        // let amount = total;
        // if(total<price){
        //   $(this).val(price);
        //   amount = price;
        // } else {
        //   $(this).val(total);
        // }

        $.ajax({
              url: "{{route('company.product.update.cate')}}",
              type: "post",
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            data: {
            'cate': val,
            'id' : id,
          },
          success: function(data) {
              //userTable.draw();
          }
          });

      });

    $(document).on("change", '.company-price', function(){
        let total = parseFloat($(this).data("price"));
        let id = parseFloat($(this).data("id"));
        let price = parseFloat($(this).val());
        let amount = total;
        if(total<price){
          $(this).val(price);
          amount = price;
        } else {
          $(this).val(total);
        }

        $.ajax({
              url: "{{route('app.product.update.price')}}",
              type: "post",
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            data: {
            'price': amount,
            'id' : id,
          },
          success: function(data) {
              //table.draw();
          }
          });

      });

</script>
@endsection

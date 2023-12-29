@extends('layouts.app')

@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">
      <div class="col-md-12 mb-3">
        <div class="card text-left">
          <div class="card-header">Assign Product</div>
          <div class="card-body">
            <div class="mb-3 w-50">
              <label>Add Product</label>
              <select id="booking_id"  name="booking" class="form-control select2">
                <option value=""></option>                     
              </select>
            </div>

            <form  method="post" action="{{route('app.product.assign')}}">
              @csrf
              @if(isset($branch_id))
              <input type="hidden" name="id" value="{{$branch_id}}">
              @endif
              <div id="append-product" ></div>
            </form>

          </div>
        </div>
        
      </div>
   
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
<link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('scripts')
<script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
   $('.select2').select2({
    ajax: {
    url: "{{route('app.product.search')}}",
    data: function (params) {
      var query = {
        search: params.term,
      }
        return query;
      }
    }
  });

  $('.select2').on("select2:select", function(e) { 
    let product = e.params.data.product;
    let html = '<div>';
      html += '<input type="hidden" name="product_id" value="'+product.id+'" />';
      html += '<table class="table">';
                html+='<thead>';
                    html+='<tr>';
                        html+='<th scope="col">Name</th>';
                        html+='';
                    html+='</tr>';
                html+='</thead>';
                html+='<tbody>';
                  html+='<tr>';
                    html+='<td>'+product.name+'</td>';
                    html+='<td><input type="text" name="price" value="'+product.price+'" class="form-control w-50" required /></td>';
                  html+='</tr>';
                html+='</tbody>';
            html+='</table>';
            html+='<div class="col-md">';
                    html+='<input type="submit" class="btn btn-primary ladda-button float-left mr-4 mb-4" value="Assign" />';
                html+='</div>';
     $("#append-product").html(html);
  });

  var table = $('#users-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:false,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('app.branch.product.ajax') }}",
            "type": "POST",
            "data": function(d){
               d._token = $('meta[name="csrf-token"]').attr('content');
               d.user_id = "{{$branch_id}}";
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
           
        ],
    });

</script>
@endsection

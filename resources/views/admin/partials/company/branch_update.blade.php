@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">
      {{-- @if($user)
      <div class="col-12">
        <h2>{{$user->name}}</h2>
      </div>
      @endif --}}
      <div class="col-md-4 mb-3">

          <div class="card text-left">
            <div class="card-header">Update Branch</div>
              <div class="card-body">
                
                  <form method="post" action="{{route('admin.company.branch.updated')}}">
                  @csrf
                  @if(isset($company_id))
                  <input type="hidden" name="company_id" value="{{$company_id}}">
                  <input type="hidden" name="branch_id" value="{{$branch_id}}">
                  @endif
                  <div class="card-body">
                    <div class="card-title">Branch</div>

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$branch[0]['name']}}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">{{ __('E-Mail Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" readonly value="{{$branch[0]['email']}}" required autocomplete="email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">{{ __('Phone Number') }}</label>
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$branch[0]['phone']}}" autocomplete="name" autofocus />

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                             <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Warehouse Name <span
                                class="text-danger">*</span></label>

                        <select class="form-control warehouse" id="warehouse-id" name="warehouse_id">
                            @if ($branch[0]['warehouse_id'])
                                <option value="{{$branch[0]['warehouse_id'] }}">{{$branch[0]['warehouse']['name'] }}
                            </option> 
                            @endif
                           

                        </select>
                        @error('warehouse_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                     <div class="form-group">
                            <label for="inputTitle" class="col-form-label">Ms Number <span class="text-danger">*</span></label>
                             <input type="text" class="form-control" name="ms_number" value="{{$branch[0]['ms_number']}}" required>

                            
                            @error('ms_number')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                     </div>

                    <div class="form-group">
                        <label for="address">{{ __('Address') }}</label>
                        <textarea id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address">{{$branch[0]['address']}}</textarea>

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                   
                    <span>Leave blank if you dont want to change password</span>
                    
                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                    </div> --}}
                  </div>
                  <div class="row">
                    <div class="col-md">
                        <input type="submit" class="btn btn-primary ladda-button float-right mr-4 mb-4" value="Submit" />
                    </div>
                  </div>
                </form>
              </div>
          </div>
      </div>

        <div class="col-md-8 mb-3">

          <div class="card text-left">
            <div class="card-header">Branch</div>
              <div class="card-body">
                   <div class="table-responsive">
                      <table class="table" id="users-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Email</th>
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
<?php  $company_id = Request::segment(4);
//dd($company_id);
?>

@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('app/css/plugins/datatables.min.css') }}" />
<link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('scripts')
<script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">

var company_id = '{{ $company_id }}';
      $('.warehouse').select2({
                ajax: {
                    url: "{{ route('admin.stock.search.warehouse') }}",
                    data: function(params) {
                        var query = {
                            search: params.term,
                        }
                        return query;
                    }
                }
            });
  //  $('.select2').select2({
  //   ajax: {
  //   url: "{{route('admin.product.search')}}",
  //   data: function (params) {
  //     var query = {
  //       search: params.term,
  //     }
  //       return query;
  //     }
  //   }
  // });

  // $('.select2').on("select2:select", function(e) { 
  //   let product = e.params.data.product;
  //   let html = '<div>';
  //     html += '<input type="hidden" name="product_id" value="'+product.id+'" />';
  //     html += '<table class="table">';
  //               html+='<thead>';
  //                   html+='<tr>';
  //                       html+='<th scope="col">Name</th>';
  //                       html+='';
  //                   html+='</tr>';
  //               html+='</thead>';
  //               html+='<tbody>';
  //                 html+='<tr>';
  //                   html+='<td>'+product.name+'</td>';
  //                   html+='<td><input type="text" name="price" value="'+product.price+'" class="form-control w-50" required /></td>';
  //                 html+='</tr>';
  //               html+='</tbody>';
  //           html+='</table>';
  //           html+='<div class="col-md">';
  //                   html+='<input type="submit" class="btn btn-primary ladda-button float-left mr-4 mb-4" value="Assign" />';
  //               html+='</div>';
  //    $("#append-product").html(html);
  // });

  var table = $('#users-datatable').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:true,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.company.branch.ajax') }}",
            "type": "POST",
            "data": function(d){
               d._token = $('meta[name="csrf-token"]').attr('content');
               d.user_id = "{{$company_id}}";
            },
            "headers": {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
        },
        success: function (result) {
        },
        columns: [


          {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
           
        ],
        
    });

    var userTable = $('#users-assigned').DataTable({
        //destroy: true,
        processing: true,
        serverSide: true,
        responsive: true,
        //bFilter:false,
        lengthChange:true,
        pageLength: 10,

        "ajax": {
            "url": "{{ route('admin.company.product.ajax.assigned') }}",
            "type": "POST",
            "data": function(d){
               d._token = $('meta[name="csrf-token"]').attr('content');
               d.user_id = "{{$company_id}}";
            },
            "headers": {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
        },
        success: function (result) {
            //alert(result);
        },
        columns: [
            {data: 'DT_RowIndex', name: 'product_id', orderable:false},
            {data: 'product.name', name: 'product.name', width:90},
            {data: 'product.price', name: 'product.price', render:function(data){
              return "{{currency()}}"+data;
            }},
            {data: 'price', name: 'price'},
           
        ],
    });



     $('#assign_product').click(function() {
        var ids = [];
        $('.ids_assign:checked').each(function(i, e) {
        ids.push($(this).val());
        });
        
        $.ajax({
        url: "{{route('admin.product.assign')}}",
        type: "post",
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        data: {
        'ids[]': ids,
        'id' : company_id,
    },
        success: function(data) {
          table.draw();
          userTable.draw();
          $('.ids_assign').prop('checked', false);
          $('.ids_assign').trigger("change")
      }
      });




    });

     $(document).on("change", '.all-check', function(){
      if(this.checked){
        $('.ids_assign').prop('checked', true);
      } else {
        $('.ids_assign').prop('checked', false);
      }
      $('.ids_assign').trigger("change")
     })

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
              url: "{{route('admin.product.update.price')}}",
              type: "post",
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
            data: {
            'price': amount,
            'id' : id,
          },
          success: function(data) {
              userTable.draw();
          }
          });

      });

     $(document).on("change", '.ids_assign', function(){
      if($('.ids_assign:checked').length>0){
        $("#assign_product").removeClass("d-none");
      } else {
        $("#assign_product").addClass("d-none");
      }
     })

</script>
@endsection

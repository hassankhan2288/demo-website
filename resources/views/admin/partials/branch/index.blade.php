@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="row mb-4">
      
      <div class="col-12">
        <h2></h2>
        @if (Session::has('success'))

            <div class="alert alert-success mt-2">{{ Session::get('success') }} 
            </div>

            @endif
            @if (Session::has('error'))

            <div class="alert alert-danger mt-2">{{ Session::get('error') }} 
            </div>

            @endif
      </div>
      
      
      

       <div class="col-md-12 mb-3">

          <div class="card text-left">
            <div class="card-header">Branches</div>
              <div class="card-body">
                   <div class="table-responsive">
                      <table class="table" id="users-datatable">
                          <thead>
                              <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Company Name</th>
                                  <th scope="col">Branch Name</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Phone</th>
                                  <th scope="col">Address</th>
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
<?php // $company_id = Request::segment(4);
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
<link rel="stylesheet" href="{{ asset('app/css/plugins/sweetalert2.min.css') }}" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script type="text/javascript">

 $('#users-datatable').on("change", '.categ_sel', function(){
        //alert('ok');
        //$('.dropone').change(function() {
  //var val = $(this).val(); 

  // OR

  var val = $(this).val();
  //alert(val);
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
              url: "{{route('admin.company.branches.update')}}",
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
            "url": "{{ route('admin.company.branch.ajax.branches') }}",
            "type": "POST",
            "data": function(d){
               d._token = $('meta[name="csrf-token"]').attr('content');
               
            },
            "headers": {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
        },
        success: function (result) { 
        },
        columns: [


          {data: 'id', name: 'id'},
            {data: 'company_name', name: 'company_name'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'address', name: 'address'},
            {
                data:'action',name: 'action'
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

    $(document).on('click', '.pushDynamicsUser', function(){
        var user_id = $(this).attr('data-id');
        var circle_notch = $(this).attr('data-loading');
        $(this).html(circle_notch);
        $.ajax({
            url: "/admin/push_user/"+user_id,
            type: 'GET',
            dataType: 'json', // added data type
            success: function(res) {
                console.log(res);
                if(res){
                    swal({
                        title: "Pushed to Dynamics",
                        text: "Done",
                        icon: "success",
                        button: false,
                        timer: 3000
                    });
                    
                    location.reload();
                }else{
                    swal({
                        title: "Error Pushing in Dynamics",
                        text: "There was something wrong, please try again",
                        icon: "warning",
                        dangerMode: true,
                        button: "OK",
                    }).then((value) => {
                        location.reload();
                    });
                }
            }
        });
    });

     




    

     
     

</script>
@endsection

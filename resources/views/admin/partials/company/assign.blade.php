@extends('layouts.admin')

@section('content')
    <section id="pricing" class="pricing">

        <div class="row mb-4">
            {{-- <div class="col-md-12 mb-3">
        <div class="card text-left">
          <div class="card-header">Assign Product</div>
          <div class="card-body">
            <div class="mb-3 w-50">
              <label>Add Product</label>
              <select id="booking_id"  name="booking" class="form-control select2">
                <option value=""></option>
              </select>
            </div>

            <form  method="post" action="{{route('admin.product.assign')}}">
              @csrf
              @if (isset($company_id))
              <input type="hidden" name="id" value="{{$company_id}}">
              @endif
              <div id="append-product" ></div>
            </form>

          </div>
        </div>

      </div--> --}}

            <div class="col-md-5 mb-3">

                <div class="card text-left">
                    <div class="card-header">Products</div>
                    <div class="card-body">

                        <div class="table-responsive">
{{--                            <button class="btn btn-primary d-none" id="assign_products" data-toggle="modal"--}}
{{--                                data-target="#exampleModal">Assign Products</button>--}}
                            <button class="btn btn-primary d-none" id="assign_products" data-toggle="modal"
                                    data-target="#exampleModal">Assign Products</button>
                            <table class="table" id="users-datatable">
                                <thead>
                                    <tr>
                                        <th scope="col"><input type="checkbox" class="all-check"> Select</th>
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

            <div class="col-md-7 mb-3">
                <form action="{{ route('admin.company.product.delete') }}" method="get">
                    @csrf
                    <div class="card text-left">
                        <div class="card-header">Assigned Product</div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <button class="btn btn-primary d-none" id="assigned_products"
                                    style="display: none !important; opacity:0;">Assign Products</button>
                                <div class="row">
                                    <div class="col-md">
                                        <input type="submit" class="btn btn-primary ladda-button float-left mr-4 mb-4"
                                            value="{{ trans('file.Unassign') }}" />
                                    </div>
                                </div>
                                <table class="table" id="users-assigned">
                                    <thead>
                                        <tr>
                                            <th scope="col"><input type="checkbox" class="all-check-assigned"> Select
                                            </th>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            {{-- <th scope="col">Product Price</th> --}}
                                            <th scope="col">Single Price</th>
                                            <th scope="col">Pack Price</th>
                                            <th scope="col">Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Select Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <select class="form-select" id="categ" aria-label="Default select example" name="cate">
                            @foreach ($customer_category as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="assign_product">Assign </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php $company_id = Request::segment(4);
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

        //  $('.select2').select2({
        //   ajax: {
        //   url: "{{ route('admin.product.search') }}",
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
            lengthChange: true,
            pageLength: 10,

            "ajax": {
                "url": "{{ route('admin.company.product.ajax') }}",
                "type": "POST",
                "data": function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.user_id = "{{ $company_id }}";
                },
                "headers": {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
            },
            success: function(result) {},
            columns: [


                {
                    data: 'id',
                    "render": function(data, type, full, meta) {
                        var checkboxid = full.id;
                        return '<input type="checkbox" class="ids_assign" name="assign_company[]" value=' +
                            checkboxid + ' data-price=' + full.price + '>';
                    },
                    orderable: false
                },

                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'price',
                    name: 'price',
                    render: function(data) {
                        return "{{ currency() }}" + data;
                    }
                },

            ],

        });

        var userTable = $('#users-assigned').DataTable({
            //destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            //bFilter:false,
            lengthChange: true,
            pageLength: 10,

            "ajax": {
                "url": "{{ route('admin.company.product.ajax.assigned') }}",
                "type": "POST",
                "data": function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.user_id = "{{ $company_id }}";
                },
                "headers": {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
            },
            success: function(result) {
                //alert(result);
            },
            columns: [{
                    data: 'id',
                    render: function(data, type, full, meta) {
                        var checkboxid = full.id;
                        return '<input type="checkbox" class="ids_assigned" name="product_assigned_id[]" value="' +
                            checkboxid + '">';
                    },
                    orderable: false
                },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'product.name',
                    name: 'product.name',
                    width: 90
                },
                {
                    data: 'price',
                    name: 'price'
                },
                {
                    data: 'p_price',
                    name: 'p_price'
                },
                {
                    data: 'cate',
                    name: 'cate'
                },

            ],
        });



        $('#assign_product').click(function() {

            //var cate = $("#exampleModal input[name='cate']").find(":selected").val();
            var cate = $('#categ option:selected').val();;
            //alert(cate);
            $('#exampleModal').modal('toggle');
            var ids = [];
            $('.ids_assign:checked').each(function(i, e) {
                ids.push({
                    id: $(this).val(),
                    price: $(this).data('price')
                });
            });

            $.ajax({
                url: "{{ route('admin.product.assign') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ids: ids,
                    id: company_id,
                    cate: cate,
                },
                success: function(data) {
                    table.draw();
                    userTable.draw();
                    $('.ids_assign').prop('checked', false);
                    $('.ids_assign').trigger("change")
                }
            });




        });

        $(document).on("change", '.all-check', function() {
            if (this.checked) {
                $('.ids_assign').prop('checked', true);
            } else {
                $('.ids_assign').prop('checked', false);
            }
            $('.ids_assign').trigger("change")
        })

        $(document).on("change", '.company-price', function() {
            let total = parseFloat($(this).data("price"));
            let id = parseFloat($(this).data("id"));
            let price = parseFloat($(this).val());
            let amount = total;
            if (total < price) {
                $(this).val(price);
                amount = price;
            } else {
                $(this).val(total);
            }

            $.ajax({
                url: "{{ route('admin.product.update.price') }}",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'price': amount,
                    'id': id,
                },
                success: function(data) {
                    //userTable.draw();
                }
            });

        });

        $(document).on('click', '#assigned_products', function() {
            var ids_assigned = $(this).data("ids_assigned");

            $.ajax({
                url: "{{ route('admin.company.product.delete') }}",
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ids: ids,
                    id: company_id,
                    // cate: cate,
                },
                success: function(data) {
                    table.draw();
                    userTable.draw();
                    $('.ids_assigned').prop('checked', false);
                    $('.ids_assigned').trigger("change")
                }
            });


        });

        $(document).on("change", '.all-check-assigned', function() {
            if (this.checked) {
                $('.ids_assigned').prop('checked', true);
            } else {
                $('.ids_assigned').prop('checked', false);
            }
            $('.ids_assigned').trigger("change")
        })


        $(document).on("change", '.sale-price', function() {
            let total = parseFloat($(this).data("price"));
            let id = parseFloat($(this).data("id"));
            let price = parseFloat($(this).val());
            let amount = total;
            if (total < price) {
                $(this).val(price);
                amount = price;
            } else {
                $(this).val(total);
            }

            $.ajax({
                url: "{{ route('admin.product.update.price.branch') }}",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'price_b': amount,
                    'id': id,
                },
                success: function(data) {
                    //userTable.draw();
                }
            });

        });


        $('#users-assigned').on("change", '.categ_sel', function() {
            //alert('ok');
            //$('.dropone').change(function() {
            //var val = $(this).val();

            // OR

            var val = this.value;

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
                url: "{{ route('admin.product.update.cate') }}",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'cate': val,
                    'id': id,
                },
                success: function(data) {
                    //userTable.draw();
                }
            });

        });

        $(document).on("change", '.ids_assign', function() {
            if ($('.ids_assign:checked').length > 0) {
                $("#assign_products").removeClass("d-none");
            } else {
                $("#assign_products").addClass("d-none");
            }
        });

        $(document).on("change", '.ids_assigned', function() {
            if ($('.ids_assigned:checked').length > 0) {
                $("#assigned_products").removeClass("d-none");
            } else {
                $("#assigned_products").addClass("d-none");
            }
        });
    </script>
@endsection

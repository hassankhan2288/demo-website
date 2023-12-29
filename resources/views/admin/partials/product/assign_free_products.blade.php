@extends('layouts.admin')

@section('content')
    <section id="pricing" class="pricing">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{ $lims_product_data->name }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="col-md-12 ">
            <div class="d-flex mb-5">
                <div class="card col-md-12  mr-4 p-0">

                    <form action="{{ route('admin.free.product.assigned') }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $lims_product_data->id }}" name="id">
                        <br>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> <strong>Quantity*</strong> </label>
                                <input type="number" name="quantity" class="form-control" id="quantity" aria-describedby="quantity"  placeholder="Enter Quantity" required>
                                <span class="invalid-feedback" id="quantity-error"></span>
                            </div>
                        </div>
                        <br>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <input type="hidden" name="user_id" value="" />

                                <div class="card text-left">
                                    <div class="card-header">{{ trans('file.Product') }}</div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <button class="btn btn-primary d-none" id="assign_products">
                                                Assign Products</button>
                                            <table class="table" id="users-datatable">
                                                <thead>
                                                <tr>
                                                    <th scope="col"><input type="checkbox" class="all-check">
                                                        {{ trans('file.Select') }}</th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">{{ trans('file.Price') }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
{{--                                            <div class="row">--}}
{{--                                                <div class="col-md">--}}
{{--                                                    <input type="submit"--}}
{{--                                                           class="btn btn-primary ladda-button float-left mr-4 mb-4"--}}
{{--                                                           value="{{ trans('file.Assign') }}" />--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('admin.free.product.unassigned') }}" method="get">
                        @csrf
                        <input type="hidden" value="{{ $lims_product_data->id }}" name="id">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="card text-left">
                                    <div class="card-header">{{ trans('file.Free Products') }}</div>
                                    <div class="card-body">

                                        <div class="table-responsive">
                                            <div class="row">
                                                <div class="col-md">
                                                    <input type="submit"
                                                           class="btn btn-primary ladda-button float-left mr-4 mb-4"
                                                           value="{{ trans('file.Unassign') }}" />
                                                </div>
                                            </div>
                                            <table class="table" id="users-assigned">
                                                <thead>
                                                <tr>
                                                    <th scope="col"><input type="checkbox" class="all-check-variant">
                                                        {{ trans('file.Select') }}</th>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Assigned Product Name</th>
                                                    <th scope="col">{{ trans('file.Price') }}</th>
                                                    <th scope="col">Quantity</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
{{--                                            <div class="row">--}}
{{--                                                <div class="col-md">--}}
{{--                                                    <input type="submit"--}}
{{--                                                           class="btn btn-primary ladda-button float-left mr-4 mb-4"--}}
{{--                                                           value="{{ trans('file.Unassign') }}" />--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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

        $('.select2').select2({
            ajax: {
                url: "{{ route('admin.product.search') }}",
                data: function(params) {
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
            html += '<input type="hidden" name="product_id" value="' + product.id + '" />';
            html += '<table class="table">';
            html += '<thead>';
            html += '<tr>';
            html += '<th scope="col">Name</th>';
            html += '';
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';
            html += '<tr>';
            html += '<td>' + product.name + '</td>';
            html += '<td><input type="text" name="price" value="' + product.price +
                '" class="form-control w-50" required /></td>';
            html += '</tr>';
            html += '</tbody>';
            html += '</table>';
            html += '<div class="col-md">';
            html +=
                '<input type="submit" class="btn btn-primary ladda-button float-left mr-4 mb-4" value="Assign" />';
            html += '</div>';
            $("#append-product").html(html);
        });

        {{--var product_id = "{{ $lims_product_data->id }}";--}}
        var table = $('#users-datatable').DataTable({
            //destroy: true,
            processing: true,
            serverSide: true,
            responsive: true,
            //bFilter:false,
            lengthChange: true,
            pageLength: 10,

            "ajax": {
                {{--"url": "{{ route('admin.variant.product.ajax') }}",--}}
                "url": "{{ route('admin.assign.free.product.ajax', ['product_id' => '+product_id+']) }}",
                "type": "POST",
                "data": function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.user_id = "{{ $company_id }}";
                    d.product_id = "{{ $lims_product_data->id }}";

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
                        return '<input type="checkbox" class="ids_assign" name="assign_variant[]" value=' +
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
                "url": "{{ route('admin.free.product.ajax.assigned') }}",
                "type": "POST",
                "data": function(d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                    d.product_id = "{{ $lims_product_data->id }}";
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
                "render": function(data, type, full, meta) {
                    var checkboxid = full.id;
                    return '<input type="checkbox" class="ids_assign_variant" name="assigned_variant[]" value=' +
                        checkboxid + ' data-price=' + full.price + '>';
                },
                orderable: false
            },

                {
                    data: 'DT_RowIndex',
                    name: 'product_id',
                    orderable: false
                },
                {
                    data: 'product.name',
                    name: 'product.name',
                },

                // {
                //     data: 'product.price',
                //     name: 'product.price',
                //     width: 90
                // },
                {
                    data: 'product.price',
                    name: 'product.price',
                    render: function(data) {
                        return "{{ currency() }}" + data;
                    }
                },
                {
                    data: 'quantity',
                    name: 'quantity',
                    // width: 90
                },

            ],
        });

        $(document).on('click', '#assign_products', function() {
            var ids_assign = $(this).data("ids_assign");

            $.ajax({
                {{--url: "{{ route('admin.variant.product.ajax.assigned') }}",--}}
                type: "post",
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    ids: id,
                    // id: company_id,
                    // cate: cate,
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

        $(document).on("change", '.all-check-variant', function() {
            if (this.checked) {
                $('.ids_assign_variant').prop('checked', true);
            } else {
                $('.ids_assign_variant').prop('checked', false);
            }
            $('.ids_assign_variant').trigger("change")
        })


        $(document).on("change", '.ids_assign', function() {
            if ($('.ids_assign:checked').length > 0) {
                $("#assign_products").removeClass("d-none");
            } else {
                $("#assign_products").addClass("d-none");
            }
        });
    </script>
@endsection

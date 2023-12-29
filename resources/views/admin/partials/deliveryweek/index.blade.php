@extends('layouts.admin')

@section('content')
    @if (session()->has('message'))
    <?php die('0'); ?>
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close"
                data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}
        </div>

    @endif
    @if (session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert"
                aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}
        </div>
    @endif


    <!-- DataTales Example -->
    <div class="card shadow mb-4" style="    width: 96%;
 margin-left: 2%;">
        <div class="row">
            <div class="col-md-12">
                {{-- @include('backend.layouts.notification') --}}
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Deleviery Shedule List</h6>
            <a href="{{ url('admin/deliveryroute/create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Delivery Days</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($data) > 0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Day Name</th>
                                <th>Warehouse Name</th>
                                <th>Limit Orders</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- <tfoot>
                            <tr>
                                <th>S.N.</th>
                                <th>Product Name</th>
                                <th>Warehouse Name</th>
                                <th>Stock</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot> --}}
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                       @switch($item->delivery_day)
                                        @case(1)
                                            Monday
                                            @break

                                        @case(2)
                                            Tuesday
                                            @break

                                        @case(3)
                                          Wednesday
                                            @break
                                          
                                            @case(4)
                                            Thursday
                                              @break
                                        @case(5)
                                            Friday
                                              @break
                                        @case(6)
                                            Staturday
                                          @break
                                         @case(7)
                                            Sunday
                                                  @break
        
                                        @default
                                            <p>day unknown.</p>
                                    @endswitch
                                  </td>
                                    <td>{{ $item->warehouse->name }}</td>
                                    <td>{{ $item->limit_orders }}</td>
                                    <td>
                                        @if ($item->is_active == '1')
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('deliveryroute.edit', $item->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="GET" action="{{ route('deliveryroute.delete', [$item->id]) }}">
                                            @csrf
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $item->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                  
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $data->links() }}</span>
                @else
                    <h6 class="text-center">No days found!!! Please create delivery days</h6>
                @endif
            </div>
        </div>
    </div>

@endsection
@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#banner-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [3, 4, 5]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            })
        })
    </script>
@endpush

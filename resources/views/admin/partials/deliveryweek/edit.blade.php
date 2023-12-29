@extends('layouts.admin') @section('content')
    <section class="forms">

        <div class="card" style="    width: 96%;
margin-left: 2%;">
            <h5 class="card-header">Edit Delivery Setting</h5>
            <div class="card-body">
                <form method="post" action="{{ route('deliveryroute.update', $Delivery[0]['id']) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="inputTitle" class="col-form-label">Day Name <span class="text-danger">*</span></label>
              
                      <select class="form-control" id="delivery_day" name="delivery_day">
                          @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                              <option value="{{ $loop->index + 1 }}" {{ $Delivery[0]['delivery_day'] == ($loop->index + 1) ? 'selected' : '' }}>
                                  {{ $day }}
                              </option>
                          @endforeach
                      </select>
                      @error('delivery_day')
                          <span class="text-danger">{{ $message }}</span>
                      @enderror
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Warehouse Name <span
                                class="text-danger">*</span></label>

                        <select class="form-control warehouse" id="warehouse-id" name="warehouse_id">
                            <option value="{{ $Delivery[0]['warehouse_id'] }}">{{ $Delivery[0]['warehouse']['name'] }}
                            </option>

                        </select>
                        @error('warehouse_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Limit Orders <span
                                class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="limit_orders" placeholder="Enter Number"
                            value="{{ $Delivery[0]['limit_orders'] }}" class="form-control">
                        @error('limit_orders')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                        <select name="is_active" class="form-control">
                            <option value="1" {{ $Delivery[0]['is_active'] == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $Delivery[0]['is_active'] == '0' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('is_active')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @section('styles')
        <link href="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="{{ asset('vendor/daterange/css/daterangepicker.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('app/css/plugins/datatables.min.css') }}" />
    @endsection
    @section('scripts')
        <script type="text/javascript" src="{{ asset('vendor/daterange/js/moment.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/daterange/js/knockout-3.4.2.js') }}"></script>
        <script type="text/javascript" src="{{ asset('vendor/daterange/js/daterangepicker.min.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('app/js/plugins/datatables.min.js') }}"></script>
        <script type="text/javascript">
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
            $('.product').select2({
                ajax: {
                    url: "{{ route('admin.stock.search.product') }}",
                    data: function(params) {
                        var query = {
                            search: params.term,
                        }
                        return query;
                    }
                }
            });
            $('#lfm').filemanager('image');

            $(document).ready(function() {
                $('#description').summernote({
                    placeholder: "Write short description.....",
                    tabsize: 2,
                    height: 150
                });
            });
        </script>
    @endsection

@extends('layouts.admin') @section('content')
<section class="forms">
<div class="card"  style="    width: 96%;
margin-left: 2%;">
    <h5 class="card-header">Add Delivery Day</h5>
    <div class="card-body">
      <form method="post" action="{{route('deliveryroute.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Delivery Day <span class="text-danger">*</span></label>
        
           {{-- all the day represent as a digigt example 6 is the numeric representation of Saturday --}}
        <select class="form-control product" id="delivery_day" name="delivery_day">
          <option value="1">Monday</option>
          <option value="2">Tuesday</option>
          <option value="3">Wednesday</option>
          <option value="4">Thursday</option>
          <option value="5">Friday</option>
          <option value="6">Saturday</option>
          <option value="7">Sunday</option>
              {{-- <option value="0">Select</option> --}}
              
            </select>

           
        @error('delivery_day')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Warehouse <span class="text-danger">*</span></label>
        
        <select class="form-control warehouse" id="warehouse-id" name="warehouse_id">
              {{-- <option value="0">Select</option> --}}
              
            </select>

           
        @error('warehouse_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Order Limit <span class="text-danger">*</span></label>
        <input id="inputTitle" type="numeric" name="limit_orders" placeholder="Enter Number"  value="{{old('limit_orders')}}" class="form-control">
        @error('stocks')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="is_active" class="form-control">
              <option value="1">Active</option>
              <option value="0">Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

</section>

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
    url: "{{route('admin.stock.search.warehouse')}}",
    data: function (params) {
      var query = {
        search: params.term,
      }
      return query;
    }
  }
  });
  // $('.product').select2({
  //           ajax: {
  //           url: "{{route('admin.stock.search.product')}}",
  //           data: function (params) {
  //           var query = {
  //             search: params.term,
  //           }
  //           return query;
  //           }
  //           }
  //           });

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

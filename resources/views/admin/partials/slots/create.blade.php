@extends('layouts.admin') @section('content')
<section class="forms">
<div class="card"  style="    width: 96%;
margin-left: 2%;">
    <h5 class="card-header">Add Slot</h5>
    <div class="card-body">
      <form method="post" action="{{route('slots.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Slot Name <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter Name"  value="{{old('name')}}" class="form-control">
        {{-- <select class="form-control product" id="product-id" name="product_id">
              {{-- <option value="0">Select</option> -}}
              
            </select> --}}

           
        @error('name')
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
          <label for="inputTitle" class="col-form-label">Start Day <span class="text-danger">*</span></label>

            <select class="form-control start_day" id="start_day" name="start_day" required>
              <option value="">Select Start Day</option>
              <option value="1">Monday</option>
              <option value="2">Tuesday</option>
              <option value="3">Wednesday</option>
              <option value="4">Thursday</option>
              <option value="5">Friday</option>
              <option value="6">Saturday</option>
              <option value="7">Sunday</option>
            </select>
        
            @error('start_day')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Start Day <span class="text-danger">*</span></label>

            <select class="form-control end_day" id="end_day" name="end_day" required>
              <option value="">Select End Day</option>
              <option value="1">Monday</option>
              <option value="2">Tuesday</option>
              <option value="3">Wednesday</option>
              <option value="4">Thursday</option>
              <option value="5">Friday</option>
              <option value="6">Saturday</option>
              <option value="7">Sunday</option>
            </select>
        
            @error('end_day')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Start Time <span class="text-danger">*</span></label>
        <select class="form-control "  name="start_time">
              <option value="01:00">01:00</option>
              <option value="01:30">01:30</option>
              <option value="02:00">02:00</option>
              <option value="02:30">02:30</option>
              <option value="03:00">03:00</option>
              <option value="03:30">03:30</option>
              <option value="04:00">04:00</option>
              <option value="04:30">04:30</option>
              <option value="05:00">05:00</option>
              <option value="05:30">05:30</option>
              <option value="06:00">06:00</option>
              <option value="06:30">06:30</option>
              <option value="07:00">07:00</option>
              <option value="07:30">07:30</option>
              <option value="08:00">08:00</option>
              <option value="08:30">08:30</option>
              <option value="09:00">09:00</option>
              <option value="09:30">09:30</option>
              <option value="10:00">10:00</option>
              <option value="10:30">10:30</option>
              <option value="11:00">11:00</option>
              <option value="11:30">11:30</option>
              <option value="12:00">12:00</option>
              <option value="12:30">12:30</option>
              <option value="13:00">13:00</option>
              <option value="13:30">13:30</option>
              <option value="14:00">14:00</option>
              <option value="14:30">14:30</option>
              <option value="15:00">15:00</option>
              <option value="15:30">15:30</option>
              <option value="16:00">16:00</option>
              <option value="16:30">16:30</option>
              <option value="17:00">17:00</option>
              <option value="17:30">17:30</option>
              <option value="18:00">18:00</option>
              <option value="18:30">18:30</option>
              <option value="19:00">19:00</option>
              <option value="19:30">19:30</option>
              <option value="20:00">20:00</option>
              <option value="20:30">20:30</option>
              <option value="21:00">21:00</option>
              <option value="21:30">21:30</option>
              <option value="22:00">22:00</option>
              <option value="23:30">23:30</option>
              <option value="23:00">23:00</option>
              <option value="23:30">23:30</option>
              <option value="24:00">24:00</option>
              
            </select>
        @error('start_time')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Duration <span class="text-danger">*</span></label>
        <select class="form-control "  name="duration">
              <option value="10 minutes">10 minutes</option>
              <option value="15 minutes">15 minutes</option>
              <option value="30 minutes">30 minutes</option>
              <option value="45 minutes">45 minutes</option>
              <option value="60 minutes">60 minutes</option>
              
              
            </select>
        @error('duration')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">End Time <span class="text-danger">*</span></label>
        <select class="form-control "  name="end_time">
          <option value="01:00">01:00</option>
          <option value="01:30">01:30</option>
          <option value="02:00">02:00</option>
          <option value="02:30">02:30</option>
          <option value="03:00">03:00</option>
          <option value="03:30">03:30</option>
          <option value="04:00">04:00</option>
          <option value="04:30">04:30</option>
          <option value="05:00">05:00</option>
          <option value="05:30">05:30</option>
          <option value="06:00">06:00</option>
          <option value="06:30">06:30</option>
          <option value="07:00">07:00</option>
          <option value="07:30">07:30</option>
          <option value="08:00">08:00</option>
          <option value="08:30">08:30</option>
          <option value="09:00">09:00</option>
          <option value="09:30">09:30</option>
          <option value="10:00">10:00</option>
          <option value="10:30">10:30</option>
          <option value="11:00">11:00</option>
          <option value="11:30">11:30</option>
          <option value="12:00">12:00</option>
          <option value="12:30">12:30</option>
          <option value="13:00">13:00</option>
          <option value="13:30">13:30</option>
          <option value="14:00">14:00</option>
          <option value="14:30">14:30</option>
          <option value="15:00">15:00</option>
          <option value="15:30">15:30</option>
          <option value="16:00">16:00</option>
          <option value="16:30">16:30</option>
          <option value="17:00">17:00</option>
          <option value="17:30">17:30</option>
          <option value="18:00">18:00</option>
          <option value="18:30">18:30</option>
          <option value="19:00">19:00</option>
          <option value="19:30">19:30</option>
          <option value="20:00">20:00</option>
          <option value="20:30">20:30</option>
          <option value="21:00">21:00</option>
          <option value="21:30">21:30</option>
          <option value="22:00">22:00</option>
          <option value="23:30">23:30</option>
          <option value="23:00">23:00</option>
          <option value="23:30">23:30</option>
          <option value="24:00">24:00</option>
              
            </select>
        @error('end_time')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="per_slot_order" class="col-form-label">Per Slot Order <span class="text-danger">*</span></label>
          <input type="number" name="per_slot_order" value="{{old('per_slot_order')}}" class="form-control"/>
          @error('per_slot_order')
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
  $('.product').select2({
    ajax: {
      url: "{{route('admin.stock.search.product')}}",
      data: function (params) {
        var query = {
          search: params.term,
        }
        return query;
      }
    }
  });

  // $('select').select2();


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

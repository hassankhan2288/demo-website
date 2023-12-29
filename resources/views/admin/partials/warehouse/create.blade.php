@extends('layouts.admin') @section('content')
<section class="forms">
<div class="card"  style="    width: 96%;
margin-left: 2%;">
    <h5 class="card-header">Add Warehouse</h5>
    <div class="card-body">
      <form method="post" action="{{route('warehouse.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter title"  value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Number <span class="text-danger">*</span></label>
        <input id="inputTitle" type="number" name="phone" placeholder="Enter Number"  value="{{old('phone')}}" class="form-control">
        @error('phone')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Email <span class="text-danger">*</span></label>
        <input id="inputTitle" type="email" name="email" placeholder="Enter email"  value="{{old('email')}}" class="form-control">
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Address</label>
          <textarea class="form-control" id="address" name="address">{{old('address')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="delivery_charges" class="col-form-label">Delivery Charges</label>
          <input type="number" class="form-control" id="delivery_charges" name="delivery_charges" step="0.01" value="" />
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="amount_over" class="col-form-label">Price Over Amount</label>
          <input type="number" class="form-control" id="amount_over" name="amount_over" step="0.01" value="{{$warehouse->amount_over}}" />
          @error('amount_over')
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

@push('styles')
{{-- <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}"> --}}
@endpush
@push('scripts')
{{-- <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script> --}}
{{-- <script src="{{asset('backend/summernote/summernote.min.js')}}"></script> --}}
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush

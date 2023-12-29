@extends('layouts.admin') @section('content')
<section class="forms">

<div class="card" style="    width: 96%;
margin-left: 2%;">
    <h5 class="card-header">Edit Warehouse</h5>
    <div class="card-body">
      <form method="POST" action="{{route('warehouse.update',$warehouse->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$warehouse->title}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Number <span class="text-danger">*</span></label>
        <input id="inputTitle" type="number" name="phone" placeholder="Enter number"  value="{{$warehouse->phone}}" class="form-control">
        @error('phone')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Email <span class="text-danger">*</span></label>
        <input id="inputTitle" type="email" readonly name="email" placeholder="Enter email"  value="{{$warehouse->email}}" class="form-control">
        @error('email')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Address</label>
          <textarea class="form-control" id="address" name="address">{{$warehouse->address}}</textarea>
          @error('address')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="delivery_chargs" class="col-form-label">Delivery Charges</label>
          <input type="number" class="form-control" id="delivery_charges" name="delivery_charges" step="0.01" value="{{$warehouse->delivery_charges}}" />
          @error('delivery_chargs')
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
          <label for="amount_over" class="col-form-label">Post Codes (Delivery Routes)</label>
          <textarea name="postcodes" class="form-control">{{$warehouse->postcodes}}</textarea>
          
          @error('postcodes')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        {{-- <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
            <img src="{{ asset('banners/'.$banner->photo) }}" class="img-fluid zoom" style="max-width:200px"
                                                alt="{{ $banner->photo }}">
            <input type="file" name="photo" class="form-control" >
            <input type="hidden" name="old_photo" value="{{ $banner->photo }}" class="form-control" >
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="is_active" class="form-control">
            <option value="1" {{(($warehouse->is_active=='1') ? 'selected' : '')}}>Active</option>
            <option value="0" {{(($warehouse->is_active=='0') ? 'selected' : '')}}>Inactive</option>
          </select>
          @error('is_active')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
    </div>
</div>

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

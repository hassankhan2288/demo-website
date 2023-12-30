@extends('layouts.admin') @section('content')
<section class="forms">
<div class="card"  style="    width: 96%;
margin-left: 2%;">
    <h5 class="card-header">Add Banner</h5>
    <div class="card-body">
      <form method="post" action="{{route('banner.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{old('title')}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputLink" class="col-form-label">Link</label>
          <input class="form-control required" id="link" name="link" value="{{old('link')}}" />
          @error('link')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Type</label>
          <select class="form-control" id="type" name="type">
            <option value="">Select Type</option>
            <option value="website">Website</option>
            <option value="mobile">Mobile</option>
          </select>
          @error('type')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
            {{-- <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span> --}}
          {{-- <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}"> --}}
          <input type="file" name="photo" class="form-control" >
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
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

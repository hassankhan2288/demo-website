@extends('layouts.admin') @section('content')
<section class="forms">

<div class="card" style="    width: 96%;
margin-left: 2%;">
    <h5 class="card-header">Edit leave</h5>
    <div class="card-body">
      <form method="post" action="{{route('leaves.update',$leaves[0]['id'])}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name <span class="text-danger">*</span></label>
        
        <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$leaves[0]['name']}}" class="form-control">

           
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Date <span class="text-danger">*</span></label>
        
        <input id="inputTitle" type="date" name="date"   value="{{$leaves[0]['date']}}" class="form-control">

           
        @error('date')
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
          <label for="status" class="col-form-label">Warehouse <span class="text-danger">*</span></label>
          <select name="warehouse_id" class="form-control">
            @foreach ($warehouses as $warehouse)  
              <option @if ($leaves[0]->warehouse->id == $warehouse->id) selected   @endif value="{{$warehouse->id  }}">{{$warehouse->name  }}</option>
            @endforeach
        </select>
        @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="is_active" class="form-control">
            <option value="1" {{(($leaves[0]['is_active']=='1') ? 'selected' : '')}}>Active</option>
            <option value="0" {{(($leaves[0]['is_active']=='0') ? 'selected' : '')}}>Inactive</option>
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

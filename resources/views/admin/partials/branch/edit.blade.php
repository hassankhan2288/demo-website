@extends('layouts.admin') @section('content')
<section class="forms">

<div class="card" style="    width: 96%;
margin-left: 2%;">
    <h5 class="card-header">Edit Stock</h5>
    <div class="card-body">
      <form method="post" action="{{route('stock.update',$stock[0]['id'])}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Product <span class="text-danger">*</span></label>
        
        <select class="form-control product" id="product-id" name="product_id">
               <option value="{{ $stock[0]['product_id'] }}" selected>{{ $stock[0]['product']['name'] }}</option> 
              
            </select>

           
        @error('product_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Warehouse <span class="text-danger">*</span></label>
        
        <select class="form-control warehouse" id="warehouse-id" name="warehouse_id">
              <option value="{{  $stock[0]['warehouse_id']  }}">{{ $stock[0]['warehouse']['name'] }}</option>
              
            </select>

           
        @error('warehouse_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Stock <span class="text-danger">*</span></label>
        <input id="inputTitle" type="stocks" name="stocks" placeholder="Enter Number"  value="{{$stock[0]['stocks']}}" class="form-control">
        @error('stocks')
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
            <option value="1" {{(($stock[0]['is_active']=='1') ? 'selected' : '')}}>Active</option>
            <option value="0" {{(($stock[0]['is_active']=='0') ? 'selected' : '')}}>Inactive</option>
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

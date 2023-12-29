@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.product_price.submit')}}">
              @csrf
              @if(isset($product_price->id))
              <input type="hidden" name="id" value="{{$product_price->id}}">
              @endif
              <div class="card-body">
                <div class="card-title">Product Price Table</div>

                <div class="form-group">
                    <label for="product_ms_id">{{ __('Code') }}</label>
                    <input id="product_ms_id" type="text" class="form-control @error('product_ms_id') is-invalid @enderror" name="product_ms_id" value="{{old("product_ms_id")??$product_price->product_ms_id??""}}" required >

                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="warehouse_id">Warehouse</label>
                    <select id="warehouse_id" class="form-control @error('warehouse_id') is-invalid @enderror" name="warehouse_id" required>
                        <option value="">Select Warehouse</option>
                        @foreach($warehouses as $warehouse)
                            <option value="{{ $warehouse->id }}" @if(old('warehouse_id') == $warehouse->id || (isset($product_price) && $product_price->warehouse_id == $warehouse->id)) selected @endif>{{ $warehouse->title }}</option>
                        @endforeach
                    </select>
                
                    @error('warehouse_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="price">Singal Price</label>
                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old("price")??$product_price->price??""}}" required >

                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="p_price">Pack Price</label>
                    <input id="p_price" type="text" class="form-control @error('p_price') is-invalid @enderror" name="p_price" value="{{old("price")??$product_price->p_price??""}}" required >

                    @error('p_price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="delivery_single">Single Delivery</label>
                    <input id="delivery_single" type="text" class="form-control @error('delivery_single') is-invalid @enderror" name="delivery_single" value="{{old("delivery_single")??$product_price->delivery_single??""}}" required >

                    @error('delivery_single')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="delivery_pack">Pack Delivery</label>
                    <input id="delivery_pack" type="text" class="form-control @error('delivery_pack') is-invalid @enderror" name="delivery_pack" value="{{old("delivery_pack")??$product_price->delivery_pack??""}}" required >

                    @error('delivery_pack')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


    
              <div class="row">
                <div class="col-md">
                    <input type="submit" class="btn btn-primary ladda-button float-right mr-4 mb-4" value="Submit" />
                </div>
              </div>
            </form>

          </div>

      </div>
    </div>

</section>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('app/css/plugins/ladda-themeless.min.css') }}" />
@endsection

@section('scripts')
<script src="{{ asset('app/js/plugins/spin.min.js') }}"></script>
<script src="{{ asset('app/js/plugins/ladda.min.js') }}"></script>
@endsection

@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.company_pricing.submit')}}">
              @csrf
              @if(isset($product_price->id))
              <input type="hidden" name="id" value="{{$product_price->id}}">
              @endif
              <div class="card-body">
                <div class="card-title">Company Pricing Table</div>
                <div class="form-group">
                    <label for="product_id">Product Name</label>
                    <select id="product_id" class="form-control @error('product_id') is-invalid @enderror" name="product_id" required>
                        <option value="">Select Product Name</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" @if(old('product_id') == $product->id || (isset($product_price) && $product_price->product_id == $product->id)) selected @endif>{{ $product->name }}</option>
                        @endforeach
                    </select>
                
                    @error('Product Name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="user_id">Company Name</label>
                    <select id="user_id" class="form-control @error('user_id') is-invalid @enderror" name="user_id" required>
                        <option value="">Select Company Name</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if(old('user_id') == $user->id || (isset($product_price) && $product_price->user_id == $user->id)) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                
                    @error('Company Name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="product_ms_id">Product Code</label>
                    <input id="product_ms_id" type="text" class="form-control @error('product_ms_id') is-invalid @enderror" name="product_ms_id" value="{{old("product_ms_id")??$product_price->product_ms_id??""}}" required >

                    @error('Product Code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="price">Singal Price</label>
                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{old("price")??$product_price->price??""}}" >

                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="p_price">Pack Price</label>
                    <input id="p_price" type="text" class="form-control @error('p_price') is-invalid @enderror" name="p_price" value="{{old("price")??$product_price->p_price??""}}" >

                    @error('p_price')
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

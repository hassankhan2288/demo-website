@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.search_term.submit')}}">
              @csrf
              @if(isset($term->id))
              <input type="hidden" name="id" value="{{$term->id}}">
              @endif
              <div class="card-body">
                <div class="card-title">Search Terms</div>
                <div class="form-group">
                    <label for="terms">Terms</label>
                    <input id="terms" type="text" class="form-control @error('terms') is-invalid @enderror" name="terms" value="{{old("terms")??$term->terms??""}}" required >

                    @error('terms')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- <div class="form-group">
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
                </div> --}}

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

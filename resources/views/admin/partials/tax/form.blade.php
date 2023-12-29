@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.tax.submit')}}">
              @csrf
              @if(isset($tax->id))
              <input type="hidden" name="id" value="{{$tax->id}}">
              @endif
              <div class="card-body">
                <div class="card-title">Tax</div>

                <div class="form-group">
                    <label for="name">{{ __('Name') }}</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old("name")??$tax->name??""}}" required autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="rate">{{ __('Rate %') }}</label>
                    <input id="rate" type="number" class="form-control @error('rate') is-invalid @enderror" name="rate" value="{{old("rate")??$tax->rate??""}}" required >

                    @error('rate')
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

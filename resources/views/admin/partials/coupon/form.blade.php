@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.coupon.submit')}}">
              @csrf
              @if(isset($coupon->id))
              <input type="hidden" name="id" value="{{$coupon->id}}">
              @endif
              <div class="card-body">
                <div class="card-title">Coupon</div>

                <div class="form-group">
                    <label for="code">{{ __('Code') }}</label>
                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{old("code")??$coupon->code??""}}" required >

                    @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type">{{ __('Type') }}</label>
                    <select name="type" class="form-control">
                        <option value="percentage" @if((old("type")??$coupon->type??"")=="percentage") selected @endif >Percentage</option>
                        <option value="fixed" @if((old("type")??$coupon->type??"")=="fixed") selected @endif >Fixed</option>
                    </select>

                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">{{ __('Amount') }}</label>
                    <input id="amount" type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{old("amount")??$coupon->amount??""}}" required >

                    @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="quantity">{{ __('Qty') }}</label>
                    <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" value="{{old("quantity")??$coupon->quantity??""}}" required >

                    @error('quantity')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="expired_date">{{ __('Expired Date') }}</label>
                    <input id="expired_date" type="date" class="form-control @error('expired_date') is-invalid @enderror" name="expired_date" value="{{old("expired_date")??$coupon->expired_date??""}}" required >

                    @error('expired_date')
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

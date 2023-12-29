@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.sub.submit')}}">
              @csrf

              <div class="card-body">
                <div class="card-title">Microsoft Dynamic Settings</div>

                <div class="form-group">
                    <label for="access_token">{{ __('MS Campany') }}</label>
                    <select class="form-control">
                        <option value="">Select Company</option>
                        @if($companies)
                        @foreach($companies as $company)
                        <option value="{{$company->id}}">{{$company->name}}  -|- {{$company->displayName}} -|- {{$company->businessProfileId}} </option>
                        @endforeach
                        @endif
                    </select>


                    @error('access_token')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <p>{{$setting['access_token']??""}}</p>

                
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

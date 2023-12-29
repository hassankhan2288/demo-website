@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.service.submit')}}">
              @csrf
              @if(isset($service->id))
              <input type="hidden" name="id" value="{{$service->id}}">
              @endif
              <div class="card-body">
                  <div class="card-title">Service</div>
                  <div class="mb-3">
                      <label>Service name</label>
                      <input class="form-control" name="name" value="{{old("name")??$service->service_name??""}}" type="text" placeholder="name" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Category</label>
                      <select  name="vehicle_type_id" class="form-control">
                        @if($categories)
                        @foreach($categories as $key=>$value)
                        <option @if((old("vehicle_type_id")??$service->vehicle_type_id??"")==$key) selected @endif value="{{$key}}">{{$value}}</option>
                        @endforeach
                        @endif
                      </select>
                  </div>
                  <div class="row">
                    <div class="col-sm-12">
                     <label>Time Duration</label>
                   </div>
                    <div class="col-sm-6">
                      <div class="mb-3">
                          <label>Duration</label>
                          <input class="form-control" name="duration" value="{{old("duration")??$service->time_number??""}}" type="number" placeholder="number" aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                  </div>
                  <div class="col-sm-6">
                      <div class="mb-3">
                          <label>Unit</label>
                          <select  name="unit" class="form-control">
                            <option @if((old("unit")??$service->time_unit??"")=="weeks") selected @endif  value="weeks">Weeks</option>
                            <option @if((old("unit")??$service->time_unit??"")=="months") selected @endif  value="months">Months</option>
                            <option @if((old("unit")??$service->time_unit??"")=="years") selected @endif  value="years">Years</option>
                          </select>
                      </div>
                  </div>
                </div>

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

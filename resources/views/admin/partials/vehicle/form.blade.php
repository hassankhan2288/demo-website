@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.vehicle.submit')}}"  enctype="multipart/form-data">
              @csrf
              @if(isset($vehicle->id))
              <input type="hidden" name="id" value="{{$vehicle->id}}">
              @endif
              <div class="card-body">
                  <div class="card-title">Vehicle</div>
                  <div class="mb-3">
                      <label>Vehicle name</label>
                      <input class="form-control" name="name" value="{{old("name")??$vehicle->name??""}}" type="text" placeholder="name" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>VIN</label>
                      <input class="form-control" name="vin" value="{{old("name")??$vehicle->vin??""}}" type="text" placeholder="vin" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Axle</label>
                      <input class="form-control" name="axle" value="{{old("name")??$vehicle->axle??""}}" type="text" placeholder="Axle" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Tires</label>
                      <input class="form-control" name="tires" value="{{old("tires")??$vehicle->tires??""}}" type="text" placeholder="Tires" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Model</label>
                      <input class="form-control" name="model" value="{{old("model")??$vehicle->model??""}}" type="text" placeholder="model" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Number Plate</label>
                      <input class="form-control" name="number_plate" value="{{old("number_plate")??$vehicle->number_plate??""}}" type="text" placeholder="Number" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Registration</label>
                      <input class="form-control" name="registration" value="{{old("registration")??$vehicle->registration??""}}" type="text" placeholder="registration" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Vehicle Registration</label>
                      <input class="form-control" name="registration_date" value="{{old("registration_date")??$vehicle->registration_date??""}}" type="text" placeholder="vehicle registration" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>First Registration</label>
                      <input class="form-control" name="first_registration_date" value="{{old("first_registration_date")??$vehicle->first_registration_date??""}}" type="text" placeholder="first registration date" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Warranty up until</label>
                      <input class="form-control" name="warranty" value="{{old("warranty")??$vehicle->warranty??""}}" type="text" placeholder="Warranty" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Owner Name</label>
                      <input class="form-control" name="owner_name" value="{{old("owner_name")??$vehicle->owner_name??""}}" type="text" placeholder="owner name" aria-label="Username" aria-describedby="basic-addon1">
                  </div>

                  <div class="mb-3">
                      <label>Owner Contact Number</label>
                      <input class="form-control" name="owner_contact_number" value="{{old("owner_contact_number")??$vehicle->owner_contact_number??""}}" type="text" placeholder="owner contact" aria-label="Username" aria-describedby="basic-addon1">
                  </div>


                  <div class="mb-3">
                      <label>Category</label>
                      <select  name="vehicle_type_id" id="category" class="form-control">
                        <option value="">Select Category</option>
                        @if($categories)
                        @foreach($categories as $key=>$value)
                        <option @if((old("vehicle_type_id")??$vehicle->vehicle_type_id??"")==$key) selected @endif value="{{$key}}">{{$value}}</option>
                        @endforeach
                        @endif
                      </select>
                  </div>

                  <div class="mb-3">
                      <label>Service</label>
                      <select id="services"  name="services[]" class="form-control" multiple>
                      </select>
                  </div>

                  <div class="mb-3">
                     <label>Vehicle image</label>
                     @if(isset($vehicle->image))
                     <img src="{{ Storage::url($vehicle->image) }}" class="mb-2 mt-2" style="width: 200px;">
                     @endif
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text" id="inputGroupFileAddon01">Upload</span></div>
                        <div class="custom-file">
                            <input accept="image/*" name="image" class="custom-file-input" id="inputGroupFile01" type="file" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                  </div>

                  <div class="mb-3">
                      <label>Status</label>
                      <select  name="status" class="form-control">
                        <option @if((old("status")??$vehicle->status??"")==1) selected @endif value="1">Enable</option>
                        <option @if((old("status")??$vehicle->status??"")==0) selected @endif  value="0">Disable</option>
                      </select>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
  @if($vehicle)
    @if($vehicle->vehicle_type_id)
      $("#category").trigger("change");
    @endif
  @endif
});

  $('input[name="registration"]').daterangepicker({
    singleDatePicker: true,
    autoApply: true,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  $('input[name="registration_date"]').daterangepicker({
    singleDatePicker: true,
    autoApply: true,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  $('input[name="first_registration_date"]').daterangepicker({
    singleDatePicker: true,
    autoApply: true,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  $('input[name="first_registration_date"]').daterangepicker({
    singleDatePicker: true,
    autoApply: true,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  $('input[name="warranty"]').daterangepicker({
    singleDatePicker: true,
    autoApply: true,
    locale: {
      format: 'DD/MM/YYYY'
    }
  });

  


  $(document).on('change', '#category', function(){
      var category_id = $(this).val();
      var service_ids = {!! json_encode($service_ids) !!};
      $.ajax({
              url: "{{ route('admin.vehicle.service.ajax') }}",
              type: 'POST',
              headers: {
                  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
              },
              data:{id:category_id},
              beforeSend: function(){
                  
              },
              success: function (data) {
                var html = "";
                data.map((item)=>{
                  var selected = service_ids.includes(item.id)?"selected":"";
                  html+="<option "+selected+" value='"+item.id+"'>"+item.service_name+"</option>"
                })
                $("#services").html(html);
              },
              error: function (data, error) {
                  
              }
          });
  });
</script>
@endsection

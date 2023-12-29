@extends('layouts.admin')
@section('content')
<section id="pricing" class="pricing">
  <div class="container">

    <div class="section-title">
      <h2 class="text-center"></h2>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title mb-3">Account</h4>
              <form method="post" action="{{route('admin.account.save.settings')}}" id="account-settings">
                @csrf
                <div class="row justify-content-left">
                    <div class="col-md-6 form-group mb-3">
                        <label for="shop-url">Name</label>
                        <input class="form-control" type="text" name="name" value="{{$user->name}}">
                    </div>
                </div>

                <div class="row justify-content-left">
                    <div class="col-md-6 form-group mb-3">
                        <label for="shop-url">Email</label>
                        <input class="form-control" type="text" name="email" value="{{$user->email}}" disabled="">
                    </div>
                </div>
                <p class="text-muted text-left">Leave blank if you don't want to change password</p>
                <div class="row justify-content-left">
                    <div class="col-md-6 form-group mb-3">
                        <label for="shop-url">New Password</label>
                        <input class="form-control" type="password" name="password">
                    </div>
                </div>

                <div class="row justify-content-left">
                    <div class="col-md-6 form-group mb-3">
                        <label for="shop-url">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" >
                    </div>
                </div>

                <div class="row justify-content-left">
                  <div class="col-md-6">
                    <button class="btn btn-primary ladda-button" data-style="expand-left">Submit</button>
                  </div>
                </div>
            </form>
          </div>
        </div>
      </div>
      <!--Here lies button--->
      <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
              <h4 class="card-title mb-3">Import Prices</h4>
              <button id="import_btn" class="btn btn-primary laddo-button">Import</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('app/css/plugins/ladda-themeless.min.css') }}" />
<link rel="stylesheet" href="{{ asset('app/css/plugins/toastr.css') }}" />
@endsection
@section('scripts')
<script src="{{ asset('app/js/plugins/spin.min.js') }}"></script>
<script src="{{ asset('app/js/plugins/ladda.min.js') }}"></script>
<script src="{{ asset('app/js/plugins/toastr.min.js') }}"></script>
<script src="{{ asset('app/js/account/settings.js') }}"></script>
<script type="">
  $(document).ready(function(){
    var laddo = Ladda.create(document.querySelector('.laddo-button'));
    $(document).on('click', '#import_btn', function () {
      $.ajax({
            url: '{{ route('price-update') }}',
            type: 'GET',
            beforeSend: function(){
            	laddo.start();
            },
            success: function (data) {
                laddo.stop();
                if(data){
                  toastr.success("Prices are being Imported.", "Saved", {
                    timeOut: "5000"
                  });
                }
            },
            error: function (data, error) {
                laddo.stop();
                var time = 10000;
                $.each(data.responseJSON.errors, function(i, row){
                    time += 1000;
                    toastr.error(row[0], "Error!", {
                      timeOut: time
                    });
                })
            }
        });
    });
    // ladda.start();
    // ladda.stop();
    // toastr.success("I killed Serious Black", "Saved", {
    //   timeOut: "3000"
    // });
  });
</script>
@endsection
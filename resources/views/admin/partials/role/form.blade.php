@extends('layouts.admin')

@section('content')
<section id="pricing" class="pricing">

    <div class="section-title">
      <p class="text-center"></p>
    </div>

    <div class="row">
      <div class="col-md-6">
          <div class="card mb-4">
             <form method="post" action="{{route('admin.role.submit')}}">
              @csrf
              @if(isset($role->id))
              <input type="hidden" name="id" value="{{$role->id}}">
              @endif
              <div class="card-body">
                  <div class="card-title">Role</div>
                  <div class="mb-3">
                      <label>Role name</label>
                      <input class="form-control" name="name" value="{{old("name")??$role->name??""}}" type="text" placeholder="name" aria-label="Username" aria-describedby="basic-addon1">
                  </div>
                  <div class="mb-3">
                      <label>Permissions</label>
                      @if($permissions)
                      @foreach($permissions as $key => $permission)
                      <div class="form-check">
                            <input class="form-check-input" @if(in_array($key,old("permissions")??$permission_ids)) checked @endif  name="permissions[]" value="{{$key}}" id="invalidCheck" type="checkbox" >
                            <label class="form-check-label" for="invalidCheck">
                                {{$permission}}
                            </label>
                        </div>
                        @endforeach
                      @endif
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

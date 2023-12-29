@extends('layouts.admin') @section('content')
    <section class="forms">

        <div class="card" style="width: 96%;margin-left: 2%;">
            <h5 class="card-header">Edit Promotion Banner</h5>
            <div class="card-body">
                <form method="post" action="{{ route('admin.promotion.edit.store', $promotion->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">{{ trans('file.Title') }} <span
                                class="text-danger">*</span></label>
                        <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                            value="{{ $promotion->title }}" class="form-control">
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputDesc" class="col-form-label">{{ trans('file.Description') }}</label>
                        <textarea class="form-control tinymce" id="description" name="description">{{ $promotion->description }}</textarea>
                        @error('description')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="start_date" class="col-form-label">Start Date <span
                                class="text-danger">*</span></label>
                        <input id="start_date" type="datetime-local" name="start_date"
                            value="{{ \Carbon\Carbon::parse($promotion->start_date)->format('Y-m-d\TH:i') }}"
                            class="form-control">
                        @error('start_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="end_date" class="col-form-label">End Date <span
                                class="text-danger">*</span></label>
                        <input id="end_date" type="datetime-local" name="end_date"
                            value="{{ \Carbon\Carbon::parse($promotion->end_date)->format('Y-m-d\TH:i') }}"
                            class="form-control">
                        @error('end_date')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            <option value="active" {{ $promotion->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $promotion->status == 'inactive' ? 'selected' : '' }}>Inactive
                            </option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="color" class="col-form-label">Color</label>
                        <textarea class="form-control" id="color" name="color">{{$promotion->color}}</textarea>
                        @error('color')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                    <div class="form-group mb-3">
                        <button class="btn btn-success" type="submit">Update</button>
                    </div>
                </form>
            </div>
        </div>
    @endsection

    @push('styles')
        {{-- <link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}"> --}}
    @endpush
    @push('scripts')
        {{-- <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script> --}}
        {{-- <script src="{{asset('backend/summernote/summernote.min.js')}}"></script> --}}
        <script>
            $('#lfm').filemanager('image');

            $(document).ready(function() {
                $('#description').summernote({
                    placeholder: "Write short description.....",
                    tabsize: 2,
                    height: 150
                });
            });
        </script>
    @endpush
    @section('scripts')
        <script type="text/javascript" src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>

        <script>
            tinymce.init({
                selector: 'textarea.tinymce',
            });
        </script>
    @endsection

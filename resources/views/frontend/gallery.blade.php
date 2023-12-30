@extends('frontend.layouts.master')
@section('title', 'Demo || Gallery')
@section('main-content')


    {{-- <img src="{{asset('frontend/img/commingsoon.jpg')}}">  --}}
    <main id="main">

        <!-- Breadcrumbs -->
        <div class="w-full bg-[#706233]/10 py-[15px]">
            <div class="!container px-6 mx-auto">
                <div class="flex items-center">
                    <div class="grow">
                        <nav>
                            <ol class="flex items-center">
                                <li class="list-unstyled"><a href="{{ 'home' }}">Home </a></li>
                                <li class="list-unstyled text-[#706233] ml-1" aria-current="page"> / Gallery</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="grow text-right">
                        <h2 class="text-[16px] font-bold">Gallery</h2>
                    </div>
                </div>
            </div>
        </div>
        <!-- Gallery -->
        <section class="align-items-center mb-5">
            <div class=" text-center custom_width mx-auto">
                <div class="row" style="">
                    <div class="row">
                        <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                            <img src="{{ asset('images/pic_1.jpg') }}" class="w-100 shadow-1-strong rounded mb-4"
                                alt="Demo" />

                            <img src="{{ asset('images/pic_2.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />
                        </div>

                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <img src="{{ asset('images/pic_3.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />

                            <img src="{{ asset('images/pic_4.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />
                        </div>

                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <img src="{{ asset('images/pic_5.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />

                            <img src="{{ asset('images/pic_6.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-12 mb-4 mb-lg-0">
                            <img src="{{ asset('images/pic_1.jpg') }}" class="w-100 shadow-1-strong rounded mb-4"
                                alt="Demo" />

                            <img src="{{ asset('images/pic_2.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />
                        </div>

                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <img src="{{ asset('images/pic_3.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />

                            <img src="{{ asset('images/pic_4.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />
                        </div>

                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <img src="{{ asset('images/pic_5.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />

                            <img src="{{ asset('images/pic_6.jpg') }}"
                                class="w-100 shadow-1-strong rounded mb-4" alt="Demo" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Gallery -->



    </main>

@endsection

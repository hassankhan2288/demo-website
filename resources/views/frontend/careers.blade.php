@extends('frontend.layouts.master')
@section('title','Cater-Choice || Promotion Page')
@section('main-content')
 

    <main class="mb-[24px]">
        <section class="flex items-center py-[40px]">
            <div class="!container mx-auto px-6">
                <div class="flex flex-wrap">
                    <div class="lg:w-6/12 cursor-pointer">
                        <div class="card p-[20px] border">
                            <div class="text-center">
                                <img src="{{ asset('frontend/img/demo.png')}}" class="w-[200px] mx-auto">
                            </div>
                            <h4 class="font-semibold text-[22px] mt-3 mb-2">Credit Controller</h4>
                            <div>
                                <p style="padding: 5px 0px;">
                                Location : Leeds
                                </p>
                                <h5 class="m-t-10"><a href="https://goo.gl/maps/WimCDC7pDPD66Nf29" target="_blank">ICS Building , Neville Road, Bradford, BD4 8TU.</a></h5>
                                <p class="text-dark">
                                P : <a href="tel:01274301910" style="text-decoration: none;color:black"><span> 01274301910</span></a><br>
                                P : <span class="contact_whatsapp" onclick="window.open('https://api.whatsapp.com/send?phone=‭07983541514&amp;text=Hi,%20i%20got%20your%20number%20from%20your%20website')"><span>07983541514</span></span><br>
                                E : <a href="" style="text-decoration: none;color:black"><span>bradford@cater-choice.com</span></a>
                                </p>
                                <br>
                                <div class="text-center">
                                    <a href="application-form.php" class="bg-[#706233] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold inline-block mx-auto">
                                    Apply Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

  @endsection


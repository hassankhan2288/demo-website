@extends('frontend.layouts.master')
@section('title','DEMO || About Us')
@section('main-content')

  <main id="main">
    <section class="flex items-center py-[40px]">
      <div class="!container mx-auto px-6 pb-[40px]">
        <div class="flex items-center">
            <div class="md:w-full">
                <img src="{{asset('images/about.jpg')}}" style="width:100%">
            </div>
          </div>
          <div class="flex items-center pt-[40px]">
            <div class="md:w-full">
              <h1 class="text-[26px] font-semibold">WHO ARE WE?</h1><br>
              <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe repellat provident nobis repudiandae minima nisi iure. Eveniet corporis facere dignissimos? A eius ipsam ab blanditiis cum ratione laboriosam temporibus hic?</p> 
            </div>
          </div>
          <div class="md:w-full mt-3">
              <img src="{{asset('images/about.jpg')}}" style="width:100%">
          </div>
        <br>
        <div class="flex items-center">
          <div class="md:w-full">
            <h1 class="text-[26px] font-semibold mt-3">ABOUT OUR COMPANY</h1><br>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati provident ipsum voluptatum ex voluptatem beatae dolores quisquam impedit? Enim officiis ex placeat minima voluptates pariatur possimus assumenda id quam. Magnam?</p> 
          </div>
        </div>
          <div class="md:w-full mt-3">
              <img src="{{asset('banners/sky.jpg')}}" style="width:100%">
          </div>
        <br>
        <div class="flex items-center">
          <div class="md:w-full">
            <h1 class="text-[26px] font-semibold mt-3">QUANTITY AND SERVICE</h1><br>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Facilis doloremque optio, hic quis et eum, quisquam ipsam consequatur maiores doloribus eius ab fuga repudiandae rerum sed at recusandae cum dolores!</p> 
            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. In architecto, dolor libero ut, maxime laudantium consectetur omnis magnam nam mollitia amet exercitationem placeat, voluptatem possimus provident corrupti voluptate? Exercitationem, ea!</p> 
          </div>
        </div>
      </div>
    </section>
  </main>

  @endsection


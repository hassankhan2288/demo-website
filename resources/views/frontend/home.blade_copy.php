@extends('frontend.layouts.master')
@section('title','Cater-Choice || Home Page')
@section('main-content')
  <section id="hero" class="mainslider">
    <div class="container">
      <div class="slides-hero swiper" data-aos="fade-up" data-aos-delay="100">
        <div class="swiper-wrapper">
        @foreach ($slider as $key=>$sliders )


          <div class="swiper-slide event-item d-flex flex-column justify-content-end">
            <a href="#"><img src="{{asset('banners/'.$sliders->photo)}}"></a>

          </div>
        @endforeach


          <!-- End Event item -->
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section><!-- End Hero Section -->


  <main id="main">

    <!-- =======  Best selling ======= -->
    <section2 id="hero2" class="hero2 d-flex align-items-center">
      <div class="container">
        <div class="row" style="background-color: #bfe7f5">
          <div class="col-md-4 col-12">
            <img style="width:50%;" src="{{asset('frontend/assets/img/patez.png')}}">
          </div>
          <div class="col-md-8 col-12 d-flex align-items-center">
            <div class="buttonsec align-middle">
              <div>
                <h3 class="heading1">Best selling, High quality range of products</h3>
                <a href="#">
                  <button class="button-trans ">Check Product Range</button>
                </a>
                <br>
                <a href="#">
                  <button class="button-trans ">Have Question? Contact us</button>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section2><!-- End  Best selling -->

    <!-- ======= Category section ======= -->
    <section id="Category" class="events">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <p><span>Popular </span>Categories</p>
        </div>

        <div class="slides-3 swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">
            @foreach ( $category_all as $key=>$categrory )


                <div class="swiper-slide event-item d-flex flex-column justify-content-end">
                  <img src="{{asset('public/images/category/'.$categrory->image)}}">
                  <a href="#">{{ $categrory->name }}</a>
            </div>
            @endforeach


            <!-- End Event item -->
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Events Section -->

    <!-- ======= Menu Section ======= -->
    <section id="menu" class="menu">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Our Menu</h2>
          <p>Check Our <span>Products</span></p>
        </div>

        <ul class="nav nav-tabs d-flex justify-content-center" data-aos="fade-up" data-aos-delay="200">
@foreach ( $category_all as $key=>$categrory )


      <li class="nav-item">
            <a class="nav-link @if ($key == 0)
active  show
            @endif " data-bs-toggle="tab" data-bs-target="#menu-{{ $key }}">
              <h4>{{ $categrory->name }}</h4>
            </a>
          </li><!-- End tab nav item -->
      @endforeach




        </ul>

        <div class="tab-content" data-aos="fade-up" data-aos-delay="300">
            @foreach ( $category_all as $key=>$categrory )


          <div class="tab-pane fade @if ($key == 0) active show @endif " id="menu-{{ $key }}">

            <div class="tab-header text-center">
              <p>Menu</p>
              <h3>{{ $categrory->name }}</h3>
            </div>

            <div class="row gy-5">
              <?php
            //use App\Product;
            $products= App\Product::inRandomOrder()->limit(10)->get();
            //dd($products);
              ?>
              {{-- @foreach ( $categrory->producthome as $key_product => $products ) --}}
              @foreach ( $products as $key_product => $products )

              <?php  $image= $products->image;
              $images = explode(',',$image);

              ?>
              <div class="col-lg-3 menu-item">
                <a href="{{asset('storage/thumbnail/'.$images[0])}}" class="glightbox">
                  <img src="{{asset('storage/thumbnail/'.$images[0])}}" class="menu-img img-fluid" alt=""></a>
                <h4>{{ $products->name }}</h4>
                <p class="ingredients">
                  {!! $products->product_details !!}
                </p>
               {{-- <p class="price">
                  ${{ $products->price }}
                </p>--}}
              </div><!-- Menu Item -->
              @endforeach




            </div>
          </div><!-- End Starter Menu Content -->
          @endforeach
        </div>

      </div>
    </section><!-- End Menu Section -->

    <!-- ======= Our Brands Section ======= -->
    <section id="testimonials" class="testimonials section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <!--<h2> </h2>-->
          <p>Our <span>Brands</span></p>
        </div>

        <div class="slides-1 swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">
            @foreach ($brand_all as $key=>$brand )


            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="row gy-4 justify-content-center">
                  <div class="col-lg-12 text-center">
                    <img src="{{asset('public/images/brand/'.$brand->image)}}" class="img-fluid testimonial-img" alt="">
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section><!-- End Testimonials Section -->

    <!-- ======= Book A Table Section ======= -->
    <section id="book-a-table" class="book-a-table">
      <div class="container" data-aos="fade-up">

        <div class="section-header">
          <h2>Get in tuch</h2>
          <p>Subscribe <span>to our</span> Newsletter</p>
        </div>

        <div class="row g-0">
          <div class="col-lg-2"></div>
          {{--<div class="col-lg-4 reservation-img" style="background-image: url({{asset('frontend/assets/img/reservation.jpg')}});" data-aos="zoom-out" data-aos-delay="200"></div>--}}

          <div id="form" class="col-lg-8 align-items-center reservation-form-bg">
            @if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
@if (\Session::has('error'))
    <div class="alert alert-danger">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif
            <form action="{{route('subscribe')}}" method="post"  role="form" class="php-email-form" data-aos="fade-up" data-aos-delay="100">

              <div class="form-group mt-3">
                <input type="email"  class="form-control" name="email" id="emailsubs" placeholder="Your Email" required>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="validate" ></div>
              </div>
              <div class="mb-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <?php if(isset($success)) { ?>
                <div>Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div>
               <?php } ?>
              </div>
              <div class="" style="text-align: right"><button type="submit"  id="submit_subs">Subscribe</button></div>
            </form>
          </div><!-- End Reservation Form -->
          <div class="col-lg-2"></div>
        </div>

      </div>
    </section><!-- End Book A Table Section -->


    <!-- ======= Contact Section ======= -->
 @include('frontend/footer');
<script>

//$('#pick_date').val(new Date().toDateInputValue());
$(document).ready(function () {
  $("#form").submit(function (event) {
    //alert(88);
    var formData = {
      //name: $("#name").val(),
      email: $("#email").val(),
     // superheroAlias: $("#superheroAlias").val(),
    };

    $.ajax({
      type: "POST",
      url: {{route('subscribe')}},
      data: formData,
      dataType: "json",
      encode: true,
    }).done(function (data) {
      console.log(data);
    });

    event.preventDefault();
  });
});

</script>
  </main><!-- End #main -->

  @endsection


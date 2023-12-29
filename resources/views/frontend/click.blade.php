@extends('frontend.layouts.master')
@section('title','Cater-Choice || Promotion Page')
@section('main-content')
 

{{-- <img src="{{asset('frontend/img/commingsoon.jpg')}}">  --}}
  <main id="main">

    <!-- Breadcrumbs -->
    <div class="w-full bg-[#ce1212]/10 py-[15px]">
      <div class="!container px-6 mx-auto">
          <div class="flex items-center">
              <div class="grow">
                  <nav>
                      <ol class="flex items-center">
                          <li class="list-unstyled"><a href="{{('home')}}">Home </a></li>
                          <li class="list-unstyled text-[#ce1212] ml-1" aria-current="page"> / Click & Collect</li>
                      </ol>
                  </nav>
              </div>
              <div class="grow text-right">
                  <h2 class="text-[16px] font-bold">Click & Collect</h2>
              </div>
          </div>
      </div>
    </div>

    <!-- Brand start -->
    <section class="overlay_class py-[60px] relative before:absolute before:inset-0 before:content-[''] before:bg-[#ce1212]/20 before:z-[1] group">
      <img src="{{image_url('storage/red-bg.jpg')}}" class="w-full h-full object-cover absolute inset-0">
      <div class="!container !px-6 mx-auto relative z-[2]">
       <div class="custom_add_cart">
        <div class="relative">
					<input type="text" name="email" id="emailsubs" placeholder="" value="Place Your Order Now" disabled class="w-full bg-white p-[15px_150px_15px_20px] rounded-[50px] !border !border-[#ce1212]" required="" data-gtm-form-interact-field-id="0">
					<i class="fa fa-arrow-right" aria-hidden="true"></i>
					<a href="{{ route('product-grids') }}" class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold absolute right-[7px] top-[7px]" type="submit">Order Now</a>
				</div>
       </div>
      </div>
    </section>
    <!-- Brand end -->

    <div class="w-full text-center container">
      <div class="heading_text_container mx-auto">
        <h1>We are excited to offer our customers a convenient and safe way to shop with our Click and Collect service.</h1>
        <p>Whether you're pressed for time or prefer to avoid shipping fees, Click and Collect is the perfect solution for those who want to shop online and pick up their purchases in-store.</p>
      </div>
    </div>

    <section class="align-items-center mb-5">
      <div class=" text-center custom_width mx-auto">
        <div class="row" style="">
          <div class=" custom_card_hm text-center ">
            <h1>How It Works</h1>
          </div>
          <div class="content_here">
            <div class="mini_heading">
              <h3>Register Online</h3>
            </div>
            <div class="context">
              <p>Create an account on our website and select your preferred pickup location during the registration process.</p>
            </div>
          </div>
          <div class="content_here">
            <div class="mini_heading">
              <h3>Shop Online</h3>
            </div>
            <div class="context">
              <p>Browse our wide selection of products and add your favorite items to your cart.</p>
            </div>
          </div>
          <div class="content_here">
            <div class="mini_heading">
              <h3>Make Your Payment</h3>
            </div>
            <div class="context">
              <p>Pay for your order securely on our website using our hassle-free checkout process.</p>
            </div>
          </div>
          <div class="content_here">
            <div class="mini_heading">
              <h3>Confirm your order: </h3>
            </div>
            <div class="context">
              <p>Once you have reviewed your order details, click "confirm" to complete your purchase.</p>
            </div>
          </div>
          <div class="content_here">
            <div class="mini_heading">
              <h3>Pick up in-store: </h3>
            </div>
            <div class="context">
              <p>Head to your selected store at your chosen pickup time and collect your items. Be sure to bring a copy of your confirmation email or order number.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="align-items-center mb-5 custom_width mx-auto">
      <div class="main_container d-flex">
        <div class="left w-50">
          <p>We want to make your shopping experience as seamless as possible, which is why we allow you to select your preferred pickup location during the registration process. This ensures that you can quickly and easily select your pickup location each time you shop with us</p>
          <p>Our secure checkout process ensures that your payment information is protected, and you can choose from a variety of payment options, including credit card, debit card.</p>
        </div>
        <div class="right w-50">
          <div class="custom_card_hm text-center">
            <h1>Benefits of Click and Collect:</h1>
          </div>
          <div class="box_hm">
            <h3>Safe and convenient: </h3>
            <p>Avoid shipping fees and enjoy the convenience of shopping online and picking up in-store.</p>
          </div>
          <div class="box_hm">
            <h3>Fast and easy:  </h3>
            <p>Save time by skipping the shipping wait time and pick up your order in-store on the same day.</p>
          </div>
          <div class="box_hm">
            <h3>Flexibility:  </h3>
            <p>Select the pickup time that works best for you.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="align-items-center mb-5 custom_width mx-auto">
      <h1 class="custom_h">FAQ:</h1>
      <div class="accordion grid sm:grid-cols-2 grid-cols-1 gap-4 mt-4" id="accordionExample">
        <div class="flex flex-col gap-4">
          <div class="accordion-item rounded-[4px] border">
            <h2 class="accordion-header" id="headingOne">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              Q. What items are eligible for Click and Collect? 
            </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                A. Most items available on our website are eligible for Click and Collect. You will be notified if an item is not eligible for this service
              </div>
            </div>
          </div>
          <div class="accordion-item rounded-[4px] border">
            <h2 class="accordion-header" id="headingThree">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Q. Is there a fee for Click and Collect? 
            </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                A. No, there is no fee for using our Click and Collect service
              </div>
            </div>
          </div>
          <div class="accordion-item rounded-[4px] border">
            <h2 class="accordion-header" id="headingFive">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
              Q. Ready to try Click and Collect? 
            </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="collapseFive" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                A. Start shopping now and experience the convenience of online shopping with the benefits of in-store pickup
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-4">
          <div class="accordion-item rounded-[4px] border">
            <h2 class="accordion-header" id="headingTwo">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Q. What do I need to bring to collect my order? 
            </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                A. Bring a copy of your confirmation email or order number and a valid ID.
              </div>
            </div>
          </div>
          
          <div class="accordion-item rounded-[4px] border">
            <h2 class="accordion-header" id="headingFour">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
              Q. Can I change my pickup time or location? 
            </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="collapseFour" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                A. Yes, you can modify or cancel your order by contacting our customer service team at least 24 hours before your scheduled pickup time.
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
    
    {{-- <section class="align-items-center">
      <div class="container">
        <div class="row" style="">
          <div class="d-flex custom_card_hm">
            <div class="col-md-4 left left_box">
              <
            </div>
            <div class="col-md-8 right right_box">

            </div>
          </div>
        </div>
      </div>
    </section> --}}

    

  </main>

  @endsection


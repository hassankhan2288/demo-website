@extends('frontend.layouts.master')
@section('title','Cater-Choice || Promotion Page')
@section('main-content')

  <main id="main">
    <section class="flex items-center py-[40px]">
      <div class="!container mx-auto px-6 pb-[40px]">
        <div class="flex items-center">
            <div class="md:w-full">
                <img src="{{asset('frontend/img/aboutus.jpg')}}" style="width:100%">
            </div>
        </div>
        <div class="flex items-center pt-[40px]">
            <div class="md:w-full">
              <h1 class="text-[26px] font-semibold">OUR COMPANY</h1><br>
              <p class="text-justify">Cater Choice is a well-established company (part of the ICS UK Ltd group), specialising in the distribution of catering products and packaging to the foodservice and hospitality industries. Our Cash & Carry sites and distribution centres are located in the geographical heart of the United Kingdom; thus allowing easy access of our range of ambient, frozen and refrigerated products, to thousands of customers.</p>
              <br>
              <p class="text-justify">Cater Choice are committed to selling a high quality range of own label products, as well as selected national and private label products for the catering services sector. Built through years of experience; our extensive knowledge of the catering market has helped us build a tried and tested portfolio of products, which trade under the <i><b>Prima, Al Ameen, Easi Pak, Mount Prima, My Flavourite Chicken, Texas Ranger and Manhattan</b></i> labels. </p>
              <br>
              <p class="text-justify">To achieve this, we have sourced extensively throughout the world and our buyers personally travel to the various countries of origin; and routinely place contracts for supply for the season. This allows us to ensure we have full control over quality and price competitiveness. The mixture of own label and other branded names, ensures choice for diverse caterers with differing markets and price points. </p>
          </div>
        </div>
        <br>
        {{-- <div class="flex items-center">
          <div class="md:w-full">
            <p class="text-justify">At Cater Choice, we understand the logistical and financial pressures faced by commercial kitchens. Helping our customers meet these challenges, is at the heart of everything we do; and is reflected in our product range and pricing structure, as well as the strength of relationships with both suppliers and customers.</p>
            <br>
            <p class="text-justify"><b>‘We truly believe that strong relationships with both suppliers and customers, are the key to success and longevity in the business world. Developing these mutually beneficial relationships has helped us grow as a company, and allowed us to acquire our reputation for quality products with competitive pricing.’ Ismail Bhamji (Director)</p>
          </div>
        </div> --}}
      </div>
    </section>
  </main>

  @endsection


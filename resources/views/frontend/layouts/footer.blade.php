<section class="py-[40px] bg-[#ce1212]/10 mb-[24px] z-hm-footer">
	<div class="container px-6 mx-auto">
		<div class="grid lg:grid-cols-2 md:grid-cols-2 grid-cols-1 gap-5">
			{{--<div>
				<!-- Start Single Service -->
				<div class="flex items-center">
					<i class="fa fa-rocket text-[33px]" aria-hidden="true"></i>
					<div class="ml-[15px]">
						<h4 class="text-[16px] mb-[10px] font-semibold">Free shiping</h4>
						<p class="text-[14px] font-medium">Orders over £100</p>
					</div>
				</div>
				<!-- End Single Service -->
			</div>--}}
			{{--<div>
				<!-- Start Single Service -->
				<div class="flex items-center">
					<i class="fa fa-refresh text-[30px]" aria-hidden="true"></i>
					<div class="ml-[15px]">
						<h4 class="text-[16px] mb-[10px] font-semibold">Free Return</h4>
						<p class="text-[14px] font-medium">Within 30 days returns</p>
					</div>
				</div>
				<!-- End Single Service -->
			</div>--}}
			<div>
				<!-- Start Single Service -->
				<div class="flex items-center">
					<i class="fa fa-lock text-[35px]" aria-hidden="true"></i>
					<div class="ml-[15px]">
						<h4 class="text-[16px] mb-[10px] font-semibold">Secure Payment</h4>
						<p class="text-[14px] font-medium">100% secure payment</p>
					</div>
				</div>
				<!-- End Single Service -->
			</div>
			<div>
				<!-- Start Single Service -->
				<div class="flex items-center">
					<i class="fa fa-tag text-[30px]" aria-hidden="true"></i>
					<div class="ml-[15px]">
						<h4 class="text-[16px] mb-[10px] font-semibold">Best Price</h4>
						<p class="text-[14px] font-medium">Guaranteed price</p>
					</div>
				</div>
				<!-- End Single Service -->
			</div>
		</div>
	</div>
</section>
<!-- Newsletter section start -->
    <section class="py-[100px] relative -mt-[24px]">
	    <img src="{{asset('public/images/category/20221125034001.jpg')}}" class="w-full h-full object-cover absolute inset-0 opacity-50">
      <div class="containe mx-auto relative">
        <div class="flex justify-center items-center flex-wrap gap-5">
          <div id="form" class="sm:w-full md:w-8/12 lg:w-6/12 xl:w-7/12 2xl:w-5/12 text-center px-[50px]">
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
            <form action="{{route('subscribe')}}" method="post" role="form">
				<h6 class="mb-[.5rem] text-[35px] font-bold">Subscribe to our newsletter</h6>
				<p class="mb-[15px] text-[14px] ">Subscribe to the mailing list to receive updates on special offers, new arrivals and our promotions.</p>
				<div class="relative">
					<input type="text" name="email" id="emailsubs" placeholder="Enter your email address" class="w-full bg-white p-[15px_150px_15px_20px] rounded-[50px] !border !border-[#ce1212]" required />
					<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					<button class="bg-[#ce1212] text-white p-[11px_30px] rounded-[50px] text-[14px] font-bold absolute right-[7px] top-[7px]" type="submit" >Subscribe</button>
					<?php if(isset($success)) { ?>
						<div>Your booking request was sent. We will call back or send an Email to confirm your reservation. Thank you!</div>
					<?php } ?>
				</div>
            </form>
          </div>
        </div>
      </div>
    </section>
    <!-- offer section end -->

	<footer class="bg-[#ce1212]/10 relative">
		<div class="container">
			<div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 md:divide-x divide-[#ce1212]/10">
				<div class="flex sm:py-[70px] py-6 md:pl-[30px] flex-column">
					{{-- <div class="flex">
						<div class="w-[65px] h-[65px] bg-[#ce1212] text-[24px] flex items-center justify-center rounded-full shrink-0">
							<i class="fa fa-clock-o text-white text-[24px]" aria-hidden="true"></i>
						</div>
						<div class="ml-[15px]">
							<h4 class="text-[18px] mb-[5px] font-bold">Opening Hours</h4>
							<p class="text-[14px]">
								Mon - Fri: 09:00 AM - 05:30 PM<br>
								Sat - Sun: 11:00 AM - 05:00 PM
							</p>
						</div>
					</div> --}}
					<div class="flex  flex-row">
						<div class="w-[65px] h-[65px] bg-[#ce1212] text-[24px] flex items-center justify-center rounded-full shrink-0">
							<i class="fa fa-list text-white text-[24px]" aria-hidden="true"></i>
						</div>
						<div class="ml-[15px]">
							<a href="javascript:void(0)" class="text-[18px] mb-[5px] font-bold mt-2">Popular Categories</a>
							<ul class="pt-[10px]">
								@if(\Helper::popularCategories())
									@foreach ( \Helper::popularCategories() as $cat)
									<li><a href="{{ route('product-cat',$cat->id) }}">{{ $cat->name }}</a></li>
									@endforeach
								@else
									@foreach ( \Helper::defaultCategories() as $cat)
									<li><a href="{{ route('product-cat',$cat->id) }}">{{ $cat->name }}</a></li>
									@endforeach
								@endif
							</ul>
						</div>
					</div>
				</div>
				<div class="sm:py-[70px] py-6 flex flex-col gap-3 sm:pl-[30px]">
					<div class="flex items-center">
						<div class="w-[65px] h-[65px] bg-[#ce1212] text-[24px] flex items-center justify-center rounded-full shrink-0">
							<i class="fa fa-phone text-white text-[24px]" aria-hidden="true"></i>
						</div>
						<div class="ml-[15px]">
							<h4 class="text-[18px] mb-[5px] font-bold">Contact</h4>
							<a href="mailto:info@cater-choice.com" class="text-[14px]">
								info@cater-choice.com
							</a>
							<a href="{{ route('contact') }}" class="text-[14px] d-block">
								Contact Us
							</a>
						</div>
					</div>
{{--					<div class="flex items-center">--}}
{{--						<div class="w-[65px] h-[65px] bg-[#ce1212] text-[24px] flex items-center justify-center rounded-full shrink-0">--}}
{{--							<i class="fa fa-phone text-white text-[24px]" aria-hidden="true"></i>--}}
{{--						</div>--}}
{{--						<div class="ml-[15px]">--}}
{{--							<h4 class="text-[18px] mb-[5px] font-bold">Phone</h4>--}}
{{--							<a href="tel:0044 1274 301910" class="text-[14px]">--}}
{{--								0044 1274 301910--}}
{{--							</a>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="flex items-center">--}}
{{--						<div class="w-[65px] h-[65px] bg-[#ce1212] text-[24px] flex items-center justify-center rounded-full shrink-0">--}}
{{--							<i class="fa fa-map-marker text-white text-[24px]" aria-hidden="true"></i>--}}
{{--						</div>--}}
{{--						<div class="ml-[15px]">--}}
{{--							<h4 class="text-[18px] mb-[5px] font-bold">Address</h4>--}}
{{--							<a href="https://goo.gl/maps/tuADY4qHM95TCBYy6" class="text-[14px]">--}}
{{--								Neville Road, Bradford,BD4 8TU<br>--}}
{{--								United Kingdom<br>--}}
{{--							</a>--}}
{{--						</div>--}}
{{--					</div>--}}
				</div>
				<div class="md:py-[70px] pt-6 pb-12 md:pl-[30px]">
					<h4 class="text-[18px] mb-[10px] font-bold">Follow Us</h4>
					<div class="flex items-center">
						<a href="https://www.tiktok.com/@cater_choice" class="w-[40px] h-[40px] flex items-center justify-center rounded-full bg-[#ce1212] text-white !border text-[16px] mr-[15px]">
							<svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512"><!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. --><style>svg{fill:#ffffff}</style><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg>
						</a>
						<a href="https://www.instagram.com/cater_choice/?hl=en" class="w-[40px] h-[40px] flex items-center justify-center rounded-full bg-[#ce1212] text-white !border text-[16px] mr-[15px]">
							<i class="fa fa-instagram" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="border-t border-[#ce1212]/10 py-[25px]">
			<div class="container">
				<div class="copyright text-center">
					<a href="{{ route('terms_and_condition') }}/#orderPlacementPolicy" class="mr-1 text-[10px]">Order Placement Policy</a>
					<a href="{{ route('terms_and_condition') }}/#deliveryPolicy" class="mr-1 text-[10px]">Delivery Policy</a>
					<a href="{{ route('terms_and_condition') }}/#warrantyPolicy" class="text-[10px]">Warranty Policy</a>
				</div>
				<div class="copyright text-center text-[10px]">
					&copy; Copyright <strong><span class="text-[#ce1212]">Cater-Choice</span></strong>. All Rights Reserved
				</div>
			</div>
		</div>
	</footer>
  <!-- End Footer -->

  <a href="#" class="scroll-top flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->




  <script src="{{asset('frontend/js/jquery.min.js')}}" ></script>
  <!-- <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}" ></script> -->
	<!-- <script src="{{asset('frontend/js/jquery-ui.min.js')}}" ></script> -->
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}" ></script>
	<!-- Bootstrap JS -->
	<!-- <script src="{{asset('frontend/js/bootstrap.min.js')}}" ></script> -->

	<!-- Color JS -->
	<!-- <script src="{{asset('frontend/js/colors.js')}}"></script> -->
	<!-- Slicknav JS -->
	<!-- <script src="{{asset('frontend/js/slicknav.min.js')}}"></script> -->
	<!-- Owl Carousel JS -->
	<!-- <script src="{{asset('frontend/js/owl-carousel.js')}}"></script> -->
	<!-- Magnific Popup JS -->
	<!-- <script src="{{asset('frontend/js/magnific-popup.js')}}"></script> -->
	<!-- Waypoints JS -->
	<!-- <script src="{{asset('frontend/js/waypoints.min.js')}}"></script> -->
	<!-- Countdown JS -->
	<!-- <script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script> -->
	<!-- Nice Select JS -->
	<!-- <script src="{{asset('frontend/js/nicesellect.js')}}"></script> -->
	<!-- Flex Slider JS -->
	<!-- <script src="{{asset('frontend/js/flex-slider.js')}}"></script> -->
	<!-- {{--<!-- ScrollUp JS -->
	<!-- <script src="{{asset('frontend/js/scrollup.js')}}"></script>--}} -->
	<!-- Onepage Nav JS -->
	<!-- <script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script> -->
	<!-- {{-- Isotope --}} -->
	<!-- <script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script> -->
	<!-- Easing JS -->
	<!-- <script src="{{asset('frontend/js/easing.js')}}"></script> -->

	<!-- Active JS -->
	<!-- <script src="{{asset('frontend/js/active.js')}}"></script> -->


	@stack('scripts')
	<!-- {{-- <script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script> --}} -->




  <script src="{{asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- <script src="{{asset('frontend/assets/vendor/aos/aos.js')}}"></script> -->
  <!-- <script src="{{asset('frontend/assets/vendor/glightbox/js/glightbox.min.js')}}"></script> -->
  <script src="{{asset('frontend/assets/vendor/purecounter/purecounter_vanilla.js')}}"></script>
  <script src="{{asset('frontend/assets/vendor/swiper/swiper-bundle.min.js')}}" ></script>
  <!-- <script src="{{asset('frontend/assets/vendor/php-email-form/validate.js')}}"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
 <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
 {{-- <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script> --}}
 <script src="{{asset('app/js/plugins/datatables.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('frontend/assets/js/main.js')}}"></script>
  <script src="{{asset('frontend/assets/js/front.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
  <script type="text/javascript">

	  var path = "{{ route('product.autocomplete') }}";
	  jQuery('.search.autocomplete').typeahead({
			  source: function (query, process) {
  
				  return jQuery.get(path, {
  
					  query: query
  
				  }, function (data) {
  
					  return process(data);
  
				  });
  
			  }
  
		  });
  
	
  
  </script>
  {{-- <script>

	//$('#pick_date').val(new Date().toDateInputValue());
		$(document).ready(function () {
			$('.selfpickup_option').on('click', function(){

				$('.delivery_section').css('height',0);
				$('.delivery_section').css('opacity',0);
				$('.delivery_section').css('position','absolute');

				$('.pickup_section').css('height','auto');
				$('.pickup_section').css('opacity','1');
				$('.pickup_section').css('position','unset');

			});
			$('.delivery_option').on('click', function(){
				$('.pickup_section').css('height',0);
				$('.pickup_section').css('opacity',0);
				$('.pickup_section').css('position','absolute');

				$('.delivery_section').css('height','auto');
				$('.delivery_section').css('opacity','1');
				$('.delivery_section').css('position','unset');
			});

			$("#form").submit(function (event) {
				//alert(88);
				var formData = {
				//name: $("#name").val(),
				email: $("#email").val(),
				// superheroAlias: $("#superheroAlias").val(),
				};

				$.ajax({
				type: "POST",
				url: '{{route("subscribe")}}',
				data: formData,
				dataType: "json",
				encode: true,
				}).done(function (data) {
				console.log(data);
				});

				event.preventDefault();
			});
			var dateToday = new Date();
			var dateTodayInYMD = jQuery.datepicker.formatDate('yy-mm-dd', dateToday);
			var currentTime = formatAMPM(dateToday);
			$('#date').datepicker({
				minDate: dateToday,
				dateFormat: 'dd-mm-yy',
                beforeShowDay: function(date){
                    var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
                    return [ array.indexOf(string) == -1 ]
                },
				onSelect: function (date, datepicker) {
					var warehouse_id = $('#warehouse_id').val();

					$.ajax({
					    type: "GET",
					    url: '{{ route("slots_generater")}}',
					    data: {
					        warehouse_id : warehouse_id,
							date: date,
							dateTodayInYMD : dateTodayInYMD,
							currentTime: currentTime,
					    },
					    success: function(result) {
							// console.log(typeof result);
							$('#slots_description').remove();
							if(result == false){
								$('#noslots').remove();
								$( "#slots-container" ).after( '<p id="noslots">No Slots Available</p>' );
							}else{
								$(".slots_container_hm").empty();
								const slotsContainer = document.getElementById("slots-container");
								const slots = JSON.parse(result);
								slots.forEach((slot, index) => {
									const label = document.createElement("label");
									label.setAttribute("class", "flex items-center cursor-pointer relative text-black text-[16px]");
									label.setAttribute("for", "flexRadioDefault2" + index);

									const input = document.createElement("input");
									input.setAttribute("class", "absolute opacity-0 z-[0] peer");
									input.setAttribute("type", "radio");
									input.setAttribute("id", "flexRadioDefault2" + index);
									input.setAttribute("name", "pick_time");
									input.setAttribute("value", slot);

									const span = document.createElement("span");
									span.setAttribute("class", "peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]");

									const text = document.createTextNode(slot);

									label.appendChild(input);
									label.appendChild(span);
									label.appendChild(text);

									slotsContainer.appendChild(label);
								});
							}
							// var html;
					        // html = '<div class="lg:col-span-12 md:col-span-12 !mt-6"><label class="text-[20px] font-semibold !mb-4">Pickup Time</label><div class="grid xl:grid-cols-6 lg:grid-cols-5 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-4">';
							// for (let i = 0; i < result.length; i++) {
							// 	html += '<label class="flex items-center cursor-pointer relative text-black text-[16px]" for="flexRadioDefault2'+result[i]+'" value="'+result[i]+'">';
							// 	html += '<input class="absolute opacity-0 z-[0] peer" type="radio" id="flexRadioDefault2'+result[i]+'" name="pick_time" />';
							// 	html += '<span class="peer-checked:bg-[#ce1212] shadow-[inset_0px_0px_0px_3px_white] border-2 border-[#ce1212] w-[18px] h-[18px] inline-block mr-2 rounded-full shrink-0 z-[10]"></span>';
							// 	html += result[i]+ '</label></div></div>';
							// }
							// $( "#warehouse_id" ).after( html );
					    },
					    error: function (error) {
					        console.log(error);
					    }
					});

                }
            // format: 'dd-mm-yyyy',
            }).on('changeDate', function(e) {

            });
		});
		function formatAMPM(date) {
			var hours = date.getHours();
			var minutes = date.getMinutes();
			var ampm = hours >= 12 ? 'PM' : 'AM';
			hours = hours % 12;
			hours = hours ? hours : 12; // the hour '0' should be '12'
			minutes = minutes < 10 ? '0'+minutes : minutes;
			var strTime = hours + ':' + minutes + ' ' + ampm;
			return strTime;
		}
</script> --}}


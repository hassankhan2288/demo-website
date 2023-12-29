<!DOCTYPE html>
<html lang="en">
<head>
	@include('frontend.layouts.head')
	@include('cookie-consent::index')
</head>
<body>

	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')

	@include('frontend.layouts.footer')

</body>
</html>

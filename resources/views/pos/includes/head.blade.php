<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Notify') }}</title>
<link href="{{ asset('front/img/favicon.png') }}" rel="icon">
<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet" />
<link href="{{ asset('app/css/themes/lite-purple.min.css') }}" rel="stylesheet" />
<link href="{{ asset('app/css/plugins/perfect-scrollbar.min.css') }}" rel="stylesheet" />
<!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<link rel="preload" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet"></noscript> 
    <!-- Drip icon font-->
     <link rel="preload" href="{{ asset('vendor/dripicons/webfont.css') }}" as="style" onload="this.onload=null;this.rel='stylesheet'"> 
     <noscript><link href="{{ asset('vendor/dripicons/webfont.css') }}" rel="stylesheet"></noscript> 
     <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}" > 
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" /> 

     
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />

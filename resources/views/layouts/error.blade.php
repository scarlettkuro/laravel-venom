<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Venom | Сталася помилка</title>
	<link rel="stylesheet" href="/themes/cosmo.min.css">
        <link rel="stylesheet" href="/css/style.css'">
  </head>
  <body>
    <div class="container">
        <div class="col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
        <!-- Header -->
            <div class="">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    
                    @if (Auth::check())
                    <li role="presentation"><a href="{{ route('blog',['nickname'=>Auth::user()->nickname]) }}">{{ Auth::user()->name }}</a></li>
                    <li role="presentation"><a href="{{ route('home') }}"> Головна </a></li>
                    <li role="presentation"><a href="{{ route('logout') }}">Вийти</a></li>
                    @else
                    <li role="presentation"><a href="{{ route('login') }}">Зайти</a></li>
                    @endif
                </ul>

                 <!-- Tab panes -->
                 <div class="tab-content">
                    <div role="tabpanel" class="tab-pane jumbotron active text-center" id="home">
                        <h1>{{ $code }}</h1>
                    </div>

              </div>
            </div>
        <!-- End Header -->
        
        @yield('content')
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/pretty-request.js"></script>
  </body>
</html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    @if (isset($me) && isset($owner) && $owner)
    <title>{{ $me->name }} | Venom</title>
    @else
    <title>Venom - щоденник</title>
    @endif
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://bootswatch.com/cosmo/bootstrap.min.css">
	<style>
            .stripe-block {
                    margin-top: 20px;
                    margin-bottom: 20px;
            }
            .jumbotron.main {
                background-color: #d9edf7;
            }
            a:link, a:visited, a:hover, a:active {
                color:inherit;
             }
	</style>
  </head>
  <body>
    <div class="container">
        <div class="col-lg-6 col-lg-offset-3">
        <!-- Header -->
            <div class="">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    {{-- @if (isset($me) && isset($owner) && $owner) --}}
                    @if (isset($myBlog) && $myBlog)
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Заголовок</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Налаштування</a></li>
                    @endif
                    @if (isset($me) && !(isset($myBlog) && $myBlog ))
                    <li role="presentation"><a href="{{ route('blog',['nickname'=>$me->nickname]) }}">{{ $me->name }}</a></li>
                    @endif
                    @unless (isset($main) && $main)
                    <li role="presentation"><a href="{{ route('home') }}"> Головна </a></li>
                    @endunless
                    @if (isset($me))
                    <li role="presentation"><a href="{{ route('logout') }}">Вийти</a></li>
                    @else
                    <li role="presentation"><a href="{{ route('login') }}">Зайти</a></li>
                    @endif
                </ul>

                 <!-- Tab panes -->
                 <div class="tab-content">
                    <div role="tabpanel" class="tab-pane jumbotron @if (isset($main) && $main)) main @endif active text-center" id="home">
                        <h1>{{$user->name or 'Venom' }}</h1>
                    </div>

                    @if (isset($me) && isset($owner) && $owner)
                    <div role="tabpanel" class="tab-pane jumbotron" id="profile">
                        <form action="{{ route('update-user') }}" method="POST" class="stripe-block">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" value = "{{ $me->nickname or NULL }}" name = "nickname" class="form-control" placeholder="nickname">
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" value = "{{ $me->name or NULL }}" name = "name" class="form-control" placeholder="Blog Name">
                                </div>
                            </div>
                            <br/>
                            <select class="form-control">
                              <option>Cosmo</option>
                              <option>Flatly</option>
                            </select>
                            <br/>
                            <div class="text-right">
                                <button type="submit" class="btn btn-default btn-xs">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
              </div>
            </div>
        <!-- End Header -->
        
        @yield('content')
        
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/pretty-request.js') }}"></script>
  </body>
</html>
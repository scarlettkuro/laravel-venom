<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Bootstrap 101 Template</title>
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
                    @if ($owner)
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Заголовок</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Налаштування</a></li>
                    @endif
                    @if ($me)
                        @if (!$owner)
                        <li role="presentation"><a href="{{ route('blog',['nickname'=>$me->nickname]) }}">{{ $me->name }}</a></li>
                        @else
                        <li role="presentation"><a href="{{ route('home') }}"> Головна </a></li>
                        @endif
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

                    @if ($user)
                    <div role="tabpanel" class="tab-pane jumbotron" id="profile">
                        <form action="{{ route('update-user') }}" method="POST" class="stripe-block">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-xs-6">
                                    <input type="text" value = "{{ $user->nickname or NULL }}" name = "nickname" class="form-control" placeholder="nickname">
                                </div>
                                <div class="col-xs-6">
                                    <input type="text" value = "{{ $user->name or NULL }}" name = "name" class="form-control" placeholder="Blog Name">
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
        @if ($owner)
        <!-- New Post Form -->
            <form action="{{ route('create-post') }}" method="POST" class="stripe-block">
                {{ csrf_field() }}
                <div>
                    <textarea class="form-control" style="resize: vertical" name ="text" rows="3" maxlength="15"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </div>
            </form>
        <!-- End New Post Form -->
        @endif
        @forelse ($posts as $post)
        <!-- Post -->
            <div class="panel panel-warning stripe-block">
            <!-- Post Header -->
                <div class="panel-heading">
                        <div class="row">
                            <div class="col-lg-10 ">
                                Мозок у колбі
                            </div>
                        @if ($user)
                        <!-- Button Panel -->
                            <div class="col-lg-2 text-right">
                                <span aria-hidden="true" class="glyphicon glyphicon-edit"></span>
                                <span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span>
                                <span aria-hidden="true" class="hidden glyphicon glyphicon-eye-close"></span>
                                <a href="{{route('delete-post', ['id' => $post->id])}}"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></a>
                            </div>
                        <!-- End Button Panel -->
                        @endif
                        </div>
                </div>
            <!-- Post Body -->
                <div class="panel-body">
                        {{ $post-> text }}
                </div>
            <!-- Post Footer -->
                <div class="panel-footer">
                    @if (isset($main) && $main)
                    <div class="row">
                        <div class="col-lg-6 text-left">
                            <a href="{{ route('blog',['nickname'=>$post->user->nickname]) }}">{{$post->user->name }}</a>
                        </div>
                        <div class="col-lg-6 text-right">
                            <small>{{$post->created_at}}</small>
                        </div>
                    </div>
                    @else
                        <small>{{$post->created_at}}</small>
                    @endif
                </div>
            </div>
        <!-- End Post -->
        @empty
        <div class="panel panel-warning stripe-block">
        <!-- Post Body -->
            <div class="panel-body text-center">
                <p>Записів поки що немає</p>
            </div>
        </div>
        @endforelse
        <!-- Pagination -->
            <nav>
              <ul class="pager">
                @if ($posts->previousPageUrl())
                    <li class="previous"><a href="{{ route('blog', ['nickname' => $user->nickname, 'page' => $page > 2 ? $page - 1 : NULL]) }}"><span aria-hidden="true">&larr;</span> Пізніше</a></li>
                @endif
                @if ($posts->nextPageUrl())
                    <li class="next"><a href="{{ route('blog', ['nickname' => $user->nickname, 'page' => $page + 1]) }}">Newer <span aria-hidden="true">&rarr;</span></a></li>
                @endif
              </ul>
            </nav>
        <!-- End Pagination -->
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
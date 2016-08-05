@extends('main')

@section('content')

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
                            {{ $post->title }}
                        </div>
                    @if ($owner)
                    <!-- Button Panel -->
                        <div class="col-lg-2 text-right">
                            <a href="{{route('edit-post', ['id' => $post->id])}}">
                                <span aria-hidden="true" class="glyphicon glyphicon-edit"></span>
                            </a>
                            <a href="{{route('private-post', ['id' => $post->id])}}">
                                <span aria-hidden="true" class="glyphicon 
                                    @if ($post->private)
                                      glyphicon-eye-close
                                    @else
                                      glyphicon-eye-open
                                    @endif
                                "></span>
                            </a>
                            <a href="{{route('delete-post', ['id' => $post->id])}}">
                                <span aria-hidden="true" class="glyphicon glyphicon-remove"></span>
                            </a>
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
    @if (!isset($main) || !$main)
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
    @endif
    </div>

@endsection
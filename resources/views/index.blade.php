@extends('layouts.main')

@section('content')

    @if ($owner)
    <!-- New Post Form -->
        <form action="{{ route('create-post') }}" method="POST" class="stripe-block">
            {{ csrf_field() }}
            <div>
                <textarea class="form-control" style="resize: vertical" name ="text" rows="3" maxlength="2000"></textarea>
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
        @include('post.read', ['post' => $post])
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
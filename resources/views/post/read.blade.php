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
                        <a aria-hidden="true" class="glyphicon glyphicon-edit"
                           href="{{route('edit-post', ['nickname'=> $post->user->nickname, 'id' => $post->id])}}">
                        </a>
                        <a aria-hidden="true" class="pretty-request glyphicon
                                @if ($post->private)
                                  glyphicon-eye-close
                                @else
                                  glyphicon-eye-open
                                @endif
                            " href="{{route('private-post', ['id' => $post->id])}}">
                        </a>
                        <a aria-hidden="true" class="glyphicon glyphicon-remove" 
                           href="{{route('delete-post', ['id' => $post->id])}}">
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
                    <small><a href="{{route('edit-post', ['nickname'=> $post->user->nickname, 'id' => $post->id])}}">{{$post->created_at}}</a></small>
                </div>
            </div>
            @else
                <small><a href="{{route('read-post', ['nickname'=> $post->user->nickname, 'id' => $post->id])}}">{{$post->created_at}}</a></small>
            @endif
        </div>
    </div>
<!-- End Post -->
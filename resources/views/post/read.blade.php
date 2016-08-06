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
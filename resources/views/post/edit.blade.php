
<!-- Post -->
<form action="{{ route('update-post', ['id' => $post->id]) }}" method="POST" class="stripe-block">
    {{ csrf_field() }}
    <div class="panel panel-warning stripe-block">
    <!-- Post Header -->
        <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-10 ">
                        <input type="text" value = "{{ $post->title }}" name = "title" maxlength="100" class="form-control" placeholder="Заголовок">
                    </div>
                <!-- Button Panel -->
                    <div class="col-lg-2 text-right">
                        <a aria-hidden="true" class="pretty-request glyphicon
                                @if ($post->private)
                                  glyphicon-eye-close
                                @else
                                  glyphicon-eye-open
                                @endif
                            " href="{{route('private-post', ['id' => $post->id])}}">
                        </a>
                        <a href="{{route('delete-post', ['id' => $post->id])}}"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></a>
                    </div>
                <!-- End Button Panel -->
                </div>
        </div>
    <!-- Post Body -->
        <div class="panel-body">
            <div>
                <textarea class="form-control" style="resize: vertical" name ="text" rows="3" maxlength="2000">{{ $post-> text }}</textarea>
            </div>

        </div>
    <!-- Post Footer -->
        <div class="panel-footer">
            <div class="row">
                <div class="col-lg-6 text-left">
                    <small>{{$post->created_at}}</small>
                </div>
                <div class="col-lg-6 text-right">
                    <button type="submit" class="btn btn-default btn-xs">
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>
<!-- End Post -->
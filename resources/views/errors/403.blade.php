@extends('layouts.error', ['code' => 403])

@section('content')
    <div class="panel panel-warning stripe-block">
    <!-- Post Body -->
        <div class="panel-body text-center">
            <h2>Помилка 403!</h2>
            <p>Сторінка недоступна для вас</p>
        </div>
    </div>
@endsection
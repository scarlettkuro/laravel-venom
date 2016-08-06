@extends('layouts.error', ['code' => 404])

@section('content')
    <div class="panel panel-warning stripe-block">
    <!-- Post Body -->
        <div class="panel-body text-center">
            <h2>Помилка 404!</h2>
            <p>Такої сторінки не знайдено</p>
        </div>
    </div>
@endsection
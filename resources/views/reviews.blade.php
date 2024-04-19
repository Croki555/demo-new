<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Отзывы</title>
    <link rel="stylesheet" href="{{ route('home') }}/css/bootstrap.css">
</head>
<body>
@include('partials.header')
<main>
    <section class="py-5">
        <div class="container-xxl">
            <h1 class="mb-3 pb-2 border-bottom">Отзывы</h1>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <div class="row row-cols-1 row-cols-md-2 g-4">
                @foreach($orders as $order)
                    <div class="col">
                        <div class="card m-auto" style="width: 18rem;">
                            <img src="{{ route('home') }}/{{ $order->image_path }}" class="card-img-top" alt="{{ $order->title }}" style="height: 150px;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $order->title }}</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="{{ route('order.get', ['id'=> $order->id]) }}" class="btn btn-primary">Перейти к заявке</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
</main>
<script src="{{ route('home') }}/js/bootstrap.js"></script>
<script src="{{ route('home') }}/js/jquery.js"></script>
</body>
</html>

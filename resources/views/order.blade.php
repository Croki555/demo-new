<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Просмотр заявки</title>
    <link rel="stylesheet" href="{{ route('home') }}/css/bootstrap.css">
</head>
<body>
@include('partials.header')
<main>
    <section class="py-5">
        <div class="container-xxl">
            <h1 class="mb-3 pb-2 border-bottom">Просмотр заявки</h1>
            <div class="mb-4">
                <div>
                    <p>id: <span class="text-muted">{{ $order->id }}</span></p>
                    <p>Пользователь: <span class="text-muted">{{ $order->user->name }}</span></p>
                    <p>Статус: <span class="text-muted">{{ $order->status->title }}</span></p>
                    <p>Название: <span class="text-muted">{{ $order->title }}</span></p>
                    <p>Категория: <span class="text-muted">{{ $order->category->title }}</span></p>
                    <p>Фото:
                        <span>
                            <img style="width: 30px; height: 30px" src="{{ route('home') }}/{{ $order->image_path }}" class="d-inline-block" alt="{{ $order->title }}">
                        </span>
                    </p>
                    <p>Дата: <span class="text-muted">{{ $order->date }}</span></p>
                    <p>Дата создания: <span class="text-muted">{{ $order->created_at }}</span></p>
                    <p>Последнее обновление: <span class="text-muted">{{ $order->updated_at }}</span></p>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="{{ route('home') }}/js/bootstrap.js"></script>
<script src="{{ route('home') }}/js/jquery.js"></script>
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="{{ route('home') }}/css/bootstrap.css">
</head>
<body>
@include('partials.header')
<main>
    <section class="py-5">
        <div class="container-xxl">
            <h1 class="mb-3 pb-2 border-bottom">Личный кабинет: {{ auth()->user()->name }}</h1>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @foreach($days as $day)
                <a href="{{ route('profile') }}?day={{ $day->created_at->format('d') }}">{{ $day->created_at->format('d') }}</a>
            @endforeach
            <div class="mb-4">
                @if(count($orders) > 0)
                    <ul class="list-group list-group-numbered list-group-horizontal gap-2">
                        <li class="list-inline-item">
                            <a href="{{ route('profile') }}">Все</a>
                        </li>
                        @foreach($statuses as $status)
                            <li class="list-inline-item">
                                <a href="{{ route('profile', ['status' => $status->id]) }}">{{ $status->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="table-responsive">
                        <table class="table align-middle table-sm">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Фото</th>
                                <th>Статус</th>
                                <th>Категория</th>
                                <th>Время</th>
                                <th>Действие</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr class="position-relative">
                                    <td>{{ $order->title }}</td>
                                    <td>
                                        <img style="width: 30px; height: 30px" src="{{ route('home') }}/{{ $order->image_path }}" class="d-inline-block" alt="{{ $order->title }}">
                                    </td>
                                    <td>{{ $order->status->title }}</td>
                                    <td>{{ $order->category->title }}</td>
                                    <td>{{ $order->date }}</td>
                                    <td>
                                        <a class="btn p-0 px-2" href="{{ route('order.get', ['id'=> $order->id]) }}">🔍</a>
                                        @if($order->status_id == 1)
                                            <form class="d-inline" action="{{ route('order.delete', ['id'=> $order->id]) }}" method="post">
                                                @csrf
                                                <button class="btn p-0 px-2" onclick="this.closest('form').submit()">🗑️</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="d-flex flex-wrap gap-5">
                <div class="flex-grow-1">
                    <h2 class="mb-2 pb-2 border-bottom" id="create-order">Создание заявки</h2>
                    <form class="order-create-Form" action="{{ route('order.store') }}" style="max-width: 350px" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="orderTitle">Название</label>
                            <input class="form-control" type="text" name="orderTitle" id="orderTitle" value="Название 1">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="orderCategory">Категория</label>
                            <select class="form-select" name="orderCategory" id="orderCategory">
                                <option selected disabled>Категории</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="orderImage">Фото</label>
                            <input class="form-control" type="file" name="orderImage" id="orderImage" accept=".png, .jpg, .jpeg, .bmp" maxlength="10*1024">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="orderDate">Дата</label>
                            <input class="form-control" type="date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" name="orderDate" id="orderDate">
                            <span class="invalid-feedback"></span>
                        </div>
                        <button class="btn btn-success" type="submit">Создать заявку</button>
                    </form>
                </div>
                <div class="flex-grow-1">
                    <h2 class="mb-2 pb-2 border-bottom" id="create-order">Смена пароля</h2>
                    <form class="edit-pass-form" style="max-width: 350px" action="{{ route('reset-password') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" for="currentPassword">Текущий пароль</label>
                            <input class="form-control" type="password" name="currentPassword" id="currentPassword">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Новый пароль</label>
                            <input class="form-control" type="password" name="password" id="password">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Повтор пароля</label>
                            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                            <span class="invalid-feedback"></span>
                        </div>
                        <button class="btn btn-success" type="submit">Изменить пароль</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="{{ route('home') }}/js/bootstrap.js"></script>
<script src="{{ route('home') }}/js/jquery.js"></script>
<script>
    $(document).ready(function () {
        //
        $('.order-create-Form').on('submit', function (ev) {
            ev.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                  window.location.href = response.status;
                },
                error: function (data) {
                    const errors = data.responseJSON.errors;
                    $('.order-create-Form input').removeClass('is-invalid');
                    $('.order-create-Form select').removeClass('is-invalid');
                    $.each(errors, function (key, val) {
                        const nextSibling = $(`#${key}`).next();
                        $(`#${key}`).addClass('is-invalid');
                        $(nextSibling).text(errors[key]);
                    });
                }
            })
        })

        $('.edit-pass-form').on('submit', function (ev) {
            ev.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    window.location.href = response.status;
                },
                error: function (data) {
                    const errors = data.responseJSON.errors;
                    $('.edit-pass-form input').removeClass('is-invalid');
                    $.each(errors, function (key, val) {
                        const nextSibling = $(`#${key}`).next();
                        $(`#${key}`).addClass('is-invalid');
                        $(nextSibling).text(errors[key]);
                    });
                }
            })
        })
    })
</script>
</body>
</html>

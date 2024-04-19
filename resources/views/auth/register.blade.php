<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Регистрация</title>
    <link rel="stylesheet" href="{{ route('home') }}/css/bootstrap.css">
</head>
<body>
@include('partials.header')
<main>
    <section class="py-5">
        <div class="container-xxl">
            <h1 class="mb-3">Регистрация</h1>
            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <form class="form-register" style="max-width: 300px" action="{{ route('register') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="name">ФИО</label>
                    <input class="form-control" type="text" name="name" id="name">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="login">Логин</label>
                    <input class="form-control" type="text" name="login" id="login">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">Почта</label>
                    <input class="form-control" type="eamil" name="email" id="email">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="phone">Телефон</label>
                    <input class="form-control" type="text" name="phone" id="phone">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Пароль</label>
                    <input class="form-control" type="password" name="password" id="password">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">Повтор пароля</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                    <span class="invalid-feedback"></span>
                </div>
                <button class="btn btn-primary" type="submit">Войти</button>
            </form>
        </div>
    </section>
</main>
<script src="{{ route('home') }}/js/bootstrap.js"></script>
<script src="{{ route('home') }}/js/jquery.js"></script>
<script>
    $(document).ready(function () {
        $('.form-register').on('submit', function (ev) {
            ev.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                type: 'post',
                data: formData,
                success: function (response) {
                    window.location.href = response.status;
                },
                error: function (data) {
                    const errors = data.responseJSON.errors;
                    $('input').removeClass('is-invalid')
                    $.each(errors, function (key, val) {
                        let nextSibling = $(`#${key}`).next();
                        $(`#${key}`).addClass('is-invalid')
                        $(nextSibling).text(errors[key]);
                    });
                }
            })
        });
    })
</script>
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Авторизация</title>
    <link rel="stylesheet" href="{{ route('home') }}/css/bootstrap.css">
</head>
<body>
@include('partials.header')
<main>
    <section class="py-5">
        <div class="container-xxl">
            <h1 class="mb-3">Авторизация</h1>
            <form class="login-form" style="max-width: 300px" action="{{ route('login') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="login">Логин</label>
                    <input class="form-control" type="text" required name="login" id="login">
                    <span class="invalid-feedback"></span>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">Пароль</label>
                    <input class="form-control" type="password" required name="password" id="password">
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
        $('.login-form').on('submit', function (ev) {
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
                    const error = data.responseJSON.error;
                    if(error) {
                        const nextSibling = $('#login').addClass('is-invalid').next();
                        $('#login').addClass('is-invalid');
                        $(nextSibling).text(error);
                    }
                }
            })
        });
    })
</script>
</body>
</html>


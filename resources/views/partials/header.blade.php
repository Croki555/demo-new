<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Ninth navbar example">
        <div class="container-xl">
            <a class="navbar-brand" href="#">Логотип</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample07XL" aria-controls="navbarsExample07XL" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsExample07XL">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reviews') }}">Отзывы</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Авторизация</a>
                    </li>
                    @endguest
                    @auth
                        @if(auth()->user()->is_admin === 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('admin')}}">Админка</a>
                            </li>
                            @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('profile')}}">Личный кабинет</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="nav-link" onclick="this.closest('form').submit()">Выйти</button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
</header>

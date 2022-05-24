<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
</head>
<body>

    <div class="container col-6">

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item text-uppercase">
                            <a class="nav-link {{ route('index') == url()->current() ? 'active' : '' }}" href="{{ route('index') }}" >Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ route('goods.index') == url()->current() ? 'active' : '' }}" href="{{ route('goods.index') }}">Справочник товаров</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ route('manufactures.index') == url()->current() ? 'active' : '' }}" href="{{ route('manufactures.index') }}">Справочник производителей</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    @yield('content')

    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('custom_js')
</body>
</html>



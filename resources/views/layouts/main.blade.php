<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&family=Noto+Kufi+Arabic:wght@100..900&family=Noto+Naskh+Arabic:wght@400..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>مكتبة حسوب</title>

    <style>
        body {
            font-family: "Cairo", sans-serif;
            background-color: #f0f0f0;
        }

        .score {
            display: block;
            font-size: 16px;
            position: relative;
            overflow: hidden;
        }
        .score-wrap {
            display: inline-block;
            position: relative;
            height: 19px;
        }

        .score .stars-active {
            color: #FFCA00;
            position: relative;
            z-index: 10;
            display: block;
            overflow: hidden; 
            white-space: nowrap; 
        }

        .score .stars-inactive {
            color: lightgrey;
            position: absolute;
            top: 0; 
            left: 0;
        }

        .rating {
            overflow: hidden;
            display: inline-block;
            position: relative;
            Font-size:20px;
            color: #FFCA00;
        }

        .rating-star {
            padding: 0 5px;
            margin: 0;
            cursor: pointer;
            display: block;
            float: left;
        }

        .rating-star:after {
            position: relative;
            font-family: "Font Awesome 5 Free";
            Content:'\f005'; 
            color: lightgrey;
        }

        .rating-star.checked ~ .rating-star:after,
        .rating-star.checked:after {
            content:'\f005';
            color: #FFCA00;
        }

        .rating:hover .rating-star:after {
            content:'\f005';
            color: lightgrey;
        }

        .rating-star:hover ~ .rating-star:after,
        .rating .rating-star:hover:after {
            content:'\f005';
            color: #FFCA00;
        }

        .bg-cart {
            background-color: #ffc107;
            color: #fff
        }

    </style>

    @yield('head')
</head>
<body style="text-align: right">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">مكتبة حسوب</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-auto">
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cart.view') }}">
                            @if(Auth::user()->booksInCart()->count() > 0)
                                <span class="badge bg-secondary">{{ Auth::user()->booksInCart()->count() }}</span>
                            @else
                                <span class="badge bg-secondary">0</span>
                            @endif
                                العربة
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                @endauth
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('gallery.categories.index') }}">
                        التصنيفات
                        <i class="fas fa-list"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('gallery.publishers.index') }}">
                        الناشرون
                        <i class="fas fa-table"></i>
                    </a>   
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('gallery.authors.index') }}">
                        المؤلفون
                        <i class="fas fa-pen"></i>
                    </a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('my.products') }}">
                        مشترياتي 
                        <i class="fas fa-basket-shopping"></i>
                    </a>
                </li>
                @endauth
            </ul>
            <ul class="navbar-nav mr-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('تسجيل الدخول') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('إنشاء حساب') }}</a>
                        </li>
                    @endif
                @else
                <li class="nav-item dropdown justify-content-left">
                    <a href="#" id="navbarDropdown" data-bs-toggle="dropdown">
                        <img class="rounded-circle object-fit-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-left text-right mt-2">
                        <ul class="list-group list-group-flush pe-0">
                            @can('update-books')
                                <li class="list-group-item px-3 py-2">
                                    <a href="{{ route('admin.index') }}" class="text-decoration-none text-dark">لوحة الإدارة</a>
                                </li>
                            @endcan
                            <li class="list-group-item px-3 py-2">
                                <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark {{request()->routeIs('profile.show') ? 'fw-bold' : ''}}" >
                                    الملف الشخصي
                                </a>
                            </li> 
                            <li class="list-group-item px-3 py-2">
                                 <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
                                    <button type="submit" class="btn btn-link text-decoration-none text-dark p-0">
                                        تسجيل خروج
                                    </button>
                                 </form>
                            </li> 
                        </ul>
  
                    </div>
                </li>
                @endguest
            </ul>
            </div>
        </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    @yield('script')
</body>
</html>
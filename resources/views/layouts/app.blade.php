<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'أركان الأسرة')</title>
    <link rel="icon" href="{{ asset('logo.jpg') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #145b9b;
            --primary-dark: #0e4271;
            --dark: #1a1a1a;
            --white: #ffffff;
            --gray: #f4f4f4;
            --text-color: #333;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f9f9f9;
            color: var(--text-color);
        }

        /* ===== Navbar ===== */
        .navbar {
            background: var(--white);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 10px 0;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .logo-area img {
            height: 60px;
        }

        .nav-menu {
            list-style: none;
            display: flex;
            gap: 25px;
            margin: 0;
            padding: 0;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: var(--dark);
            font-weight: 700;
            transition: 0.3s;
            font-size: 1rem;
            white-space: nowrap;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            color: var(--primary);
        }

        .btn-auth {
            padding: 8px 18px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
            white-space: nowrap;
        }

        .btn-login {
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-login:hover {
            background: var(--primary);
            color: var(--white);
        }

        .btn-register {
            background: var(--primary);
            color: var(--white);
            border: 1px solid var(--primary);
        }

        .btn-register:hover {
            background: var(--primary-dark);
        }

        @media (max-width: 768px) {
            .nav-container {
                flex-direction: column;
                gap: 15px;
            }

            .nav-menu {
                gap: 10px;
            }

            .btn-auth {
                padding: 6px 14px;
                font-size: 0.95rem;
            }
        }

        /* ===== Container ===== */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== Footer ===== */
        .footer {
            background: var(--dark);
            color: #aaa;
            padding: 40px 0;
            text-align: center;
            margin-top: auto;
        }

        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        @yield('styles')
    </style>
</head>

<body>

    {{-- Navbar --}}
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-area">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('logo.jpg') }}" alt="أركان الأسرة">
                </a>
            </div>

            <ul class="nav-menu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">الرئيسية</a>
                </li>
                <li><a href="{{ route('home') }}#products">المنتجات</a></li>

                @auth
                    <li><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit"
                                style="background:none; border:none; cursor:pointer; font-family:inherit; font-size:inherit; font-weight:700; color:var(--primary);">
                                تسجيل الخروج
                            </button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="btn-auth btn-login">دخول</a></li>
                    <li><a href="{{ route('register') }}" class="btn-auth btn-register">تسجيل جديد</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    {{-- Page Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} أركان الأسرة | منصة دعم الأسر المنتجة | كافة الحقوق محفوظة</p>
        </div>
    </footer>

    @yield('scripts')

</body>

</html>
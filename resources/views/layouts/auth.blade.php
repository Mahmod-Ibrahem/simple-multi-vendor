<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'أركان الأسرة')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #145b9b;
            --primary-dark: #0e4271;
            --dark: #1a1a1a;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
        }

        .auth-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f0eb 0%, #fefcf9 50%, #f0e6d9 100%);
            padding: 30px 20px;
            position: relative;
            overflow: hidden;
        }

        .auth-section::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(20, 91, 155, 0.08) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
        }

        .auth-section::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(20, 91, 155, 0.06) 0%, transparent 70%);
            bottom: -80px;
            left: -80px;
            border-radius: 50%;
        }

        .auth-card {
            background: var(--white);
            width: 100%;
            max-width: 480px;
            padding: 45px 40px;
            border: 1px solid #e8e0d8;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(20, 91, 155, 0.05);
            position: relative;
            z-index: 1;
        }

        .auth-logo {
            height: 90px;
            margin-bottom: 20px;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.08));
        }

        .auth-card h2 {
            font-weight: 900;
            color: var(--dark);
            margin-bottom: 6px;
            font-size: 1.6rem;
        }

        .auth-card .auth-subtitle {
            color: #888;
            margin-bottom: 30px;
            font-size: 0.95rem;
        }

        .form-group {
            text-align: right;
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--dark);
            font-size: 0.9rem;
        }

        .input-style {
            width: 100%;
            padding: 14px 16px;
            border: 1.5px solid #e1e8f0;
            border-radius: 10px;
            background: #fafafa;
            font-family: 'Cairo', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-style:focus {
            border-color: var(--primary);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(20, 91, 155, 0.1);
        }

        .input-style::placeholder {
            color: #bbb;
        }

        .btn-submit {
            width: 100%;
            margin: 15px 0 0 0;
            background: linear-gradient(135deg, var(--dark) 0%, #2d2d2d 100%);
            color: var(--white);
            border: none;
            padding: 16px;
            font-weight: bold;
            font-size: 1rem;
            font-family: 'Cairo', sans-serif;
            cursor: pointer;
            transition: all 0.4s ease;
            border-radius: 10px;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(20, 91, 155, 0.25);
        }

        .auth-links {
            margin-top: 22px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .auth-link {
            color: #888;
            font-size: 0.9rem;
            transition: 0.3s;
            text-decoration: none;
        }

        .auth-link:hover {
            color: var(--primary);
        }

        .auth-link.highlight {
            color: var(--primary);
            font-weight: 700;
        }

        .auth-divider {
            color: #ddd;
            user-select: none;
        }

        /* Validation errors */
        .alert-errors {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: right;
        }

        .alert-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-errors li {
            color: #dc2626;
            font-size: 0.85rem;
            padding: 2px 0;
        }

        /* Success message */
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
            border-radius: 10px;
            padding: 12px 20px;
            margin-bottom: 20px;
            font-weight: 700;
            font-size: 0.9rem;
        }

        @yield('auth-styles')
    </style>
</head>

<body>

    @yield('content')

</body>

</html>
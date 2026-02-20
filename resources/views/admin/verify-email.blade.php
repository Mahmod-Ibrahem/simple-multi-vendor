@extends('layouts.auth')

@section('title', 'تأكيد البريد الإلكتروني | أركان الأسرة')

@section('auth-styles')
    .verify-icon {
    font-size: 60px;
    margin-bottom: 15px;
    }

    .btn-resend {
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
    }

    .btn-resend:hover {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(223, 127, 17, 0.25);
    }

    .logout-link {
    display: inline-block;
    margin-top: 10px;
    color: #dc2626;
    font-size: 0.85rem;
    transition: 0.3s;
    font-family: 'Cairo', sans-serif;
    background: none;
    border: none;
    cursor: pointer;
    text-decoration: underline;
    }

    .logout-link:hover {
    color: #991b1b;
    }
@endsection

@section('content')
    <section class="auth-section">
        <div class="auth-card">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" class="auth-logo">

            <div class="verify-icon">📧</div>

            <h2>تأكيد البريد الإلكتروني</h2>
            <p class="auth-subtitle" style="line-height: 1.8;">
                شكراً لتسجيلك! قبل البدء، يرجى التحقق من عنوان بريدك الإلكتروني
                بالنقر على الرابط الذي أرسلناه إليك. إذا لم تستلم البريد، سنرسل لك رابطاً جديداً بكل سرور.
            </p>

            @if (session('message'))
                <div class="alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-resend">إعادة إرسال رابط التحقق</button>
            </form>

            <div class="auth-links">
                <a href="{{ url('/') }}" class="auth-link">العودة للرئيسية</a>
            </div>

            <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-top: 10px;">
                @csrf
                <button type="submit" class="logout-link">تسجيل الخروج</button>
            </form>
        </div>
    </section>
@endsection
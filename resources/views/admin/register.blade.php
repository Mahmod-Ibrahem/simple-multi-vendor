@extends('layouts.auth')

@section('title', 'تسجيل حساب جديد | أركان الأسرة')

@section('content')
    <section class="auth-section">
        <div class="auth-card" style="max-width: 520px;">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" class="auth-logo">

            <h2>إنشاء حساب جديد</h2>
            <p class="auth-subtitle">سجل بياناتك للانضمام إلى أركان الأسرة</p>

            @if ($errors->any())
                <div class="alert-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="text" name="name" class="input-style" placeholder="الاسم الكامل" value="{{ old('name') }}"
                        required>
                </div>

                <div class="form-group">
                    <label>رقم الجوال</label>
                    <input type="tel" name="phone" class="input-style" placeholder="9665xxxxxxxx" value="{{ old('phone') }}"
                        required>
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="input-style" placeholder="email@example.com"
                        value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="input-style" placeholder="********" required>
                </div>

                <div class="form-group">
                    <label>تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="input-style" placeholder="********" required>
                </div>

                <button type="submit" class="btn-submit">تسجيل حساب جديد</button>
            </form>

            <div class="auth-links">
                <a href="{{ route('login') }}" class="auth-link highlight">لديك حساب؟ سجل دخولك</a>
                <span class="auth-divider">|</span>
                <a href="{{ url('/') }}" class="auth-link">العودة للرئيسية</a>
            </div>
        </div>
    </section>
@endsection
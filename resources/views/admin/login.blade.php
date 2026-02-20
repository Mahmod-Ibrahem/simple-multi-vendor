@extends('layouts.auth')

@section('title', 'تسجيل الدخول | أركان الأسرة')

@section('content')
    <section class="auth-section">
        <div class="auth-card">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" class="auth-logo">

            <h2>مرحباً بك مجدداً</h2>
            <p class="auth-subtitle">سجل دخولك لإدارة متجرك ومنتجاتك في أركان الأسرة</p>

            @if ($errors->any())
                <div class="alert-errors">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>رقم الجوال</label>
                    <input type="tel" name="phone" class="input-style" placeholder="9665xxxxxxxx" value="{{ old('phone') }}"
                        required>
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="input-style" placeholder="********" required>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 8px;">
                    <input type="checkbox" name="remember" id="remember" style="accent-color: var(--primary);">
                    <label for="remember" style="margin-bottom: 0; cursor: pointer;">تذكرني</label>
                </div>

                <button type="submit" class="btn-submit">تسجيل الدخول</button>
            </form>

            <div class="auth-links">
                <a href="{{ route('register') }}" class="auth-link highlight">إنشاء حساب جديد</a>
                <span class="auth-divider">|</span>
                <a href="{{ url('/') }}" class="auth-link">العودة للرئيسية</a>
            </div>
        </div>
    </section>
@endsection
@extends('layouts.dashboard')

@section('title', 'إضافة مستخدم جديد | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>إضافة أسرة أو مستخدم جديد</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">← العودة للمستخدمين</a>
    </div>

    <div class="form-card" style="max-width: 800px;">
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>الاسم <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="name" class="form-control" placeholder="مثال: أسرة عبد الله"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني <span style="color:#dc2626;">*</span></label>
                    <input type="email" name="email" class="form-control" placeholder="user@example.com"
                        value="{{ old('email') }}" required dir="ltr" style="text-align: left;">
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>كلمة المرور <span style="color:#dc2626;">*</span></label>
                    <input type="password" name="password" class="form-control" required dir="ltr"
                        style="text-align: left;">
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الدور (Role) <span style="color:#dc2626;">*</span></label>
                    <select name="role" class="form-control" required>
                        <option value="">-- اختر الدور --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ $role->name_ar ?? $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" placeholder="مثال 2010900000"
                        value="{{ old('phone') }}" dir="ltr" style="text-align: left;">
                    @error('phone')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الشعار (Logo)</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    @error('logo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>وصف مبسط (يظهر في صفحة منتجات الأسرة)</label>
                <textarea name="brief_description" class="form-control" rows="3">{{ old('brief_description') }}</textarea>
                @error('brief_description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">حفظ المستخدم</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
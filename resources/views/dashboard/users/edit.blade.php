@extends('layouts.dashboard')

@section('title', 'تعديل المستخدم | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>تعديل: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline">← العودة للمستخدمين</a>
    </div>

    <div class="form-card" style="max-width: 800px;">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>الاسم <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني <span style="color:#dc2626;">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required
                        dir="ltr" style="text-align: left;">
                    @error('email')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" dir="ltr" style="text-align: left;">
                    <small style="color: #666;">اتركه فارغاً إذا لم ترغب بتغيير كلمة المرور.</small>
                    @error('password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الدور (Role) @if($user->id !== 1) <span style="color:#dc2626;">*</span> @endif</label>
                    <select name="role" class="form-control" {{ $user->id === 1 ? 'disabled' : 'required' }}>
                        @if($user->id !== 1)
                            <option value="">-- اختر الدور --</option>
                        @endif
                        @php
                            $userRole = current(old('role', $user->roles->pluck('name')->toArray())) ?: '';
                        @endphp
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ $userRole == $role->name ? 'selected' : '' }}>
                                {{ $role->name_ar ?? $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @if($user->id === 1)
                        <small style="color: #666;">لا يمكن تغيير دور مدير النظام الأساسي.</small>
                    @endif
                    @error('role')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" placeholder="مثال: 05xxxxxxxxx"
                        value="{{ old('phone', $user->phone) }}" dir="ltr" style="text-align: left;">
                    @error('phone')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الشعار (Logo)</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    @if($user->logo)
                        <img src="{{ Storage::url($user->logo) }}" alt="Current Logo" class="current-image" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover; margin-top: 10px; border: 1px solid #e1e8f0;">
                    @endif
                    @error('logo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>وصف مبسط (يظهر في صفحة منتجات الأسرة)</label>
                <textarea name="brief_description" class="form-control" rows="3">{{ old('brief_description', $user->brief_description) }}</textarea>
                @error('brief_description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            @if($user->id !== 1)
                <div class="form-group">
                    <label class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <span>تفعيل الحساب (يمكنه تسجيل الدخول وتمتلك منتجاته فرصة للظهور إذا نُشرت)</span>
                    </label>
                    @error('is_active')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">تحديث المستخدم</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
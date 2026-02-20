@extends('layouts.dashboard')

@section('title', 'الملف الشخصي | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>الملف الشخصي</h1>
    </div>

    <div class="form-card" style="max-width: 800px;">
        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Current Avatar Display --}}
            <div
                style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px; padding-bottom: 25px; border-bottom: 1px solid #f0f0f0;">
                <div
                    style="width: 80px; height: 80px; border-radius: 50%; overflow: hidden; background: #145b9b; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 3px solid #e1e8f0;">
                    @if($user->logo)
                        <img src="{{ $user->logo }}" alt="{{ $user->name }}"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <span style="color: white; font-size: 2rem; font-weight: 900;">{{ mb_substr($user->name, 0, 1) }}</span>
                    @endif
                </div>
                <div>
                    <div style="font-weight: 900; font-size: 1.2rem; color: var(--dark);">{{ $user->name }}</div>
                    <div style="color: #888; font-size: 0.85rem;" dir="ltr">{{ $user->email }}</div>
                    @if($user->roles->count())
                        <span class="badge badge-warning" style="margin-top: 5px;">{{ $user->roles->first()->name }}</span>
                    @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>الاسم <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" placeholder="مثال: 05xxxxxxxxx"
                        value="{{ old('phone', $user->phone) }}" dir="ltr" style="text-align: left;">
                    @error('phone')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>الشعار (Logo)</label>
                    <input type="file" name="logo" class="form-control" accept="image/*">
                    @error('logo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" dir="ltr"
                        style="text-align: left; background: #f5f5f5;">
                    <small style="color: #888;">لا يمكن تغيير البريد الإلكتروني.</small>
                </div>
            </div>

            <div class="form-group">
                <label>وصف مبسط (يظهر في صفحة منتجاتك)</label>
                <textarea name="brief_description" class="form-control" rows="3"
                    placeholder="مثال: أسرة منتجة متخصصة في الأكلات الشعبية...">{{ old('brief_description', $user->brief_description) }}</textarea>
                @error('brief_description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div style="margin-top: 35px; padding-top: 25px; border-top: 1px solid #f0f0f0;">
                <h3 style="font-size: 1rem; font-weight: 800; color: var(--dark); margin-bottom: 20px;">🔒 تغيير كلمة المرور
                </h3>

                <div class="form-group">
                    <label>كلمة المرور الحالية</label>
                    <input type="password" name="current_password" class="form-control" dir="ltr" style="text-align: left;">
                    @error('current_password')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>كلمة المرور الجديدة</label>
                        <input type="password" name="password" class="form-control" dir="ltr" style="text-align: left;">
                        @error('password')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="password_confirmation" class="form-control" dir="ltr"
                            style="text-align: left;">
                    </div>
                </div>
                <small style="color: #888;">اتركها فارغة إذا لم ترغب بتغيير كلمة المرور.</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
            </div>
        </form>
    </div>
@endsection
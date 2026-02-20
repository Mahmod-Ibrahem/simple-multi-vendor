@extends('layouts.dashboard')

@section('title', 'تعديل الصلاحية | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>تعديل: {{ $permission->name_ar ?? $permission->name }}</h1>
        <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline">← العودة للصلاحيات</a>
    </div>

    <div class="form-card" style="max-width: 600px;">
        <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>الاسم المرجعي (System Name) <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="مثال: articles.create"
                    value="{{ old('name', $permission->name) }}" required dir="ltr" style="text-align: left;">
                <small style="color: #666; display: block; margin-top: 5px;">الاسم المستخدم برمجياً باللغة
                    الإنجليزية.</small>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الاسم بالعربية للمستخدمين</label>
                <input type="text" name="name_ar" class="form-control" placeholder="مثال: إنشاء مقال"
                    value="{{ old('name_ar', $permission->name_ar) }}">
                @error('name_ar')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">تحديث الصلاحية</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
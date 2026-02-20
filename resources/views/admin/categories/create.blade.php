@extends('layouts.dashboard')

@section('title', 'إضافة تصنيف جديد | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>إضافة تصنيف جديد</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">← العودة للتصنيفات</a>
    </div>

    <div class="form-card" style="max-width: 600px;">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>عنوان التصنيف <span style="color:#dc2626;">*</span></label>
                <input type="text" name="title" class="form-control" placeholder="أدخل عنوان التصنيف"
                    value="{{ old('title') }}" required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">حفظ التصنيف</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
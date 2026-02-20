@extends('layouts.dashboard')

@section('title', 'تعديل التصنيف | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>تعديل: {{ $category->title }}</h1>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">← العودة للتصنيفات</a>
    </div>

    <div class="form-card" style="max-width: 600px;">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>عنوان التصنيف <span style="color:#dc2626;">*</span></label>
                <input type="text" name="title" class="form-control" placeholder="أدخل عنوان التصنيف"
                    value="{{ old('title', $category->title) }}" required>
                @error('title')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">تحديث التصنيف</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
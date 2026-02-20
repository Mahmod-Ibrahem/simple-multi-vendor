@extends('layouts.dashboard')

@section('title', 'إضافة منتج جديد | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>إضافة منتج جديد</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">← العودة للمنتجات</a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label>عنوان المنتج <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="أدخل عنوان المنتج"
                        value="{{ old('title') }}" required>
                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>السعر <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="price" class="form-control" placeholder="0" step="0.01"
                        value="{{ old('price') }}" required>
                    @error('price')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>التصنيف <span style="color:#dc2626;">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">اختر التصنيف</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>الكمية</label>
                    <input type="number" name="quantity" class="form-control" placeholder="0"
                        value="{{ old('quantity', 0) }}">
                    @error('quantity')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="4"
                    placeholder="أدخل وصفاً تفصيلياً للمنتج">{{ old('description') }}</textarea>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الموقع (المنطقة والحي)</label>
                <input type="text" name="locations" class="form-control" placeholder="مثال: الرياض - حي الملز"
                    value="{{ old('locations') }}">
                @error('locations')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>الصورة الرئيسية</label>
                    <input type="file" name="main_image" class="form-control" accept="image/*">
                    @error('main_image')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>صور إضافية (معرض)</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    @error('images')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="hidden" name="published" value="0">
                    <input type="checkbox" name="published" value="1" id="published" {{ old('published', 1) ? 'checked' : '' }}>
                    <label for="published" style="margin-bottom: 0; cursor: pointer;">نشر المنتج مباشرة</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">حفظ المنتج</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection
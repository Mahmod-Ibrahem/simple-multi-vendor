@extends('layouts.dashboard')

@section('title', 'تعديل المنتج | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>تعديل: {{ $product->title }}</h1>
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline">← العودة للمنتجات</a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label>عنوان المنتج <span style="color:#dc2626;">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="أدخل عنوان المنتج"
                           value="{{ old('title', $product->title) }}" required>
                    @error('title')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>السعر <span style="color:#dc2626;">*</span></label>
                    <input type="number" name="price" class="form-control" placeholder="0" step="0.01"
                           value="{{ old('price', $product->price) }}" required>
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
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                           value="{{ old('quantity', $product->quantity) }}">
                    @error('quantity')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label>الوصف</label>
                <textarea name="description" class="form-control" rows="4"
                          placeholder="أدخل وصفاً تفصيلياً للمنتج">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>الموقع (المنطقة والحي)</label>
                <input type="text" name="locations" class="form-control" placeholder="مثال: الرياض - حي الملز"
                       value="{{ old('locations', $product->locations) }}">
                @error('locations')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>الصورة الرئيسية</label>
                    <input type="file" name="main_image" class="form-control" accept="image/*">
                    @if($product->main_image)
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="الصورة الحالية" class="current-image">
                    @endif
                    @error('main_image')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>صور إضافية (معرض) — تحميل جديد يستبدل القديم</label>
                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    @if($product->images && count($product->images) > 0)
                        <div style="display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap;">
                            @foreach($product->images as $image)
                                <img src="{{ asset('storage/' . ($image['url'] ?? $image)) }}" alt="صورة المعرض" class="current-image">
                            @endforeach
                        </div>
                    @endif
                    @error('images')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="hidden" name="published" value="0">
                    <input type="checkbox" name="published" value="1" id="published"
                           {{ old('published', $product->published) ? 'checked' : '' }}>
                    <label for="published" style="margin-bottom: 0; cursor: pointer;">نشر المنتج</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">تحديث المنتج</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline">إلغاء</a>
            </div>
        </form>
    </div>
@endsection

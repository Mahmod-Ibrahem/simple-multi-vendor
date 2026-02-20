@extends('layouts.dashboard')

@section('title', 'لوحة التحكم | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>الإحصائيات والمنتجات</h1>
    </div>

    {{-- Stats Grid --}}
    <div class="stats-grid">
        <div class="stat-card">
            <h4>إجمالي المنتجات</h4>
            <div class="number">{{ $stats['products_count'] }}</div>
        </div>
        <div class="stat-card">
            <h4>المنتجات المنشورة</h4>
            <div class="number" style="color: #27ae60;">{{ $stats['published_count'] }}</div>
        </div>

        @if($isAdmin)
            <div class="stat-card">
                <h4>التصنيفات</h4>
                <div class="number">{{ $stats['categories_count'] }}</div>
            </div>
            <div class="stat-card">
                <h4>الأسر المسجلة</h4>
                <div class="number">{{ $stats['users_count'] }}</div>
            </div>
        @endif

        <div class="stat-card">
            <h4>إجمالي المشاهدات</h4>
            <div class="number" style="color: #3b82f6;">{{ $stats['total_visits'] }}</div>
        </div>
        <div class="stat-card">
            <h4>نقرات واتساب</h4>
            <div class="number" style="color: #25D366;">{{ $stats['total_whatsapp_clicks'] }}</div>
        </div>
    </div>

    {{-- Latest Products Table --}}
    <div class="data-card">
        <div class="data-card-header">
            <h2>أحدث المنتجات</h2>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline btn-sm">عرض الكل</a>
        </div>
        <div class="data-card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>التصنيف</th>
                        <th>الحالة</th>
                        <th>الكمية</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestProducts as $product)
                        <tr>
                            <td style="font-weight: 700;">{{ $product->title }}</td>
                            <td>{{ number_format($product->price, 0) }} ر.س</td>
                            <td>{{ $product->category?->title ?? '—' }}</td>
                            <td>
                                @if($product->published)
                                    <span class="badge badge-success">منشور</span>
                                @else
                                    <span class="badge badge-warning">مسودة</span>
                                @endif
                            </td>
                            <td>{{ $product->quantity ?? 0 }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="emoji">📦</div>
                                <p>لا توجد منتجات بعد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
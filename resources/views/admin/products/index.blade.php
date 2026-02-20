@extends('layouts.dashboard')

@section('title', 'إدارة المنتجات | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>@role('مدير النظام') إدارة المنتجات @else منتجاتي @endrole</h1>
        @can('create', App\Models\Product::class)
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <span>➕</span>
            إضافة منتج جديد
        </a>
        @endcan
    </div>

    <div class="data-card">
        <div class="data-card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>التصنيف</th>
                        <th>الحالة</th>
                        <th>الكمية</th>
                        <th>تاريخ الإضافة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>
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
                            <td>{{ $product->created_at->format('Y/m/d') }}</td>
                            <td>
                                <div class="actions-cell">
                                    @can('update', $product)
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-edit btn-sm">تعديل</a>
                                    @endcan
                                    @can('delete', $product)
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="empty-state">
                                <div class="emoji">📦</div>
                                <p>لا توجد منتجات بعد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $products->links() }}
@endsection
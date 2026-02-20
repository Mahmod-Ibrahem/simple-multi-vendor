@extends('layouts.dashboard')

@section('title', 'إدارة التصنيفات | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>إدارة التصنيفات</h1>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <span>➕</span>
            إضافة تصنيف جديد
        </a>
    </div>

    <div class="data-card">
        <div class="data-card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>عدد المنتجات</th>
                        <th>تاريخ الإضافة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                            <td style="font-weight: 700;">{{ $category->title }}</td>
                            <td>{{ $category->products_count ?? $category->products()->count() }}</td>
                            <td>{{ $category->created_at->format('Y/m/d') }}</td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="btn btn-edit btn-sm">تعديل</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="emoji">🏷️</div>
                                <p>لا توجد تصنيفات بعد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $categories->links() }}
@endsection
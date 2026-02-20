@extends('layouts.dashboard')

@section('title', 'إدارة الصلاحيات | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>إدارة الصلاحيات</h1>
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">
            <span>➕</span>
            إضافة صلاحية جديدة
        </a>
    </div>

    <div class="data-card">
        <div class="data-card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم المرجعي (System)</th>
                        <th>الاسم بالعربية</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permissions as $permission)
                        <tr>
                            <td>{{ $loop->iteration + ($permissions->currentPage() - 1) * $permissions->perPage() }}</td>
                            <td dir="ltr" style="text-align: right;"><code>{{ $permission->name }}</code></td>
                            <td style="font-weight: 700;">{{ $permission->name_ar ?? '—' }}</td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.permissions.edit', $permission) }}"
                                        class="btn btn-edit btn-sm">تعديل</a>
                                    <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد من حذف هذه الصلاحية؟ لا يمكن التراجع عن هذه العملية.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty-state">
                                <div class="emoji">🔑</div>
                                <p>لا توجد صلاحيات بعد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $permissions->links() }}
@endsection
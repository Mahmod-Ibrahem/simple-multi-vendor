@extends('layouts.dashboard')

@section('title', 'إدارة الأدوار | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>إدارة الأدوار</h1>
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
            <span>➕</span>
            إضافة دور جديد
        </a>
    </div>

    <div class="data-card">
        <div class="data-card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الدور</th>
                        <th>عدد المستخدمين</th>
                        <th>تاريخ الإضافة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</td>
                            <td style="font-weight: 700;">{{ $role->name }}</td>
                            <td>
                                <span class="badge badge-success">{{ $role->users_count }} مستخدم</span>
                            </td>
                            <td>{{ $role->created_at->format('Y/m/d') }}</td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-edit btn-sm">تعديل</a>
                                    @if(in_array($role->name, ['Super Admin', 'Admin', 'مدير النظام', 'مشرف']))
                                        <button class="btn btn-danger btn-sm" disabled
                                            style="opacity: 0.5; cursor: not-allowed;">حذف</button>
                                    @else
                                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا الدور؟ لا يمكن التراجع عن هذه العملية.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty-state">
                                <div class="emoji">🛡️</div>
                                <p>لا توجد أدوار بعد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $roles->links() }}
@endsection
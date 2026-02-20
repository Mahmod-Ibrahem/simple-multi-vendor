@extends('layouts.dashboard')

@section('title', 'إدارة المستخدمين والأسر | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>إدارة المستخدمين والأسر</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <span>➕</span>
            إضافة مستخدم جديد
        </a>
    </div>

    <div class="data-card">
        <div class="data-card-body">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد الإلكتروني / الجوال</th>
                        <th>الأدوار (Roles)</th>
                        <th>عدد المنتجات</th>
                        <th>تاريخ الإضافة</th>
                        <th>الحالة</th>
                        <th>العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td style="font-weight: 700;">{{ $user->name }}</td>
                            <td dir="ltr" style="text-align: right;">{{ $user->email ?? $user->phone }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge badge-warning">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <span class="badge badge-success">{{ $user->products_count ?? 0 }} منتج</span>
                            </td>
                            <td>{{ $user->created_at->format('Y/m/d') }}</td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge badge-success">نشط</span>
                                @else
                                    <span class="badge badge-danger">غير نشط</span>
                                @endif
                            </td>
                            <td>
                                <div class="actions-cell">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-edit btn-sm">تعديل</a>

                                    @if($user->id !== 1)
                                        @if(!$user->email_verified_at)
                                            <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm"
                                                    style="background: #0284c7; border: 1px solid #0284c7;">توثيق</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من تغيير حالة هذا المستخدم؟');">
                                            @csrf
                                            <button type="submit"
                                                class="btn {{ $user->is_active ? 'btn-danger' : 'btn-success' }} btn-sm"
                                                style="background: {{ $user->is_active ? '#f59e0b' : '#10b981' }}; border: none; color: white;">
                                                {{ $user->is_active ? 'تعطيل' : 'تفعيل' }}
                                            </button>
                                        </form>
                                    @endif

                                    @if($user->id === 1 || $user->id === auth()->id())
                                        <button class="btn btn-danger btn-sm" disabled
                                            style="opacity: 0.5; cursor: not-allowed;">حذف</button>
                                    @else
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم وكل ما يتعلق به؟');">
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
                            <td colspan="8" class="empty-state">
                                <div class="emoji">👨‍👩‍👧‍👦</div>
                                <p>لا يوجد مستخدمون بعد</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links() }}
@endsection
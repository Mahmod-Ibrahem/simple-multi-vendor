@extends('layouts.dashboard')

@section('title', 'تعديل الدور | أركان الأسرة')

@section('content')
    <div class="page-header">
        <h1>تعديل: {{ $role->name }}</h1>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline">← العودة للأدوار</a>
    </div>

    <form action="{{ route('admin.roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-card" style="margin-bottom: 20px;">
            <div class="form-group" style="max-width: 600px;">
                <label>اسم الدور <span style="color:#dc2626;">*</span></label>
                <input type="text" name="name" class="form-control" placeholder="أدخل اسم الدور"
                    value="{{ old('name', $role->name) }}" required>
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="data-card">
            <div class="data-card-header">
                <h2>صلاحيات الدور</h2>
            </div>
            <div class="data-card-body" style="padding: 20px;">
                <div class="form-row" style="grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));">
                    @php
                        $rolePermissions = $role->permissions->pluck('name')->toArray();
                    @endphp
                    @foreach($permissions as $permission)
                        <div class="form-check"
                            style="margin-bottom: 12px; background: #fafbfc; padding: 12px; border-radius: 8px; border: 1px solid #e1e8f0;">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                id="perm_{{ $permission->id }}" {{ in_array($permission->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                            <label for="perm_{{ $permission->id }}"
                                style="margin-bottom: 0; cursor: pointer; font-weight: 600;">
                                {{ $permission->name_ar ?? $permission->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('permissions')
                    <div class="form-error" style="margin-top: 15px;">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-actions" style="margin-top: 20px;">
            <button type="submit" class="btn btn-primary">تحديث الدور</button>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </form>
@endsection
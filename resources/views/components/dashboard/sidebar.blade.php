<aside class="sidebar" id="sidebar">
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}"
                class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">📊</span>
                الإحصائيات والمنتجات
            </a>
        </li>

        @can('create', App\Models\Product::class)
        <li>
            <a href="{{ route('admin.products.create') }}"
                class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                <span class="menu-icon">➕</span>
                إضافة منتج جديد
            </a>
        </li>
        @endcan

        @role('مدير النظام')
        <li>
            <a href="{{ route('admin.categories.create') }}"
                class="{{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                <span class="menu-icon">📁</span>
                إضافة تصنيف جديد
            </a>
        </li>
        <li>
            <a href="{{ route('admin.users.create') }}"
                class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                <span class="menu-icon">👨‍👩‍👧</span>
                إضافة أسرة جديدة
            </a>
        </li>
        @endrole

        <div class="sidebar-divider"></div>

        <li>
            <a href="{{ route('admin.products.index') }}"
                class="{{ request()->routeIs('admin.products.*') && !request()->routeIs('admin.products.create') ? 'active' : '' }}">
                <span class="menu-icon">📦</span>
                @role('مدير النظام')
                    إدارة المنتجات
                @else
                    منتجاتي
                @endrole
            </a>
        </li>

        @role('مدير النظام')
        <li>
            <a href="{{ route('admin.categories.index') }}"
                class="{{ request()->routeIs('admin.categories.*') && !request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                <span class="menu-icon">🏷️</span>
                إدارة التصنيفات
            </a>
        </li>

        <div class="sidebar-divider"></div>

        <li style="padding: 10px 22px 5px; color: #888; font-size: 0.8rem; font-weight: 700;">إدارة الأسر أو المستخدمين</li>
        <li>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.create') ? 'active' : '' }}">
                <span class="menu-icon">👨‍👩‍👧‍👦</span>
                المستخدمين
            </a>
        </li>

        <div class="sidebar-divider"></div>

        <li style="padding: 10px 22px 5px; color: #888; font-size: 0.8rem; font-weight: 700;">إدارة الصلاحيات</li>
        <li>
            <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                <span class="menu-icon">🛡️</span>
                الأدوار
            </a>
        </li>
        <li>
            <a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">
                <span class="menu-icon">🔑</span>
                الصلاحيات
            </a>
        </li>
        @endrole

        <div class="sidebar-divider"></div>

        <li>
            <a href="{{ route('admin.profile.edit') }}"
                class="{{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <span class="menu-icon">👤</span>
                الملف الشخصي
            </a>
        </li>
        <li class="logout-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <span class="menu-icon">🚪</span>
                    تسجيل الخروج
                </button>
            </form>
        </li>
    </ul>
</aside>
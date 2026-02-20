<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Traits\ImagesUtility;

/**
 * إدارة المستخدمين - User Management Controller
 * Admin only
 */
class UserController extends Controller
{
    use AuthorizesRequests, ImagesUtility;

    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::with('roles')->withCount('products');

        if (Auth::id() !== 1) {
            $query->where('id', '!=', 1);
        }

        $users = $query->filter($request->only(['search', 'role', 'is_active']))
            ->sorted($request->input('sort_by', 'created_at'), $request->input('sort_order', 'desc'))
            ->paginate(15);

        return view('dashboard.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        $roles = Role::all();
        return view('dashboard.users.create', compact('roles'));
    }

    /**
     * Store a newly created user.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => true,
            'phone' => $validated['phone'] ?? null,
            'brief_description' => $validated['brief_description'] ?? null,
        ];

        if ($request->hasFile('logo')) {
            $data['logo'] = $this->storeImage($request->file('logo'), 'users_logos');
        }

        $user = User::create($data);

        if (isset($validated['role'])) {
            $user->assignRole($validated['role']);
        }

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء المستخدم بنجاح.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $this->authorize('view', $user);
        $roles = Role::all();
        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        if ($user->id === 1 && Auth::user()->id !== 1) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكن تعديل مدير النظام الأساسي.');
        }

        $validated = $request->validated();

        // Update basic info
        if (isset($validated['name'])) {
            $user->name = $validated['name'];
        }
        if (isset($validated['email'])) {
            $user->email = $validated['email'];
        }
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        if (isset($validated['is_active']) && $user->id !== 1) {
            $user->is_active = $validated['is_active'];
        }
        if (array_key_exists('phone', $validated)) {
            $user->phone = $validated['phone'];
        }
        if (array_key_exists('brief_description', $validated)) {
            $user->brief_description = $validated['brief_description'];
        }
        if ($request->hasFile('logo')) {
            $user->logo = $this->storeImage($request->file('logo'), 'users_logos');
        }

        $user->save();

        // Update role if provided
        if (isset($validated['role']) && $user->id !== 1) {
            $user->syncRoles([$validated['role']]);
        }

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        if ($user->id === 1) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكن حذف مدير النظام الأساسي.');
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم بنجاح.');
    }

    /**
     * Verify the specified user.
     */
    public function verify(User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            return redirect()->back()->with('success', 'تم توثيق حساب المستخدم بنجاح.');
        }

        return redirect()->back()->with('warning', 'حساب المستخدم موثق بالفعل.');
    }

    /**
     * Toggle the status of the specified user.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        $this->authorize('update', $user);

        if ($user->id === 1) {
            return redirect()->back()->with('error', 'لا يمكن تغيير حالة مدير النظام الأساسي.');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $statusMessage = $user->is_active ? 'تم تفعيل حساب المستخدم.' : 'تم تعطيل حساب المستخدم.';
        return redirect()->back()->with('success', $statusMessage);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ImagesUtility;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImagesUtility;

    /**
     * Show the profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('dashboard.profile.edit', compact('user'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users,phone,' . $user->id],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'brief_description' => ['nullable', 'string', 'max:1000'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'الاسم مطلوب.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفاً.',
            'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 20 حرفاً.',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل.',
            'logo.image' => 'يجب أن يكون الشعار صورة.',
            'logo.mimes' => 'يجب أن تكون الصورة بصيغة: jpeg, png, jpg, gif, webp.',
            'logo.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت.',
            'brief_description.max' => 'الوصف المبسط يجب ألا يتجاوز 1000 حرفاً.',
            'current_password.required_with' => 'كلمة المرور الحالية مطلوبة لتغيير كلمة المرور.',
            'current_password.current_password' => 'كلمة المرور الحالية غير صحيحة.',
            'password.min' => 'كلمة المرور الجديدة يجب ألا تقل عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        $user->name = $validated['name'];

        if (array_key_exists('phone', $validated)) {
            $user->phone = $validated['phone'];
        }
        if (array_key_exists('brief_description', $validated)) {
            $user->brief_description = $validated['brief_description'];
        }
        if ($request->hasFile('logo')) {
            $user->logo = $this->storeImage($request->file('logo'), 'users_logos');
        }
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}

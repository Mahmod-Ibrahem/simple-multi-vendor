<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:20', 'unique:users'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'brief_description' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'name.string' => 'الاسم يجب أن يكون نصاً',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفاً',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.string' => 'البريد الإلكتروني يجب أن يكون نصاً',
            'email.max' => 'البريد الإلكتروني يجب ألا يتجاوز 255 حرفاً',
            'email.email' => 'البريد الإلكتروني غير صالح',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل',
            'role.required' => 'الدور مطلوب',
            'role.string' => 'الدور يجب أن يكون نصاً',
            'role.in' => 'الدور المحدد غير صالح',
            'phone.string' => 'رقم الهاتف يجب أن يكون نصاً',
            'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 20 حرفاً',
            'phone.unique' => 'رقم الهاتف مستخدم بالفعل',
            'logo.image' => 'يجب أن يكون الشعار صورة',
            'logo.mimes' => 'يجب أن تكون الصورة بصيغة: jpeg, png, jpg, gif, webp',
            'logo.max' => 'يجب ألا يتجاوز حجم الصورة 2 ميجابايت',
            'brief_description.string' => 'الوصف المبسط يجب أن يكون نصاً',
            'brief_description.max' => 'الوصف المبسط يجب ألا يتجاوز 1000 حرفاً',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'published' => 'boolean',
            'locations' => 'nullable|string',
            'quantity' => 'integer|min:0',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'title' => 'عنوان المنتج',
            'price' => 'السعر',
            'main_image' => 'الصورة الرئيسية',
            'description' => 'الوصف',
            'category_id' => 'التصنيف',
            'images' => 'صور المعرض',
            'published' => 'حالة النشر',
            'locations' => 'المواقع (المنطقة والحي)',
            'quantity' => 'الكمية',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب.',
            'string' => 'حقل :attribute يجب أن يكون نصاً.',
            'numeric' => 'حقل :attribute يجب أن يكون رقماً.',
            'integer' => 'حقل :attribute يجب أن يكون رقماً صحيحاً.',
            'min' => 'حقل :attribute يجب أن يكون على الأقل :min.',
            'max' => 'حقل :attribute يجب ألا يتجاوز :max.',
            'image' => 'حقل :attribute يجب أن يكون صورة.',
            'mimes' => 'حقل :attribute يجب أن يكون من نوع: :values.',
            'exists' => ':attribute المختار غير صالح.',
            'boolean' => 'حقل :attribute يجب أن يكون صحيحاً أو خاطئاً.',
            'array' => 'حقل :attribute يجب أن يكون مصفوفة.',
        ];
    }
}

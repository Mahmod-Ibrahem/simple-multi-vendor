<template>
    <div class="space-y-4">
        <div class="flex flex-col gap-2">
            <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">اسم الموظف *</label>
            <InputText :model-value="modelValue.name" @update:model-value="updateField('name', $event)"
                :class="{ 'p-invalid': errors.name }" class="w-full" placeholder="أدخل اسم الموظف" />
            <small v-if="errors.name" class="text-red-500 text-xs">{{ errors.name[0] }}</small>
        </div>
        <div class="flex flex-col gap-2">
            <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">المسمى الوظيفي</label>
            <InputText :model-value="modelValue.job_title" @update:model-value="updateField('job_title', $event)"
                :class="{ 'p-invalid': errors.job_title }" class="w-full" placeholder="مثال: مدير القسم" />
            <small v-if="errors.job_title" class="text-red-500 text-xs">{{ errors.job_title[0] }}</small>
        </div>
    </div>
</template>

<script setup>
import InputText from 'primevue/inputtext'

const props = defineProps({
    modelValue: {
        type: Object,
        required: true,
        default: () => ({ name: '', job_title: '' })
    },
    errors: {
        type: Object,
        default: () => ({})
    }
})

const emit = defineEmits(['update:modelValue'])

function updateField(field, value) {
    emit('update:modelValue', {
        ...props.modelValue,
        [field]: value
    })
}
</script>

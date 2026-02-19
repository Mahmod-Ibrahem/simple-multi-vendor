<template>
    <div class="flex flex-col gap-3">
        <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">المرفقات</label>

        <!-- Existing Attachments -->
        <div v-if="existingAttachments.length > 0" class="flex flex-col gap-2">
            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">المرفقات الحالية:</div>
            <div class="flex flex-wrap gap-2">
                <div v-for="att in existingAttachments" :key="att.id"
                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm border transition-colors" :class="isMarkedForRemoval(att.id)
                        ? 'bg-red-50 dark:bg-red-900/30 border-red-200 dark:border-red-800 opacity-60'
                        : 'bg-blue-50 dark:bg-blue-900/30 border-blue-100 dark:border-blue-800'">
                    <!-- File icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2"
                        :class="isMarkedForRemoval(att.id) ? 'text-red-500' : 'text-blue-500'">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <span class="truncate max-w-[180px]"
                        :class="isMarkedForRemoval(att.id) ? 'line-through text-red-600 dark:text-red-400' : 'text-blue-600 dark:text-blue-400'">
                        {{ att.name }}
                    </span>
                    <!-- Download button -->
                    <a :href="att.url" :download="att.name"
                        class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-200"
                        v-tooltip.top="'تحميل'" v-if="!isMarkedForRemoval(att.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </a>
                    <!-- Delete button -->
                    <button type="button" @click="toggleRemoval(att.id)" class="transition-colors"
                        v-tooltip.top="isMarkedForRemoval(att.id) ? 'إلغاء الحذف' : 'حذف'"
                        :class="isMarkedForRemoval(att.id) ? 'text-green-500 hover:text-green-700' : 'text-red-500 hover:text-red-700'">
                        <!-- Undo icon when marked for removal -->
                        <svg v-if="isMarkedForRemoval(att.id)" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                        </svg>
                        <!-- X icon when not marked -->
                        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- New Files (Selected but not uploaded yet) -->
        <div v-if="newFiles.length > 0" class="flex flex-col gap-2">
            <div class="text-xs text-slate-500 dark:text-slate-400 mb-1">ملفات جديدة (سيتم رفعها عند الحفظ):</div>
            <div class="flex flex-wrap gap-2">
                <div v-for="(file, index) in newFiles" :key="index"
                    class="flex items-center gap-2 bg-green-50 dark:bg-green-900/30 px-3 py-2 rounded-lg text-sm border border-green-100 dark:border-green-800">
                    <!-- File plus icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="truncate max-w-[180px] text-green-700 dark:text-green-300">{{ file.name }}</span>
                    <span class="text-xs text-slate-400">({{ formatSize(file.size) }})</span>
                    <button type="button" @click="removeNewFile(index)" class="text-red-500 hover:text-red-700"
                        v-tooltip.top="'إزالة'">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Add Files Button -->
        <div class="flex items-center gap-3">
            <input type="file" ref="fileInput" class="hidden" @change="handleFileSelect" multiple
                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
            <Button :label="newFiles.length > 0 || existingAttachments.length > 0 ? 'إضافة مرفقات' : 'إرفاق ملفات'"
                icon="pi pi-paperclip" severity="secondary" outlined size="small" @click="$refs.fileInput.click()" />
            <span v-if="removedIds.length > 0" class="text-xs text-red-500 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                سيتم حذف {{ removedIds.length }} مرفق(ات) عند الحفظ
            </span>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import Button from 'primevue/button'

const props = defineProps({
    existingAttachments: {
        type: Array,
        default: () => []
    },
    modelValue: {
        type: Object,
        default: () => ({ newFiles: [], removedIds: [] })
    }
})

const emit = defineEmits(['update:modelValue'])

const fileInput = ref(null)

// Local state
const newFiles = ref([...props.modelValue.newFiles])
const removedIds = ref([...props.modelValue.removedIds])

// Watch for external changes
watch(() => props.modelValue, (val) => {
    newFiles.value = [...val.newFiles]
    removedIds.value = [...val.removedIds]
}, { deep: true })

// Emit changes
function emitUpdate() {
    emit('update:modelValue', {
        newFiles: newFiles.value,
        removedIds: removedIds.value
    })
}

// Check if an attachment is marked for removal
function isMarkedForRemoval(id) {
    return removedIds.value.includes(id)
}

// Toggle removal state
function toggleRemoval(id) {
    const index = removedIds.value.indexOf(id)
    if (index > -1) {
        removedIds.value.splice(index, 1)
    } else {
        removedIds.value.push(id)
    }
    emitUpdate()
}

// Handle file selection
function handleFileSelect(event) {
    const files = Array.from(event.target.files)
    newFiles.value.push(...files)
    emitUpdate()
    // Reset input to allow selecting same file again
    if (fileInput.value) {
        fileInput.value.value = ''
    }
}

// Remove a new file before submit
function removeNewFile(index) {
    newFiles.value.splice(index, 1)
    emitUpdate()
}

// Format file size
function formatSize(bytes) {
    if (bytes < 1024) return bytes + ' B'
    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB'
    return (bytes / (1024 * 1024)).toFixed(1) + ' MB'
}
</script>

<template>
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-linear-to-br from-emerald-500 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    الموظفين
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1 mr-13">إدارة الموظفين المكلفين بالرد على الكتب</p>
            </div>
            <Button v-if="can('employees.create')" label="إضافة موظف" @click="openCreateDialog"
                class="bg-linear-to-r! from-emerald-600! to-teal-600! border-0! shadow-lg shadow-emerald-500/25 hover:shadow-xl hover:shadow-emerald-500/30 transition-all">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </template>
            </Button>
        </div>

        <!-- Error Message -->
        <Message v-if="store.error" severity="error" class="mb-4">{{ store.error }}</Message>

        <!-- Data Table Card -->
        <EmployeeTable :items="store.items" :loading="store.loading" :meta="store.meta" @page-change="goToPage"
            @edit="openEditDialog" @delete="confirmDelete" />

        <!-- Create/Edit Dialog -->
        <Dialog v-model:visible="dialogVisible" :header="isEditing ? 'تعديل موظف' : 'إضافة موظف جديد'" modal
            class="w-full max-w-md" :closable="!saving" :closeOnEscape="!saving">
            <EmployeeForm v-model="form" :errors="errors" />
            <template #footer>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                    <Button label="إلغاء" severity="secondary" text @click="closeDialog" :disabled="saving" />
                    <Button :label="isEditing ? 'تحديث' : 'حفظ'" :loading="saving" @click="saveEmployee"
                        class="bg-emerald-600! hover:bg-emerald-700!" />
                </div>
            </template>
        </Dialog>

        <!-- Delete Confirmation Dialog -->
        <Dialog v-model:visible="deleteDialogVisible" header="تأكيد الحذف" modal class="w-full max-w-sm"
            :closable="!deleting">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-slate-800 dark:text-white">هل أنت متأكد من حذف هذا الموظف؟</p>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ itemToDelete?.name }}</p>
                </div>
            </div>
            <template #footer>
                <div class="flex justify-end gap-3">
                    <Button label="إلغاء" severity="secondary" text @click="deleteDialogVisible = false"
                        :disabled="deleting" />
                    <Button label="حذف" severity="danger" :loading="deleting" @click="deleteEmployee" />
                </div>
            </template>
        </Dialog>

        <Toast />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useEmployeeStore } from '../stores/employees'
import { useToast } from 'primevue/usetoast'
import { useCan } from '../composables/useCan'
import EmployeeTable from '../components/employees/EmployeeTable.vue'
import EmployeeForm from '../components/employees/EmployeeForm.vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import Message from 'primevue/message'
import Toast from 'primevue/toast'

const store = useEmployeeStore()
const toast = useToast()
const { can } = useCan()

// Dialog state
const dialogVisible = ref(false)
const deleteDialogVisible = ref(false)
const isEditing = ref(false)
const saving = ref(false)
const deleting = ref(false)
const editingId = ref(null)
const itemToDelete = ref(null)

// Form
const form = ref({
    name: '',
    job_title: ''
})
const errors = ref({})

// Load data on mount
onMounted(() => {
    store.fetchEmployees()
})


// Pagination
function goToPage(page) {
    if (page < 1 || page > store.meta.lastPage) return
    store.fetchEmployees({ page })
}

// Dialog handlers
function openCreateDialog() {
    isEditing.value = false
    editingId.value = null
    form.value = { name: '', job_title: '' }
    errors.value = {}
    dialogVisible.value = true
}

function openEditDialog(item) {
    isEditing.value = true
    editingId.value = item.id
    form.value = {
        name: item.name || '',
        job_title: item.job_title || ''
    }
    errors.value = {}
    dialogVisible.value = true
}

function closeDialog() {
    dialogVisible.value = false
    errors.value = {}
}

// Save employee
function saveEmployee() {
    saving.value = true
    errors.value = {}

    const action = isEditing.value
        ? store.updateEmployee(editingId.value, form.value)
        : store.createEmployee(form.value)

    action
        .then((result) => {
            if (result.success) {
                toast.add({
                    severity: 'success',
                    summary: 'نجاح',
                    detail: isEditing.value ? 'تم تحديث الموظف بنجاح' : 'تم إنشاء الموظف بنجاح',
                    life: 3000
                })
                closeDialog()
                store.fetchEmployees({ page: store.meta.currentPage })
            } else {
                errors.value = result.errors || {}
                if (result.message && !result.errors) {
                    toast.add({ severity: 'error', summary: 'خطأ', detail: result.message, life: 5000 })
                }
            }
        })
        .finally(() => {
            saving.value = false
        })
}

// Delete
function confirmDelete(item) {
    itemToDelete.value = item
    deleteDialogVisible.value = true
}

function deleteEmployee() {
    if (!itemToDelete.value) return
    deleting.value = true

    store.deleteEmployee(itemToDelete.value.id)
        .then((result) => {
            if (result.success) {
                toast.add({ severity: 'success', summary: 'نجاح', detail: 'تم حذف الموظف بنجاح', life: 3000 })
                deleteDialogVisible.value = false
                itemToDelete.value = null
            } else {
                toast.add({ severity: 'error', summary: 'خطأ', detail: result.message, life: 5000 })
            }
        })
        .finally(() => {
            deleting.value = false
        })
}
</script>

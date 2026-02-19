<template>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">الجهات المكلفة</h1>
            <Button v-if="can('assignments.create')" label="إضافة جهة" icon="pi pi-plus" @click="openCreateDialog" />
        </div>

        <!-- Data Table -->
        <AssignmentsTable :items="store.items" :loading="store.loading" @edit="openEditDialog"
            @delete="confirmDelete" />

        <!-- Pagination -->
        <div class="flex justify-between items-center mt-4" v-if="store.pagination.lastPage > 1">
            <span class="text-sm text-gray-600 dark:text-gray-400">
                عرض {{ store.items.length }} من {{ store.pagination.total }}
            </span>
            <div class="flex gap-2">
                <Button label="السابق" icon="pi pi-chevron-right" :disabled="store.pagination.currentPage === 1"
                    @click="goToPage(store.pagination.currentPage - 1)" text />
                <span class="px-3 py-2 text-sm">
                    {{ store.pagination.currentPage }} / {{ store.pagination.lastPage }}
                </span>
                <Button label="التالي" icon="pi pi-chevron-left" iconPos="right"
                    :disabled="store.pagination.currentPage === store.pagination.lastPage"
                    @click="goToPage(store.pagination.currentPage + 1)" text />
            </div>
        </div>

        <!-- Create/Edit Dialog -->
        <Dialog v-model:visible="dialogVisible" :header="isEditing ? 'تعديل الجهة المكلفة' : 'إضافة جهة مكلفة'"
            :style="{ width: '500px' }" modal>
            <div class="space-y-4 pt-4">
                <div class="flex flex-col gap-2">
                    <label for="title" class="font-medium">العنوان *</label>
                    <InputText id="title" v-model="form.title" :class="{ 'p-invalid': errors.title }" class="w-full" />
                    <small v-if="errors.title" class="text-red-500">{{ errors.title[0] }}</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label for="description" class="font-medium">الوصف</label>
                    <Textarea id="description" v-model="form.description" rows="3"
                        :class="{ 'p-invalid': errors.description }" class="w-full" />
                    <small v-if="errors.description" class="text-red-500">{{ errors.description[0] }}</small>
                </div>
            </div>

            <template #footer>
                <Button label="إلغاء" severity="secondary" text @click="closeDialog" />
                <Button :label="isEditing ? 'تحديث' : 'حفظ'" :loading="saving" @click="saveAssignment" />
            </template>
        </Dialog>

        <!-- Delete Confirmation -->
        <Dialog v-model:visible="deleteDialogVisible" header="تأكيد الحذف" :style="{ width: '400px' }" modal>
            <div class="flex items-center gap-4">
                <i class="pi pi-exclamation-triangle text-4xl text-yellow-500"></i>
                <span>هل أنت متأكد من حذف الجهة المكلفة "{{ itemToDelete?.title }}"؟</span>
            </div>
            <template #footer>
                <Button label="إلغاء" severity="secondary" text @click="deleteDialogVisible = false" />
                <Button label="حذف" severity="danger" :loading="deleting" @click="deleteAssignment" />
            </template>
        </Dialog>

        <!-- Toast -->
        <Toast position="top-left" />
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAssignmentStore } from '../../stores/assignments'
import { usePermissions } from '../../composables/usePermissions'
import { useCan } from '../../composables/useCan'
import { useToast } from 'primevue/usetoast'
import AssignmentsTable from '../../components/letters/AssignmentsTable.vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Message from 'primevue/message'
import Toast from 'primevue/toast'

const store = useAssignmentStore()
const toast = useToast()
const { can } = useCan()

// Dialog state
const dialogVisible = ref(false)
const deleteDialogVisible = ref(false)
const isEditing = ref(false)
const saving = ref(false)
const deleting = ref(false)
const itemToDelete = ref(null)
const editingId = ref(null)

// Form
const form = ref({ title: '', description: '' })
const errors = ref({})

// Load data on mount
onMounted(() => {
    store.fetchAll()
})

// Pagination
function goToPage(page) {
    store.fetchAll(page)
}



// Dialog handlers
function openCreateDialog() {
    isEditing.value = false
    editingId.value = null
    form.value = { title: '', description: '' }
    errors.value = {}
    dialogVisible.value = true
}

function openEditDialog(item) {
    isEditing.value = true
    editingId.value = item.id
    form.value = { title: item.title, description: item.description || '' }
    errors.value = {}
    dialogVisible.value = true
}

function closeDialog() {
    dialogVisible.value = false
    form.value = { title: '', description: '' }
    errors.value = {}
}

// Save assignment
function saveAssignment() {
    saving.value = true
    errors.value = {}

    const action = isEditing.value
        ? store.update(editingId.value, form.value)
        : store.create(form.value)

    action
        .then(() => {
            toast.add({
                severity: 'success',
                summary: 'نجاح',
                detail: isEditing.value ? 'تم تحديث الجهة المكلفة بنجاح' : 'تم إنشاء الجهة المكلفة بنجاح',
                life: 3000
            })
            closeDialog()
            store.fetchAll(store.pagination.currentPage)
        })
        .catch((err) => {
            if (err.response?.data?.errors) {
                errors.value = err.response.data.errors
            }
        })
        .finally(() => {
            saving.value = false
        })
}

// Delete handlers
function confirmDelete(item) {
    itemToDelete.value = item
    deleteDialogVisible.value = true
}

function deleteAssignment() {
    deleting.value = true

    store.remove(itemToDelete.value.id)
        .then(() => {
            toast.add({
                severity: 'success',
                summary: 'نجاح',
                detail: 'تم حذف الجهة المكلفة بنجاح',
                life: 3000
            })
            deleteDialogVisible.value = false
            itemToDelete.value = null
            store.fetchAll(store.pagination.currentPage)
        })
        .catch(() => {
            toast.add({
                severity: 'error',
                summary: 'خطأ',
                detail: store.error || 'فشل في حذف الجهة المكلفة',
                life: 3000
            })
        })
        .finally(() => {
            deleting.value = false
        })
}
</script>

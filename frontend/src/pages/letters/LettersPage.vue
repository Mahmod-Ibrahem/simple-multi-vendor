<template>
    <div class="p-6 space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    الكتب
                </h1>
                <p class="text-slate-500 dark:text-slate-400 mt-1 mr-13">إدارة وتتبع جميع الكتب الواردة والصادرة</p>
            </div>

            <Button v-if="can('letters.create')" label="إضافة كتاب" @click="openCreateDialog"
                class="!bg-gradient-to-r !from-indigo-600 !to-purple-600 !border-0 shadow-lg shadow-indigo-500/25 hover:shadow-xl hover:shadow-indigo-500/30 transition-all shrink-0">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </template>
            </Button>
        </div>

        <!-- Filters Card -->
        <div class="card overflow-hidden">
            <div class="p-5 border-b border-slate-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-slate-700 dark:text-slate-200">فلترة وبحث</h3>
                </div>
            </div>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">التصنيف</label>
                        <Select v-model="filterCategory" :options="categoryOptions" optionLabel="title" optionValue="id"
                            placeholder="الكل" showClear class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">الموضوع</label>
                        <Select v-model="filterSubject" :options="subjectOptions" optionLabel="title" optionValue="id"
                            placeholder="الكل" showClear class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">التكليف</label>
                        <Select v-model="filterAssignment" :options="assignmentOptions" optionLabel="title"
                            optionValue="id" placeholder="الكل" showClear class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">الحالة</label>
                        <Select v-model="filterStatus" :options="statusOptions" optionLabel="title" optionValue="id"
                            placeholder="الكل" showClear class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">رقم الكتاب</label>
                        <InputText v-model="filterLetterNumber" placeholder="بحث برقم الكتاب" class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">رقم القضية/السنة</label>
                        <InputText v-model="filterCaseNoYear" placeholder="بحث برقم القضية" class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">الموظف</label>
                        <Select v-model="filterEmployee" :options="employeeFilterOptions" optionLabel="name"
                            optionValue="id" placeholder="كل الموظفين" showClear class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">من تاريخ</label>
                        <DatePicker v-model="filterDateFrom" dateFormat="yy-mm-dd" showClear class="w-full" />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium text-slate-600 dark:text-slate-300">إلى تاريخ</label>
                        <DatePicker v-model="filterDateTo" dateFormat="yy-mm-dd" showClear class="w-full" />
                    </div>

                    <div class="flex items-end gap-2 shrink-0 w-fit">
                        <Button label="بحث" @click="applyFilters" class="flex-1 shrink-0"
                            :class="'!bg-indigo-600 hover:!bg-indigo-700'">
                            <template #icon>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </template>
                        </Button>
                        <Button severity="secondary" outlined @click="resetFilters" v-tooltip.top="'مسح الفلاتر'"
                            class="!border-slate-300 dark:!border-slate-600 shrink-0">
                            <template #icon>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                            </template>
                        </Button>
                        <Button label="تصدير" @click="exportLetters" :loading="exporting"
                            class="!bg-white dark:!bg-slate-700 !text-slate-700 dark:!text-slate-200 !border !border-slate-200 dark:!border-slate-600 shadow-sm hover:bg-slate-50 dark:hover:bg-slate-600 transition-all mr-2 shrink-0">
                            <template #icon>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </template>
                        </Button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <LetterTable :items="store.items" :loading="store.loading" :late-threshold="settingStore.lateLettersValue"
            @edit="openEditDialog" @delete="confirmDelete" />

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white dark:bg-slate-800 rounded-xl p-4 border border-slate-200 dark:border-slate-700 shadow-sm"
            v-if="store.pagination.lastPage > 1">
            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <span class="font-medium">إجمالي:</span>
                <span
                    class="px-2 py-1 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 rounded-md font-bold">
                    {{ store.pagination.total }}
                </span>
                <span>كتاب</span>
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button @click="goToPage(store.pagination.currentPage - 1)"
                    :disabled="store.pagination.currentPage === 1"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-600 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    السابق
                </button>
                <div
                    class="flex items-center gap-1 px-4 py-2 bg-indigo-600 text-white rounded-lg font-bold text-sm shadow-sm shrink-0">
                    <span>{{ store.pagination.currentPage }}</span>
                    <span class="text-indigo-200">/</span>
                    <span class="text-indigo-200">{{ store.pagination.lastPage }}</span>
                </div>
                <button @click="goToPage(store.pagination.currentPage + 1)"
                    :disabled="store.pagination.currentPage === store.pagination.lastPage"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-600 shrink-0">
                    التالي
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Create/Edit Letter Dialog -->
        <Dialog v-model:visible="dialogVisible" :header="isEditing ? 'تعديل الكتاب' : 'إضافة كتاب جديد'"
            :style="{ width: '750px' }" modal class="!rounded-2xl">
            <LetterForm v-model="form" :errors="errors" :category-options="categoryOptions"
                :subject-options="subjectOptions" :assignment-options="assignmentOptions"
                :status-options="statusOptions" :employee-options="employeeOptions"
                @refresh-subjects="handleRefreshSubjects" @refresh-employees="handleRefreshEmployees" />

            <template #footer>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                    <Button label="إلغاء" severity="secondary" text @click="closeDialog" />
                    <Button :label="isEditing ? 'تحديث' : 'حفظ'" :loading="saving" @click="saveLetter"
                        class="!bg-indigo-600 hover:!bg-indigo-700" />
                </div>
            </template>
        </Dialog>

        <!-- Delete Confirmation -->
        <Dialog v-model:visible="deleteDialogVisible" header="تأكيد الحذف" :style="{ width: '420px' }" modal>
            <div class="flex items-start gap-4 py-2">
                <div
                    class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 dark:text-white mb-1">حذف الكتاب</h4>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">
                        هل أنت متأكد من حذف الكتاب رقم
                        <span class="font-bold text-red-600">"{{ itemToDelete?.letter_number }}"</span>؟
                        لا يمكن التراجع عن هذا الإجراء.
                    </p>
                </div>
            </div>
            <template #footer>
                <Button label="إلغاء" severity="secondary" text @click="deleteDialogVisible = false" />
                <Button label="حذف" severity="danger" :loading="deleting" @click="deleteLetter" />
            </template>
        </Dialog>

        <!-- Toast -->
        <Toast position="top-left" />
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useLetterStore } from '../../stores/letters'
import { useCategoryStore } from '../../stores/categories'
import { useSubjectStore } from '../../stores/subjects'
import { useAssignmentStore } from '../../stores/assignments'
import { useLetterStatusStore } from '../../stores/letterStatuses'
import { useEmployeeStore } from '../../stores/employees'
import { useSettingStore } from '../../stores/settingStore'
import { usePermissions } from '../../composables/usePermissions'
import { useCan } from '../../composables/useCan'
import { useToast } from 'primevue/usetoast'
import LetterTable from '../../components/letters/LetterTable.vue'
import LetterForm from '../../components/letters/LetterForm.vue'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import DatePicker from 'primevue/datepicker'
import Message from 'primevue/message'
import Toast from 'primevue/toast'

const store = useLetterStore()
const categoryStore = useCategoryStore()
const subjectStore = useSubjectStore()
const assignmentStore = useAssignmentStore()
const letterStatusStore = useLetterStatusStore()
const employeeStore = useEmployeeStore()
const settingStore = useSettingStore()
const toast = useToast()
const { can } = useCan()

// Dropdown options
const categoryOptions = ref([])
const subjectOptions = ref([])
const assignmentOptions = ref([])
const statusOptions = ref([])
const employeeOptions = ref([])

// Filter state
const filterCategory = ref(null)
const filterSubject = ref(null)
const filterAssignment = ref(null)
const filterStatus = ref(null)
const filterEmployee = ref(null)
const filterLetterNumber = ref('')
const filterCaseNoYear = ref('')
const filterDateFrom = ref(null)
const filterDateTo = ref(null)

// Employee filter options with 'All' option
const employeeFilterOptions = computed(() => {
    return employeeOptions.value
})

// Dialog state
const dialogVisible = ref(false)
const deleteDialogVisible = ref(false)
const isEditing = ref(false)
const saving = ref(false)
const deleting = ref(false)
const itemToDelete = ref(null)
const editingId = ref(null)

// Letter form
const form = ref({
    category_id: null,
    subject_id: null,
    assignment_id: null,
    letter_status_id: null,
    employee_id: null,
    letter_number: null,
    date: null,
    outgoings: [],
    on_going_date: null,
    on_going_number: null,
    progress_status: null,
    reply_deadline_days: null,
    // New fields
    memo_number: null,
    memo_date: null,
    forwarded_to_department: null,
    case_no_year: null,
    non_cooperative_items: [],
    attachments: [],
    attachmentData: { newFiles: [], removedIds: [] }
})
const errors = ref({})

// Load data on mount
onMounted(() => {
    store.fetchAll()
    settingStore.fetchSettings()
    loadDropdownOptions()
})

// Load dropdown options
function loadDropdownOptions() {
    categoryStore.fetchAllForDropdown()
        .then((data) => { categoryOptions.value = data })

    subjectStore.fetchAllForDropdown()
        .then((data) => { subjectOptions.value = data })

    assignmentStore.fetchAllForDropdown()
        .then((data) => { assignmentOptions.value = data })

    letterStatusStore.fetchAllForDropdown()
        .then((data) => { statusOptions.value = data })

    employeeStore.fetchAllForDropdown()
        .then((data) => { employeeOptions.value = data })
}

// Handle refresh from LetterForm inline creates
function handleRefreshSubjects(newId) {
    subjectStore.fetchAllForDropdown()
        .then((data) => {
            subjectOptions.value = data
            if (newId) form.value.subject_id = newId
        })
}

function handleRefreshEmployees(newId) {
    employeeStore.fetchAllForDropdown()
        .then((data) => {
            employeeOptions.value = data
            if (newId) form.value.employee_id = newId
        })
}

// Format date for filter
function formatDateForFilter(date) {
    if (!date) return null
    const d = new Date(date)
    const year = d.getFullYear()
    const month = String(d.getMonth() + 1).padStart(2, '0')
    const day = String(d.getDate()).padStart(2, '0')
    return `${year}-${month}-${day}`
}

// Apply filters
function applyFilters() {
    store.setFilter('category_id', filterCategory.value)
    store.setFilter('subject_id', filterSubject.value)
    store.setFilter('assignment_id', filterAssignment.value)
    store.setFilter('letter_status_id', filterStatus.value)
    store.setFilter('employee_id', filterEmployee.value)
    store.setFilter('letter_number', filterLetterNumber.value || null)
    store.setFilter('case_no_year', filterCaseNoYear.value || null)
    store.setFilter('date_from', formatDateForFilter(filterDateFrom.value))
    store.setFilter('date_to', formatDateForFilter(filterDateTo.value))
    store.fetchAll(1)
}

// Reset filters
function resetFilters() {
    filterCategory.value = null
    filterSubject.value = null
    filterAssignment.value = null
    filterStatus.value = null
    filterEmployee.value = null
    filterLetterNumber.value = ''
    filterCaseNoYear.value = ''
    filterDateFrom.value = null
    filterDateTo.value = null
    store.resetFilters()
    store.fetchAll(1)
}

// Pagination
function goToPage(page) {
    store.fetchAll(page)
}

// Export logic
const exporting = ref(false)

function exportLetters() {
    exporting.value = true

    // Build query params from current filters
    const params = {
        category_id: filterCategory.value,
        subject_id: filterSubject.value,
        assignment_id: filterAssignment.value,
        letter_status_id: filterStatus.value,
        employee_id: filterEmployee.value,
        letter_number: filterLetterNumber.value || null,
        case_no_year: filterCaseNoYear.value || null,
        date_from: formatDateForFilter(filterDateFrom.value),
        date_to: formatDateForFilter(filterDateTo.value),
    }

    // Clean null/undefined values
    Object.keys(params).forEach(key => params[key] == null && delete params[key])

    store.exportLetters(params)
        .then((blob) => {
            // Create download link
            const url = window.URL.createObjectURL(new Blob([blob]))
            const link = document.createElement('a')
            link.href = url
            link.setAttribute('download', `letters-export-${new Date().toISOString().slice(0, 10)}.xlsx`)
            document.body.appendChild(link)
            link.click()
            link.remove()
        })
        .catch(() => {
            toast.add({
                severity: 'error',
                summary: 'خطأ',
                detail: 'فشل تصدير البيانات',
                life: 3000
            })
        })
        .finally(() => {
            exporting.value = false
        })
}

// Format date for API (YYYY-MM-DD)
function formatDateForApi(date) {
    if (!date) return null
    const d = new Date(date)
    const year = d.getFullYear()
    const month = String(d.getMonth() + 1).padStart(2, '0')
    const day = String(d.getDate()).padStart(2, '0')
    return `${year}-${month}-${day}`
}

// Dialog handlers
function openCreateDialog() {
    isEditing.value = false
    editingId.value = null
    form.value = {
        category_id: '',
        subject_id: '',
        assignment_id: '',
        letter_status_id: '',
        employee_id: '',
        letter_number: '',
        date: null,
        export: false,
        export: false,
        outgoings: [],
        on_going_date: null,
        on_going_number: null,
        progress_status: null,
        progress_status: null,
        reply_deadline_days: null,
        noncooperative_recipient: null,
        noncooperative_date: null,
        noncooperative_number: null,
        non_cooperative_items: [],
        attachments: [],
        attachmentData: { newFiles: [], removedIds: [] }
    }
    errors.value = {}
    dialogVisible.value = true
}

function openEditDialog(item) {
    isEditing.value = true
    editingId.value = item.id
    form.value = {
        category_id: item.category_id,
        subject_id: item.subject_id,
        assignment_id: item.assignment_id,
        letter_status_id: item.letter_status_id || null,
        employee_id: item.employee_id || null,
        letter_number: item.letter_number,
        date: item.date ? new Date(item.date) : null,
        outgoings: item.outgoings ? item.outgoings.map(o => ({
            outgoing_number: o.outgoing_number,
            outgoing_date: o.outgoing_date ? new Date(o.outgoing_date) : null
        })) : [],
        on_going_date: item.on_going_date ? new Date(item.on_going_date) : null,
        on_going_number: item.on_going_number || null,
        progress_status: item.progress_status || null,
        reply_deadline_days: item.reply_deadline_days || null,
        // Added missing fields
        memo_number: item.memo_number || null,
        memo_date: item.memo_date ? new Date(item.memo_date) : null,
        forwarded_to_department: item.forwarded_to_department || null,
        case_no_year: item.case_no_year || null,

        non_cooperative_items: item.non_cooperative_items ? item.non_cooperative_items.map(i => ({
            recipient: i.recipient,
            date: i.date ? new Date(i.date) : null,
            number: i.number
        })) : [],
        attachments: item.attachments || [],
        attachmentData: { newFiles: [], removedIds: [] }
    }
    errors.value = {}
    dialogVisible.value = true
}

function closeDialog() {
    dialogVisible.value = false
    errors.value = {}
}

// Save letter
function saveLetter() {
    saving.value = true
    errors.value = {}

    // Build FormData for file uploads
    const formData = new FormData()

    // Add basic fields
    formData.append('category_id', form.value.category_id)
    formData.append('subject_id', form.value.subject_id)
    formData.append('assignment_id', form.value.assignment_id)
    if (form.value.letter_status_id) formData.append('letter_status_id', form.value.letter_status_id)
    if (form.value.employee_id) formData.append('employee_id', form.value.employee_id)
    formData.append('letter_number', form.value.letter_number)
    formData.append('date', formatDateForApi(form.value.date))

    // Export letter fields (outgoing)
    if (form.value.letter_status_id === 2 && form.value.outgoings && form.value.outgoings.length > 0) {
        form.value.outgoings.forEach((outgoing, index) => {
            formData.append(`outgoings[${index}][outgoing_number]`, outgoing.outgoing_number || '')
            if (outgoing.outgoing_date) {
                formData.append(`outgoings[${index}][outgoing_date]`, formatDateForApi(outgoing.outgoing_date))
            }
        })
    }

    if (!form.value.export) {
        // Incoming letter fields
        if (form.value.on_going_number) formData.append('on_going_number', form.value.on_going_number)
        if (form.value.on_going_date) formData.append('on_going_date', formatDateForApi(form.value.on_going_date))
    }
    if (form.value.reply_deadline_days) formData.append('reply_deadline_days', form.value.reply_deadline_days)

    if (form.value.progress_status) formData.append('progress_status', form.value.progress_status)


    // Memo fields
    if (form.value.memo_number) formData.append('memo_number', form.value.memo_number)
    if (form.value.memo_date) formData.append('memo_date', formatDateForApi(form.value.memo_date))
    if (form.value.forwarded_to_department) formData.append('forwarded_to_department', form.value.forwarded_to_department)

    // Case number/year
    if (form.value.case_no_year) formData.append('case_no_year', form.value.case_no_year)

    // Non-cooperative items
    if (form.value.non_cooperative_items && form.value.non_cooperative_items.length > 0) {
        form.value.non_cooperative_items.forEach((item, index) => {
            if (item.recipient) formData.append(`non_cooperative_items[${index}][recipient]`, item.recipient)
            if (item.number) formData.append(`non_cooperative_items[${index}][number]`, item.number)
            if (item.date) formData.append(`non_cooperative_items[${index}][date]`, formatDateForApi(item.date))
        })
    } else {
        // Send empty value so backend knows to clear existing items
        formData.append('non_cooperative_items', '')
    }

    // Add new attachments
    const { newFiles, removedIds } = form.value.attachmentData || { newFiles: [], removedIds: [] }
    newFiles.forEach((file) => {
        formData.append('attachments[]', file)
    })

    // Add removed attachment IDs (for update)
    removedIds.forEach((id) => {
        formData.append('removed_attachment_ids[]', id)
    })

    // For PUT requests with FormData, use POST with _method override
    if (isEditing.value) {
        formData.append('_method', 'PUT')
    }

    const action = isEditing.value
        ? store.updateWithFormData(editingId.value, formData)
        : store.createWithFormData(formData)

    action
        .then(() => {
            toast.add({
                severity: 'success',
                summary: 'نجاح',
                detail: isEditing.value ? 'تم تحديث الكتاب بنجاح' : 'تم إنشاء الكتاب بنجاح',
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

function deleteLetter() {
    deleting.value = true

    store.remove(itemToDelete.value.id)
        .then(() => {
            toast.add({
                severity: 'success',
                summary: 'نجاح',
                detail: 'تم حذف الكتاب بنجاح',
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
                detail: store.error || 'فشل في حذف الكتاب',
                life: 3000
            })
        })
        .finally(() => {
            deleting.value = false
        })
}
</script>

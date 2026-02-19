<template>
    <div class="p-6">
        <!-- Back Button & Header -->
        <div class="mb-6">
            <Button label="العودة للقائمة" text @click="$router.push({ name: 'letters' })" class="mb-2">
                <template #icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7-7 7" />
                    </svg>
                </template>
            </Button>
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">
                        كتاب رقم: {{ letter?.letter_number }}
                    </h1>
                    <div class="flex gap-2 flex-wrap">
                        <Tag :value="letter?.category?.title" severity="info" />
                        <Tag :value="letter?.export ? 'صادر' : 'وارد'"
                            :severity="letter?.export ? 'success' : 'secondary'" />
                        <span v-if="letter?.letter_status"
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium"
                            :style="{ backgroundColor: letter.letter_status.color + '20', color: letter.letter_status.color }">
                            {{ letter.letter_status.title }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <Button label="تعديل" severity="secondary" outlined @click="openEditDialog">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                        </template>
                    </Button>
                    <!-- Only show 'Add Confirmation' if this is a main letter -->
                    <Button v-if="!letter?.parent_letter_id" label="إضافة كتاب تأكيدي" @click="openAddRelatedDialog">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </template>
                    </Button>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="text-center py-12">
            <AppSpinner size="md" text="جاري تحميل بيانات الكتاب..." />
        </div>

        <!-- Error State -->
        <Message v-else-if="error" severity="error" class="mb-6">{{ error }}</Message>

        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Letter Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4 border-b pb-2">تفاصيل الكتاب</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm text-gray-500 mb-1">الموضوع</label>
                            <div class="font-medium text-lg">{{ letter?.subject?.title }}</div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-500 mb-1">الجهة المكلفة</label>
                            <div class="font-medium text-lg">{{ letter?.assignment?.title }}</div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-500 mb-1">تاريخ الكتاب</label>
                            <div class="font-medium">{{ letter?.date }}</div>
                        </div>
                        <div v-if="!letter?.export && letter?.outgoings?.length > 0">
                            <label class="block text-sm text-gray-500 mb-1">ردود الصادر</label>
                            <div class="space-y-1">
                                <div v-for="outgoing in letter.outgoings" :key="outgoing.id"
                                    class="flex items-center gap-2">
                                    <Tag :value="outgoing.outgoing_number" severity="info" class="text-xs" />
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{
                                        outgoing.outgoing_date }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="!letter?.export && letter?.reply_deadline_days">
                            <label class="block text-sm text-gray-500 mb-1">مهلة الرد</label>
                            <div class="font-medium">{{ letter?.reply_deadline_days }} يوم</div>
                        </div>

                        <!-- Employee -->
                        <div v-if="letter?.employee">
                            <label class="block text-sm text-gray-500 mb-1">الموظف المكلف</label>
                            <div class="font-medium text-lg">{{ letter.employee.name }}</div>
                        </div>

                        <!-- Incoming Fields (if not export) -->
                        <div v-if="!letter?.export && letter?.on_going_number">
                            <label class="block text-sm text-gray-500 mb-1">رقم الوارد</label>
                            <div class="font-medium">{{ letter.on_going_number }}</div>
                        </div>
                        <div v-if="!letter?.export && letter?.on_going_date">
                            <label class="block text-sm text-gray-500 mb-1">تاريخ الوارد</label>
                            <div class="font-medium">{{ letter.on_going_date }}</div>
                        </div>

                        <!-- Progress Status -->
                        <div v-if="letter?.progress_status" class="md:col-span-2 mt-2">
                            <label class="block text-sm text-gray-500 mb-1">حالة سير العمل</label>
                            <div
                                class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded text-gray-700 dark:text-gray-300 border border-gray-100 dark:border-gray-700 whitespace-pre-wrap leading-relaxed">
                                {{ letter.progress_status }}</div>
                        </div>
                    </div>
                </div>

                <!-- Non-Cooperative Letter Details -->
                <div v-if="(letter?.noncooperative_recipient || letter?.noncooperative_number) || (letter?.non_cooperative_items && letter.non_cooperative_items.length > 0)"
                    class="bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4 border-b pb-2 text-red-800 dark:text-red-300">تفاصيل عدم التعاون
                    </h2>

                    <!-- Legacy Single Fields (if exist) -->
                    <div v-if="letter?.noncooperative_recipient || letter?.noncooperative_number"
                        class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                        <div v-if="letter?.noncooperative_recipient">
                            <label class="block text-sm text-red-600/70 dark:text-red-400/70 mb-1">الجهة المرسل
                                إليها</label>
                            <div class="font-medium text-lg text-red-900 dark:text-red-200">{{
                                letter.noncooperative_recipient
                            }}</div>
                        </div>
                        <div v-if="letter?.noncooperative_date">
                            <label class="block text-sm text-red-600/70 dark:text-red-400/70 mb-1">تاريخ الكتاب</label>
                            <div class="font-medium text-red-900 dark:text-red-200">{{
                                letter.noncooperative_date }}
                            </div>
                        </div>
                        <div v-if="letter?.noncooperative_number">
                            <label class="block text-sm text-red-600/70 dark:text-red-400/70 mb-1">رقم الكتاب</label>
                            <div class="font-medium text-red-900 dark:text-red-200">{{ letter.noncooperative_number }}
                            </div>
                        </div>
                    </div>

                    <!-- Non-Cooperative Items List -->
                    <div v-if="letter?.non_cooperative_items && letter.non_cooperative_items.length > 0">
                        <h3 class="font-semibold text-red-800 dark:text-red-300 mb-3 text-sm">أطراف عدم التعاون
                            المرتبطة:</h3>
                        <div class="space-y-3">
                            <div v-for="item in letter.non_cooperative_items" :key="item.id"
                                class="bg-white/50 dark:bg-black/20 p-3 rounded border border-red-100 dark:border-red-800/50 flex flex-wrap gap-4 items-center">
                                <div>
                                    <span class="text-xs text-red-600/70 block">الجهة</span>
                                    <span class="font-medium text-red-900 dark:text-red-200">{{ item.recipient }}</span>
                                </div>
                                <div class="h-8 w-px bg-red-200 dark:bg-red-800 hidden md:block"></div>
                                <div>
                                    <span class="text-xs text-red-600/70 block">رقم الكتاب</span>
                                    <span class="font-medium text-red-900 dark:text-red-200">{{ item.number }}</span>
                                </div>
                                <div class="h-8 w-px bg-red-200 dark:bg-red-800 hidden md:block"></div>
                                <div>
                                    <span class="text-xs text-red-600/70 block">التاريخ</span>
                                    <span class="font-medium text-red-900 dark:text-red-200">{{ item.date
                                    }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Attachments Section -->
                <div v-if="letter?.attachments?.length > 0" class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold mb-4 border-b pb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        المرفقات
                        <span class="text-sm font-normal text-gray-500 mr-2">({{ letter.attachments.length }})</span>
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a v-for="attachment in letter.attachments" :key="attachment.id" :href="attachment.url"
                            target="_blank"
                            class="flex items-center p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition group">
                            <div
                                class="w-10 h-10 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-500 ml-3 group-hover:bg-red-100 dark:group-hover:bg-red-900/40 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate"
                                    :title="attachment.name">
                                    {{ attachment.name }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5">{{ attachment.created_at || 'Download' }}</p>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 text-gray-400 group-hover:text-indigo-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Related Letters Section -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h2 class="text-xl font-bold">
                            الكتب التأكيدية / المرتبطة
                            <span class="text-sm font-normal text-gray-500 mr-2">({{ letter?.related_letters?.length ||
                                0 }})</span>
                        </h2>
                    </div>

                    <div v-if="letter?.related_letters?.length" class="table-container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>رقم الكتاب</th>
                                    <th>التاريخ</th>
                                    <th>الموضوع</th>
                                    <th style="width: 100px">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="related in letter.related_letters" :key="related.id">
                                    <td>
                                        <span class="font-bold text-gray-800 dark:text-gray-200">
                                            {{ related.letter_number }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="text-gray-600 dark:text-gray-400 text-sm">
                                            {{ related.date }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-gray-800 dark:text-gray-200 font-medium">
                                            {{ related.subject?.title || '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="flex items-center gap-2">
                                            <button
                                                class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition-colors"
                                                v-tooltip.top="'عرض التفاصيل'"
                                                @click="$router.push({ name: 'letters.show', params: { id: related.id } })">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </button>
                                            <button @click="openEditRelated(related)"
                                                class="text-sky-600 hover:text-sky-800 dark:text-sky-400 dark:hover:text-sky-200 transition-colors"
                                                v-tooltip.top="'تعديل'">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button @click="confirmDelete(related)"
                                                class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 transition-colors"
                                                v-tooltip.top="'حذف'">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="text-center py-8 text-gray-500">
                        <div
                            class="w-12 h-12 mx-auto mb-3 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                        </div>
                        <p>لا توجد كتابات مرتبطة</p>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info (Parent info if exists, meta info) -->
            <div class="space-y-6">
                <!-- Parent Letter Card (if this is a related letter) -->
                <div v-if="letter?.parent_letter_id"
                    class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg p-6">
                    <h3 class="text-blue-800 dark:text-blue-300 font-bold mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                        مرتبط بالكتاب الرئيسي
                    </h3>
                    <div class="mb-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">رقم الكتاب الرئيسي</div>
                        <div class="text-lg font-bold">{{ letter?.parent?.letter_number }}</div>
                    </div>
                    <div class="mb-4">
                        <div class="text-sm text-gray-600 dark:text-gray-400">تاريخ الكتاب</div>
                        <div class="font-medium">{{ letter?.parent?.date }}</div>
                    </div>
                    <Button label="عرض الكتاب الرئيسي" size="small" outlined class="w-full"
                        @click="$router.push({ name: 'letters.show', params: { id: letter?.parent_letter_id } })" />
                </div>

                <!-- Meta Info -->
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 text-sm text-gray-500">
                    <div class="mb-2">
                        <span class="block">تم الإنشاء في:</span>
                        <span class="font-medium text-gray-700 dark:text-gray-300">
                            {{ letter?.created_at || '-' }}
                        </span>
                    </div>
                    <div>
                        <span class="block">آخر تحديث:</span>
                        <span class="font-medium text-gray-700 dark:text-gray-300">
                            {{ letter?.updated_at || '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit/Create Dialog -->
        <Dialog v-model:visible="dialogVisible" :header="isRelatedMode ? 'إضافة كتاب تأكيدي' : 'تعديل الكتاب'"
            :style="{ width: '750px' }" modal class="rounded-2xl!">
            <LetterForm v-model="form" :errors="errors" :category-options="categoryOptions"
                :subject-options="subjectOptions" :assignment-options="assignmentOptions"
                :status-options="statusOptions" :employee-options="employeeOptions"
                @refresh-subjects="handleRefreshSubjects" @refresh-employees="handleRefreshEmployees"
                :is-related="isRelatedMode" />

            <template #footer>
                <div class="flex justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
                    <Button label="إلغاء" severity="secondary" text @click="dialogVisible = false" />
                    <Button :label="isRelatedMode ? 'إضافة' : 'تحديث'" :loading="saving" @click="saveLetter"
                        class="bg-indigo-600! hover:bg-indigo-700!" />
                </div>
            </template>
        </Dialog>

        <!-- Delete Confirmation -->
        <Dialog v-model:visible="deleteDialogVisible" header="تأكيد الحذف" :style="{ width: '420px' }" modal>
            <div class="flex items-start gap-4 py-2">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-1">حذف الكتاب المرتبط</h4>
                    <p class="text-gray-600 text-sm">
                        هل أنت متأكد من حذف الكتاب رقم
                        <span class="font-bold text-red-600">"{{ itemToDelete?.letter_number }}"</span>؟
                    </p>
                </div>
            </div>
            <template #footer>
                <Button label="إلغاء" severity="secondary" text @click="deleteDialogVisible = false" />
                <Button label="حذف" severity="danger" :loading="deleting" @click="deleteLetter" />
            </template>
        </Dialog>

        <Toast position="top-left" />
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'
import { useLetterStore } from '../../stores/letters'
import { useCategoryStore } from '../../stores/categories'
import { useSubjectStore } from '../../stores/subjects'
import { useAssignmentStore } from '../../stores/assignments'
import { useEmployeeStore } from '../../stores/employees'
import { useLetterStatusStore } from '../../stores/letterStatuses'
import { useToast } from 'primevue/usetoast'
import LetterForm from '../../components/letters/LetterForm.vue'
import AppSpinner from '../../components/core/AppSpinner.vue'
import Button from 'primevue/button'
import Tag from 'primevue/tag'
import Message from 'primevue/message'
import Dialog from 'primevue/dialog'
import Toast from 'primevue/toast'

const route = useRoute()
const store = useLetterStore()
const categoryStore = useCategoryStore()
const subjectStore = useSubjectStore()
const assignmentStore = useAssignmentStore()
const employeeStore = useEmployeeStore()
const letterStatusStore = useLetterStatusStore()
const toast = useToast()

const letter = ref(null)
const loading = ref(false)
const error = ref(null)

// Dropdown options
const categoryOptions = ref([])
const subjectOptions = ref([])
const assignmentOptions = ref([])
const employeeOptions = ref([])
const statusOptions = ref([])

// Dialog state
const dialogVisible = ref(false)
const deleteDialogVisible = ref(false)
const isRelatedMode = ref(false)
const saving = ref(false)
const deleting = ref(false)
const errors = ref({})
const itemToDelete = ref(null)

const form = ref({
    id: null, // Added ID for updates
    category_id: null,
    subject_id: null,
    assignment_id: null,
    employee_id: null,
    letter_status_id: null,
    letter_number: null,
    date: null,
    export: false,
    outgoings: [],
    on_going_number: null, // Incoming number
    on_going_date: null,   // Incoming date
    reply_deadline_days: null,
    progress_status: null,
    // Memo fields
    memo_number: null,
    memo_date: null,
    forwarded_to_department: null,
    case_no_year: null,
    // Non-cooperative fields
    noncooperative_recipient: null,
    noncooperative_date: null,
    noncooperative_number: null,
    non_cooperative_items: [],
    parent_letter_id: null,
    attachments: [],
    attachmentData: { newFiles: [], removedIds: [] } // For file uploads
})

// Fetch data
async function loadLetter() {
    loading.value = true
    try {
        letter.value = await store.fetchOne(route.params.id)
    } catch (e) {
        error.value = 'فشل في تحميل بيانات الكتاب'
    } finally {
        loading.value = false
    }
}

// Watch route changes (to reload when navigating between related letters)
watch(() => route.params.id, () => {
    loadLetter()
})

onMounted(() => {
    loadLetter()

    // Load options
    categoryStore.fetchAllForDropdown().then(data => categoryOptions.value = data)
    subjectStore.fetchAllForDropdown().then(data => subjectOptions.value = data)
    assignmentStore.fetchAllForDropdown().then(data => assignmentOptions.value = data)
    employeeStore.fetchAllForDropdown().then(data => employeeOptions.value = data)
    letterStatusStore.fetchAllForDropdown().then(data => statusOptions.value = data)
})


function formatDateForApi(date) {
    if (!date) return null
    const d = new Date(date)
    const year = d.getFullYear()
    const month = String(d.getMonth() + 1).padStart(2, '0')
    const day = String(d.getDate()).padStart(2, '0')
    return `${year}-${month}-${day}`
}

function openEditDialog() {
    isRelatedMode.value = false
    const item = letter.value
    form.value = {
        id: item.id,
        category_id: item.category_id,
        subject_id: item.subject_id,
        assignment_id: item.assignment_id,
        employee_id: item.employee_id,
        letter_status_id: item.letter_status_id,
        letter_number: item.letter_number,
        date: item.date ? new Date(item.date) : null,
        // Map outgoings to form structure
        outgoings: item.outgoings ? item.outgoings.map(o => ({
            outgoing_number: o.outgoing_number,
            outgoing_date: o.outgoing_date ? new Date(o.outgoing_date) : null
        })) : [],
        on_going_number: item.on_going_number,
        on_going_date: item.on_going_date ? new Date(item.on_going_date) : null,
        reply_deadline_days: item.reply_deadline_days,
        progress_status: item.progress_status,
        parent_letter_id: item.parent_letter_id,
        case_no_year: item.case_no_year,
        attachments: item.attachments || [],
        attachmentData: { newFiles: [], removedIds: [] },
        non_cooperative_items: item.non_cooperative_items ? item.non_cooperative_items.map(i => ({
            recipient: i.recipient,
            date: i.date ? new Date(i.date) : null,
            number: i.number
        })) : []
    }
    errors.value = {}
    dialogVisible.value = true
}

function openEditRelated(item) {
    isRelatedMode.value = false
    form.value = {
        id: item.id,
        category_id: item.category_id,
        subject_id: item.subject_id,
        assignment_id: item.assignment_id,
        employee_id: item.employee_id,
        letter_status_id: item.letter_status_id,
        letter_number: item.letter_number,
        date: item.date ? new Date(item.date) : null,
        export: item.export,
        outgoing_number: item.outgoing_number,
        outgoing_date: item.outgoing_date ? new Date(item.outgoing_date) : null,
        on_going_number: item.on_going_number,
        on_going_date: item.on_going_date ? new Date(item.on_going_date) : null,
        reply_deadline_days: item.reply_deadline_days,
        progress_status: item.progress_status,
        noncooperative_recipient: item.noncooperative_recipient,
        noncooperative_date: item.noncooperative_date ? new Date(item.noncooperative_date) : null,
        noncooperative_number: item.noncooperative_number,
        parent_letter_id: item.parent_letter_id,
        attachments: item.attachments || [],
        attachmentData: { newFiles: [], removedIds: [] },
        non_cooperative_items: item.non_cooperative_items ? item.non_cooperative_items.map(i => ({
            recipient: i.recipient,
            date: i.date ? new Date(i.date) : null,
            number: i.number
        })) : []
    }
    errors.value = {}
    dialogVisible.value = true
}

function openAddRelatedDialog() {
    isRelatedMode.value = true
    form.value = {
        id: null,
        category_id: letter.value.category_id,
        subject_id: letter.value.subject_id,
        assignment_id: letter.value.assignment_id,
        employee_id: null,
        letter_status_id: null,
        letter_number: null,
        date: new Date(),
        outgoings: letter.value.outgoings ? letter.value.outgoings.map(o => ({
            outgoing_number: o.outgoing_number,
            outgoing_date: o.outgoing_date ? new Date(o.outgoing_date) : null
        })) : [],
        case_no_year: letter.value.case_no_year,
        on_going_date: null,
        reply_deadline_days: null,
        progress_status: null,
        parent_letter_id: letter.value.id,
        attachments: [],
        attachmentData: { newFiles: [], removedIds: [] },
        non_cooperative_items: []
    }
    errors.value = {}
    dialogVisible.value = true
}

function confirmDelete(item) {
    itemToDelete.value = item
    deleteDialogVisible.value = true
}

function deleteLetter() {
    if (!itemToDelete.value) return
    deleting.value = true
    store.remove(itemToDelete.value.id)
        .then(() => {
            toast.add({ severity: 'success', summary: 'نجاح', detail: 'تم حذف الكتاب بنجاح', life: 3000 })
            loading.value = true // Show loading while reloading parent
            return loadLetter()
        })
        .catch(() => {
            toast.add({ severity: 'error', summary: 'خطأ', detail: 'فشل حذف الكتاب', life: 3000 })
        })
        .finally(() => {
            deleting.value = false
            deleteDialogVisible.value = false
            itemToDelete.value = null
        })
}

function saveLetter() {
    saving.value = true
    errors.value = {}

    const payload = new FormData()
    payload.append('category_id', form.value.category_id || '')
    payload.append('subject_id', form.value.subject_id || '')
    payload.append('assignment_id', form.value.assignment_id || '')
    if (form.value.employee_id) payload.append('employee_id', form.value.employee_id)
    if (form.value.letter_status_id) payload.append('letter_status_id', form.value.letter_status_id)
    payload.append('letter_number', form.value.letter_number || '')
    if (form.value.date) payload.append('date', formatDateForApi(form.value.date))

    payload.append('export', form.value.export ? '1' : '0')

    if (form.value.letter_status_id === 2 && form.value.outgoings && form.value.outgoings.length > 0) {
        form.value.outgoings.forEach((outgoing, index) => {
            payload.append(`outgoings[${index}][outgoing_number]`, outgoing.outgoing_number || '')
            if (outgoing.outgoing_date) {
                payload.append(`outgoings[${index}][outgoing_date]`, formatDateForApi(outgoing.outgoing_date))
            }
        })
    }

    if (!form.value.export) {
        if (form.value.on_going_number) payload.append('on_going_number', form.value.on_going_number)
        if (form.value.on_going_date) payload.append('on_going_date', formatDateForApi(form.value.on_going_date))
    }

    if (form.value.reply_deadline_days) payload.append('reply_deadline_days', form.value.reply_deadline_days)
    if (form.value.progress_status) payload.append('progress_status', form.value.progress_status)
    if (form.value.noncooperative_recipient) payload.append('noncooperative_recipient', form.value.noncooperative_recipient)
    if (form.value.noncooperative_date) payload.append('noncooperative_date', formatDateForApi(form.value.noncooperative_date))
    if (form.value.noncooperative_number) payload.append('noncooperative_number', form.value.noncooperative_number)

    // Non-cooperative items
    if (form.value.non_cooperative_items && form.value.non_cooperative_items.length > 0) {
        form.value.non_cooperative_items.forEach((item, index) => {
            if (item.recipient) payload.append(`non_cooperative_items[${index}][recipient]`, item.recipient)
            if (item.number) payload.append(`non_cooperative_items[${index}][number]`, item.number)
            if (item.date) payload.append(`non_cooperative_items[${index}][date]`, formatDateForApi(item.date))
        })
    } else {
        // Send empty value so backend knows to clear existing items
        payload.append('non_cooperative_items', '')
    }

    // Memo fields
    if (form.value.memo_number) payload.append('memo_number', form.value.memo_number)
    if (form.value.memo_date) payload.append('memo_date', formatDateForApi(form.value.memo_date))
    if (form.value.forwarded_to_department) payload.append('forwarded_to_department', form.value.forwarded_to_department)
    if (form.value.case_no_year) payload.append('case_no_year', form.value.case_no_year)

    if (form.value.parent_letter_id) {
        payload.append('parent_letter_id', form.value.parent_letter_id)
    }

    // Add new attachments
    const { newFiles, removedIds } = form.value.attachmentData || { newFiles: [], removedIds: [] }
    newFiles.forEach((file) => {
        payload.append('attachments[]', file)
    })

    // Add removed attachment IDs (for update)
    if (removedIds && removedIds.length > 0) {
        removedIds.forEach((id) => {
            payload.append('removed_attachment_ids[]', id)
        })
    }


    // For PUT requests with FormData, use POST with _method override
    if (!isRelatedMode.value) {
        payload.append('_method', 'PUT')
    }

    // Determine if we are creating a NEW related letter OR editing an EXISTING letter (main or related)
    const action = isRelatedMode.value
        ? store.createWithFormData(payload)
        : store.updateWithFormData(form.value.id, payload)

    action
        .then((response) => {
            toast.add({
                severity: 'success',
                summary: 'نجاح',
                detail: isRelatedMode.value ? 'تم إضافة الكتاب التأكيدي بنجاح' : 'تم تحديث الكتاب بنجاح',
                life: 3000
            })
            dialogVisible.value = false
            loadLetter() // Refresh details
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
function handleRefreshSubjects(newSubjectId) {
    subjectStore.fetchAllForDropdown().then(data => {
        subjectOptions.value = data
        form.value.subject_id = newSubjectId
    })
}

function handleRefreshEmployees(newEmployeeId) {
    employeeStore.fetchAllForDropdown().then(data => {
        employeeOptions.value = data
        form.value.employee_id = newEmployeeId
    })
}
</script>

<template>
    <div class="space-y-6">
        <!-- Form Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Category -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">التصنيف *</label>
                <Select v-model="localForm.category_id" :options="categoryOptions" optionLabel="title" optionValue="id"
                    placeholder="اختر التصنيف" :class="{ 'p-invalid': errors.category_id }" class="w-full" />
                <small v-if="errors.category_id" class="text-red-500 text-xs">{{ errors.category_id[0] }}</small>
            </div>

            <!-- Subject with Add Button -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">الموضوع *</label>
                <div class="flex gap-2">
                    <Select v-model="localForm.subject_id" :options="subjectOptions" optionLabel="title"
                        optionValue="id" placeholder="اختر الموضوع" :class="{ 'p-invalid': errors.subject_id }"
                        class="flex-1" />
                    <Button severity="secondary" @click="openAddSubjectDialog" v-tooltip.top="'إضافة موضوع جديد'"
                        class="w-10! h-10! p-0! border-dashed! border-slate-300! dark:border-slate-600!">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </template>
                    </Button>
                </div>
                <small v-if="errors.subject_id" class="text-red-500 text-xs">{{ errors.subject_id[0] }}</small>
            </div>

            <!-- Assignment -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">الجهة المكلفة *</label>
                <Select v-model="localForm.assignment_id" :options="assignmentOptions" optionLabel="title"
                    optionValue="id" placeholder="اختر الجهة المكلفة" :class="{ 'p-invalid': errors.assignment_id }"
                    class="w-full" />
                <small v-if="errors.assignment_id" class="text-red-500 text-xs">{{ errors.assignment_id[0] }}</small>
            </div>

            <!-- Employee with Add Button -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">الموظف المكلف</label>
                <div class="flex gap-2">
                    <Select v-model="localForm.employee_id" :options="employeeOptions" optionLabel="name"
                        optionValue="id" placeholder="اختر الموظف المكلف" showClear
                        :class="{ 'p-invalid': errors.employee_id }" class="flex-1" />
                    <Button severity="secondary" @click="openAddEmployeeDialog" v-tooltip.top="'إضافة موظف جديد'"
                        class="w-10! h-10! p-0! border-dashed! border-slate-300! dark:border-slate-600!">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </template>
                    </Button>
                </div>
                <small v-if="errors.employee_id" class="text-red-500 text-xs">{{ errors.employee_id[0] }}</small>
            </div>

            <!-- Letter Status -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">حالة الكتاب</label>
                <Select v-model="localForm.letter_status_id" :options="statusOptions" optionLabel="title"
                    optionValue="id" placeholder="اختر الحالة" showClear
                    :class="{ 'p-invalid': errors.letter_status_id }" class="w-full" />
                <small v-if="errors.letter_status_id" class="text-red-500 text-xs">{{ errors.letter_status_id[0]
                    }}</small>
            </div>

            <!-- Letter Number -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">رقم الكتاب *</label>
                <InputText v-model="localForm.letter_number" :class="{ 'p-invalid': errors.letter_number }"
                    class="w-full" />
                <small v-if="errors.letter_number" class="text-red-500 text-xs">{{ errors.letter_number[0] }}</small>
            </div>

            <!-- Date -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">تاريخ الكتاب *</label>
                <DatePicker v-model="localForm.date" dateFormat="yy-mm-dd" :maxDate="new Date()"
                    :class="{ 'p-invalid': errors.date }" class="w-full" />
                <small v-if="errors.date" class="text-red-500 text-xs">{{ errors.date[0] }}</small>
            </div>

            <!-- Case Number/Year -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">رقم القضية/السنة</label>
                <InputText v-model="localForm.case_no_year" :disabled="props.isRelated"
                    :class="{ 'p-invalid': errors.case_no_year }" class="w-full"
                    placeholder="في حاله وجود رقم قضية/سنة" />
                <small v-if="errors.case_no_year" class="text-red-500 text-xs">{{ errors.case_no_year[0] }}</small>
            </div>

            <!-- Attachments -->
            <div class="col-span-2">
                <AttachmentsInput :existing-attachments="localForm.attachments || []"
                    v-model="localForm.attachmentData" />
                <small v-if="errors.attachments" class="text-red-500 text-xs">{{ errors.attachments[0] }}</small>
            </div>


            <!-- Outgoing Reply Fields (Dynamic List) -->
            <div v-if="localForm.letter_status_id === 2"
                class="col-span-2 space-y-4 border rounded-lg p-4 bg-slate-50 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold text-slate-700 dark:text-slate-200 text-sm">ردود جهة التكليف (الصادر)</h4>
                    <Button label="إضافة رد" size="small" outlined @click="addOutgoingRow">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </template>
                    </Button>
                </div>

                <div v-if="!localForm.outgoings || localForm.outgoings.length === 0"
                    class="text-center py-4 text-slate-500 dark:text-slate-400 text-sm italic">
                    لا توجد ردود مضافة. اضغط على "إضافة رد" لإدراج بيانات الصادر.
                </div>

                <div v-for="(outgoing, index) in localForm.outgoings" :key="index"
                    class="flex flex-col md:flex-row gap-4 relative pt-12 bg-white dark:bg-slate-800 p-4 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">

                    <Button text severity="danger" rounded aria-label="Delete"
                        class="absolute top-2 right-2 p-0! w-8! h-8!" @click="removeOutgoingRow(index)"
                        v-tooltip.top="'حذف الرد'">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </template>
                    </Button>

                    <!-- Outgoing Number -->
                    <div class="flex-1 min-w-0 flex flex-col gap-2">
                        <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">رقم الصادر <span
                                class="text-red-500">*</span></label>
                        <InputText v-model="outgoing.outgoing_number" placeholder="أدخل رقم الصادر" fluid
                            :class="{ 'p-invalid': errors[`outgoings.${index}.outgoing_number`] }" />
                        <small v-if="errors[`outgoings.${index}.outgoing_number`]" class="text-red-500 text-xs">{{
                            errors[`outgoings.${index}.outgoing_number`][0] }}</small>
                    </div>

                    <!-- Outgoing Date -->
                    <div class="flex-1 min-w-0 flex flex-col gap-2">
                        <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">تاريخ الصادر <span
                                class="text-red-500">*</span></label>
                        <DatePicker v-model="outgoing.outgoing_date" showIcon fluid iconDisplay="input"
                            dateFormat="yy-mm-dd" placeholder="اختر التاريخ"
                            :class="{ 'p-invalid': errors[`outgoings.${index}.outgoing_date`] }" />
                        <small v-if="errors[`outgoings.${index}.outgoing_date`]" class="text-red-500 text-xs">{{
                            errors[`outgoings.${index}.outgoing_date`][0] }}</small>
                    </div>
                </div>
                <small v-if="errors.outgoings" class="text-red-500 text-xs block mt-2">{{ errors.outgoings[0] }}</small>
            </div>

            <!-- Incoming Fields (when export is false) -->
            <template v-else-if="localForm.letter_status_id == 1 || localForm.letter_status_id == 4">
                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">رقم الوارد</label>
                    <InputText v-model="localForm.on_going_number" :min="1"
                        :class="{ 'p-invalid': errors.on_going_number }" class="w-full" />
                    <small v-if="errors.on_going_number" class="text-red-500 text-xs">{{ errors.on_going_number[0]
                        }}</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">تاريخ الوارد</label>
                    <DatePicker v-model="localForm.on_going_date" dateFormat="yy-mm-dd"
                        :class="{ 'p-invalid': errors.on_going_date }" class="w-full" />
                    <small v-if="errors.on_going_date" class="text-red-500 text-xs">{{ errors.on_going_date[0]
                        }}</small>
                </div>
            </template>

            <!-- Memo Fields Section (shown when status = 3 - محول) -->
            <template v-if="localForm.letter_status_id === 3">
                <div class="col-span-2 border-t border-slate-200 dark:border-slate-700 pt-4 mt-2">
                    <h4 class="font-semibold text-slate-600 dark:text-slate-300 text-sm flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        بيانات التحويل <span class="text-red-500">*</span>
                    </h4>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">رقم المذكرة <span
                            class="text-red-500">*</span></label>
                    <InputText v-model="localForm.memo_number" :class="{ 'p-invalid': errors.memo_number }"
                        class="w-full" placeholder="أدخل رقم المذكرة..." />
                    <small v-if="errors.memo_number" class="text-red-500 text-xs">{{ errors.memo_number[0] }}</small>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">تاريخ المذكرة <span
                            class="text-red-500">*</span></label>
                    <DatePicker v-model="localForm.memo_date" dateFormat="yy-mm-dd"
                        :class="{ 'p-invalid': errors.memo_date }" class="w-full" />
                    <small v-if="errors.memo_date" class="text-red-500 text-xs">{{ errors.memo_date[0] }}</small>
                </div>

                <div class="flex flex-col gap-2 col-span-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">الجهة المحول إليها <span
                            class="text-red-500">*</span></label>
                    <InputText v-model="localForm.forwarded_to_department"
                        :class="{ 'p-invalid': errors.forwarded_to_department }" class="w-full"
                        placeholder="اسم الجهة المحول إليها..." />
                    <small v-if="errors.forwarded_to_department" class="text-red-500 text-xs">{{
                        errors.forwarded_to_department[0] }}</small>
                </div>
            </template>

            <!-- Non-Cooperative Items Section -->
            <div
                class="col-span-2 space-y-4 border rounded-lg p-4 bg-red-50 dark:bg-red-900/10 border-red-100 dark:border-red-900/30">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold text-slate-700 dark:text-slate-200 text-sm">كتب عدم التعاون</h4>
                    <Button label="إضافة كتاب" size="small" outlined severity="danger" @click="addNonCooperativeItem">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </template>
                    </Button>
                </div>

                <div v-if="!localForm.non_cooperative_items || localForm.non_cooperative_items.length === 0"
                    class="text-center py-4 text-slate-500 dark:text-slate-400 text-sm italic">
                    لا توجد كتب عدم تعاون مضافة.
                </div>

                <div v-for="(item, index) in localForm.non_cooperative_items" :key="index"
                    class="flex flex-col md:flex-row gap-4 relative pt-12 bg-white dark:bg-slate-800 p-4 rounded-lg border border-slate-200 dark:border-slate-700 shadow-sm">

                    <Button text severity="danger" rounded aria-label="Delete"
                        class="absolute top-2 right-2 p-0! w-8! h-8!" @click="removeNonCooperativeItem(index)"
                        v-tooltip.top="'حذف الكتاب'">
                        <template #icon>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </template>
                    </Button>

                    <!-- Recipient -->
                    <div class="flex-1 min-w-0 flex flex-col gap-2">
                        <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">الجهة المرسل إليها <span
                                class="text-red-500">*</span></label>
                        <InputText v-model="item.recipient" placeholder="أدخل اسم الجهة" fluid
                            :class="{ 'p-invalid': errors[`non_cooperative_items.${index}.recipient`] }" />
                        <small v-if="errors[`non_cooperative_items.${index}.recipient`]" class="text-red-500 text-xs">{{
                            errors[`non_cooperative_items.${index}.recipient`][0] }}</small>
                    </div>

                    <!-- Number -->
                    <div class="flex-1 min-w-0 flex flex-col gap-2">
                        <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">رقم الكتاب <span
                                class="text-red-500">*</span></label>
                        <InputText v-model="item.number" placeholder="أدخل رقم الكتاب" fluid
                            :class="{ 'p-invalid': errors[`non_cooperative_items.${index}.number`] }" />
                        <small v-if="errors[`non_cooperative_items.${index}.number`]" class="text-red-500 text-xs">{{
                            errors[`non_cooperative_items.${index}.number`][0] }}</small>
                    </div>

                    <!-- Date -->
                    <div class="flex-1 min-w-0 flex flex-col gap-2">
                        <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">تاريخ الكتاب <span
                                class="text-red-500">*</span></label>
                        <DatePicker v-model="item.date" showIcon fluid iconDisplay="input" dateFormat="yy-mm-dd"
                            placeholder="اختر التاريخ"
                            :class="{ 'p-invalid': errors[`non_cooperative_items.${index}.date`] }" />
                        <small v-if="errors[`non_cooperative_items.${index}.date`]" class="text-red-500 text-xs">{{
                            errors[`non_cooperative_items.${index}.date`][0] }}</small>
                    </div>
                </div>
                <small v-if="errors.non_cooperative_items" class="text-red-500 text-xs block mt-2">{{
                    errors.non_cooperative_items[0] }}</small>
            </div>

            <!-- Divider for Progress Section -->
            <div class="col-span-2 border-t border-slate-200 dark:border-slate-700 pt-4 mt-2">
                <h4 class="font-semibold text-slate-600 dark:text-slate-300 text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    متابعة سير العمل
                </h4>
            </div>

            <!-- Reply Deadline -->
            <div class="flex flex-col gap-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">مهلة الرد (بالأيام)</label>
                <InputNumber v-model="localForm.reply_deadline_days" :min="1"
                    :class="{ 'p-invalid': errors.reply_deadline_days }" class="w-full" />
                <small v-if="errors.reply_deadline_days" class="text-red-500 text-xs">{{ errors.reply_deadline_days[0]
                    }}</small>
            </div>

            <!-- Progress Status -->
            <div class="flex flex-col gap-2 col-span-2">
                <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">حالة سير العمل</label>
                <Textarea v-model="localForm.progress_status" rows="2" :class="{ 'p-invalid': errors.progress_status }"
                    class="w-full" placeholder="أدخل ملاحظات عن سير العمل..." />
                <small v-if="errors.progress_status" class="text-red-500 text-xs">{{ errors.progress_status[0]
                    }}</small>
            </div>
        </div>

        <!-- Add Subject Dialog -->
        <Dialog v-model:visible="addSubjectDialogVisible" header="إضافة موضوع جديد" :style="{ width: '450px' }" modal>
            <div class="space-y-4 pt-4">
                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">العنوان *</label>
                    <InputText v-model="newSubjectForm.title" :class="{ 'p-invalid': newSubjectErrors.title }"
                        class="w-full" />
                    <small v-if="newSubjectErrors.title" class="text-red-500 text-xs">{{ newSubjectErrors.title[0]
                        }}</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">الوصف</label>
                    <Textarea v-model="newSubjectForm.description" rows="3" class="w-full" />
                </div>
            </div>
            <template #footer>
                <Button label="إلغاء" severity="secondary" text @click="addSubjectDialogVisible = false" />
                <Button label="إضافة" :loading="savingSubject" @click="createNewSubject" />
            </template>
        </Dialog>

        <!-- Add Employee Dialog -->
        <Dialog v-model:visible="addEmployeeDialogVisible" header="إضافة موظف جديد" :style="{ width: '450px' }" modal>
            <div class="space-y-4 pt-4">
                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">اسم الموظف *</label>
                    <InputText v-model="newEmployeeForm.name" :class="{ 'p-invalid': newEmployeeErrors.name }"
                        class="w-full" placeholder="أدخل اسم الموظف" />
                    <small v-if="newEmployeeErrors.name" class="text-red-500 text-xs">{{ newEmployeeErrors.name[0]
                        }}</small>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-semibold text-slate-700 dark:text-slate-200 text-sm">المسمى الوظيفي</label>
                    <InputText v-model="newEmployeeForm.job_title" class="w-full" placeholder="مثال: مدير القسم" />
                </div>
            </div>
            <template #footer>
                <Button label="إلغاء" severity="secondary" text @click="addEmployeeDialogVisible = false" />
                <Button label="إضافة" :loading="savingEmployee" @click="createNewEmployee" />
            </template>
        </Dialog>
    </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useSubjectStore } from '../../stores/subjects'
import { useEmployeeStore } from '../../stores/employees'
import { useToast } from 'primevue/usetoast'
import Select from 'primevue/select'
import InputText from 'primevue/inputtext'
import InputNumber from 'primevue/inputnumber'
import Textarea from 'primevue/textarea'
import DatePicker from 'primevue/datepicker'
import Checkbox from 'primevue/checkbox'
import Button from 'primevue/button'
import Dialog from 'primevue/dialog'
import AttachmentsInput from './AttachmentsInput.vue'

const props = defineProps({
    modelValue: {
        type: Object,
        required: true
    },
    errors: {
        type: Object,
        default: () => ({})
    },
    categoryOptions: {
        type: Array,
        default: () => []
    },
    subjectOptions: {
        type: Array,
        default: () => []
    },
    assignmentOptions: {
        type: Array,
        default: () => []
    },
    statusOptions: {
        type: Array,
        default: () => []
    },
    employeeOptions: {
        type: Array,
        default: () => []
    },
    isRelated: {
        type: Boolean,
    }
})

const emit = defineEmits(['update:modelValue', 'refreshSubjects', 'refreshEmployees'])

const subjectStore = useSubjectStore()
const employeeStore = useEmployeeStore()
const toast = useToast()

// Local form copy for two-way binding
const localForm = computed({
    get: () => props.modelValue,
    set: (val) => emit('update:modelValue', val)
})

// Subject inline create
const addSubjectDialogVisible = ref(false)
const newSubjectForm = ref({ title: '', description: '' })
const newSubjectErrors = ref({})
const savingSubject = ref(false)

// Employee inline create
const addEmployeeDialogVisible = ref(false)
const newEmployeeForm = ref({ name: '', job_title: '' })
const newEmployeeErrors = ref({})
const savingEmployee = ref(false)

// Subject dialog handlers
function openAddSubjectDialog() {
    newSubjectForm.value = { title: '', description: '' }
    newSubjectErrors.value = {}
    addSubjectDialogVisible.value = true
}

function createNewSubject() {
    savingSubject.value = true
    newSubjectErrors.value = {}

    subjectStore.create(newSubjectForm.value)
        .then((response) => {
            const newSubject = response.data
            emit('refreshSubjects', newSubject.id)
            toast.add({
                severity: 'success',
                summary: 'نجاح',
                detail: 'تم إنشاء الموضوع بنجاح',
                life: 3000
            })
            addSubjectDialogVisible.value = false
        })
        .catch((err) => {
            if (err.response?.data?.errors) {
                newSubjectErrors.value = err.response.data.errors
            }
        })
        .finally(() => {
            savingSubject.value = false
        })
}

// Employee dialog handlers
function openAddEmployeeDialog() {
    newEmployeeForm.value = { name: '', job_title: '' }
    newEmployeeErrors.value = {}
    addEmployeeDialogVisible.value = true
}

function createNewEmployee() {
    savingEmployee.value = true
    newEmployeeErrors.value = {}

    employeeStore.createEmployee(newEmployeeForm.value)
        .then((result) => {
            if (result.success) {
                emit('refreshEmployees', result.data.id)
                toast.add({
                    severity: 'success',
                    summary: 'نجاح',
                    detail: 'تم إنشاء الموظف بنجاح',
                    life: 3000
                })
                addEmployeeDialogVisible.value = false
            } else {
                newEmployeeErrors.value = result.errors || {}
            }
        })
        .finally(() => {
            savingEmployee.value = false
        })
}
// Outgoing rows handlers
function addOutgoingRow() {
    if (!localForm.value.outgoings) localForm.value.outgoings = []
    localForm.value.outgoings.push({ outgoing_number: '', outgoing_date: null })
}

function removeOutgoingRow(index) {
    if (localForm.value.outgoings) {
        // Prevent removing the last row if status is 2 (Responded/Exported)
        if (localForm.value.letter_status_id === 2 && localForm.value.outgoings.length <= 1) {
            toast.add({
                severity: 'warn',
                summary: 'تنبيه',
                detail: 'يجب أن يحتوي الكتاب على رد واحد على الأقل عندما تكون الحالة "تم الرد"',
                life: 3000
            })
            return
        }
        localForm.value.outgoings.splice(index, 1)
    }
}

// Non-Cooperative items handlers
function addNonCooperativeItem() {
    if (!localForm.value.non_cooperative_items) localForm.value.non_cooperative_items = []
    localForm.value.non_cooperative_items.push({ recipient: '', number: '', date: null })
}

function removeNonCooperativeItem(index) {
    if (localForm.value.non_cooperative_items) {
        localForm.value.non_cooperative_items.splice(index, 1)
    }
}

// Watch for status changes to initialize outgoings array if needed
watch(() => localForm.value.letter_status_id, (newVal) => {
    if (newVal === 2) {
        if (!localForm.value.outgoings || localForm.value.outgoings.length === 0) {
            localForm.value.outgoings = [{ outgoing_number: '', outgoing_date: null }]
        }
    }
})
</script>

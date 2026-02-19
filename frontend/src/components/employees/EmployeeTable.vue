<template>
    <div class="card overflow-hidden">
        <!-- Loading -->
        <div v-if="loading" class="flex items-center justify-center py-12">
            <AppSpinner size="md" text="جاري تحميل البيانات..." />
        </div>

        <!-- Table -->
        <div v-else-if="items && items.length" class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 60px">#</th>
                        <th>اسم الموظف</th>
                        <th>المسمى الوظيفي</th>
                        <th style="width: 120px">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id">
                        <td>
                            <span class="text-xs font-mono bg-slate-100 dark:bg-slate-700 px-2 py-1 rounded">
                                {{ item.id }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center border border-emerald-200 dark:border-emerald-800/50">
                                    <span class="text-emerald-600 dark:text-emerald-400 font-bold text-sm">
                                        {{ item.name?.charAt(0) || 'م' }}
                                    </span>
                                </div>
                                <span class="font-semibold text-slate-700 dark:text-slate-200">{{ item.name }}</span>
                            </div>
                        </td>
                        <td>
                            <span v-if="item.job_title"
                                class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-medium border border-slate-200 dark:border-slate-600">
                                {{ item.job_title }}
                            </span>
                            <span v-else class="text-slate-400 text-sm">—</span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <button v-if="can('employees.update')" @click="$emit('edit', item)"
                                    v-tooltip.top="'تعديل'"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-200 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                                <button v-if="can('employees.delete')" @click="$emit('delete', item)"
                                    v-tooltip.top="'حذف'"
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-200 transition-colors">
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

        <!-- Empty State -->
        <div v-else class="p-12 text-center">
            <div
                class="w-16 h-16 mx-auto mb-4 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-900 dark:text-white mb-2">لا يوجد موظفين</h3>
            <p class="text-slate-600 dark:text-slate-400">ابدأ بإضافة موظف جديد</p>
        </div>

        <!-- Pagination -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 p-4 border-t border-slate-200 dark:border-slate-700"
            v-if="meta && meta.lastPage > 1">
            <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                <span class="font-medium">إجمالي:</span>
                <span
                    class="px-2 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-md font-bold">
                    {{ meta.total }}
                </span>
                <span>موظف</span>
            </div>
            <div class="flex items-center gap-2">
                <button @click="$emit('page-change', meta.currentPage - 1)" :disabled="meta.currentPage === 1"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                    السابق
                </button>
                <span class="px-4 py-2 text-sm text-slate-600 dark:text-slate-300">
                    {{ meta.currentPage }} / {{ meta.lastPage }}
                </span>
                <button @click="$emit('page-change', meta.currentPage + 1)"
                    :disabled="meta.currentPage === meta.lastPage"
                    class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-lg transition-all disabled:opacity-50 disabled:cursor-not-allowed bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-600">
                    التالي
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import AppSpinner from '../../components/core/AppSpinner.vue'
import { useCan } from '../../composables/useCan'

const { can } = useCan()

defineProps({
    items: {
        type: Array,
        required: true
    },
    loading: {
        type: Boolean,
        default: false
    },
    meta: {
        type: Object,
        default: () => ({ lastPage: 1, currentPage: 1, total: 0 })
    }
})

defineEmits(['edit', 'delete', 'page-change'])

</script>

<template>
    <div class="card overflow-hidden">
        <!-- Loading -->
        <div v-if="loading" class="flex items-center justify-center py-12">
            <AppSpinner size="md" text="جاري تحميل البيانات..." />
        </div>

        <!-- Table -->
        <div v-else-if="items.length" class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 100px">رقم الكتاب</th>
                        <th>التصنيف</th>
                        <th>الموضوع</th>
                        <th>الجهة المكلفة</th>
                        <th style="width: 140px">الحالة</th>
                        <th>التاريخ</th>
                        <th style="width: 80px">صادر</th>
                        <th style="width: 140px">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in items" :key="item.id" class="group">
                        <!-- Letter Number -->
                        <td>
                            <div class="flex items-center gap-2">
                                <div
                                    class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span
                                    class="font-bold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 rounded-md text-sm">
                                    #{{ item.letter_number }}
                                </span>
                                <!-- Related Letters Count Badge -->
                                <span v-if="item.related_letters_count > 0"
                                    class="px-2 py-1 rounded-md text-xs font-bold bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:text-rose-400 border border-rose-200 dark:border-rose-800"
                                    v-tooltip.top="'عدد الكتب المرتبطة'">
                                    +{{ item.related_letters_count }}
                                </span>
                            </div>
                        </td>

                        <!-- Category -->
                        <td>
                            <div v-if="item.category" class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xs font-bold">
                                    {{ item.category.title?.charAt(0) }}
                                </div>
                                <span class="text-slate-700 dark:text-slate-200 font-medium">{{ item.category.title
                                    }}</span>
                            </div>
                            <span v-else class="text-slate-400">-</span>
                        </td>

                        <!-- Subject -->
                        <td>
                            <span v-if="item.subject"
                                class="text-slate-700 dark:text-slate-200 font-medium line-clamp-1">
                                {{ item.subject.title }}
                            </span>
                            <span v-else class="text-slate-400">-</span>
                        </td>

                        <!-- Assignment -->
                        <td>
                            <div v-if="item.assignment" class="flex items-center gap-2">
                                <div
                                    class="w-6 h-6 rounded-full bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xs font-bold">
                                    {{ item.assignment.title?.charAt(0) }}
                                </div>
                                <span class="text-slate-600 dark:text-slate-300 text-sm">{{ item.assignment.title
                                    }}</span>
                            </div>
                            <span v-else class="text-slate-400">-</span>
                        </td>

                        <!-- Status -->
                        <td>
                            <span v-if="item.letter_status"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border transition-all shadow-sm"
                                :style="getStatusStyle(item.letter_status)">
                                <span class="w-2 h-2 rounded-full animate-pulse"
                                    :style="{ backgroundColor: getStatusStyle(item.letter_status).color }"></span>
                                {{ item.letter_status.title }}
                            </span>
                            <span v-else
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
                                غير محدد
                            </span>
                        </td>

                        <!-- Date -->
                        <td>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-slate-600 dark:text-slate-300 text-sm">{{ item.date
                                }}</span>
                            </div>
                        </td>

                        <!-- Export -->
                        <td>
                            <span v-if="item.export"
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-semibold bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/50">
                                {{ item.outgoings[item.outgoings.length - 1]?.outgoing_number }}
                            </span>
                            <span v-else
                                class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400">
                                بلا
                            </span>
                        </td>

                        <!-- Actions -->
                        <td>
                            <div
                                class="flex items-center justify-center gap-1 opacity-70 group-hover:opacity-100 transition-opacity shrink-0">
                                <!-- View -->
                                <button v-if="can('letters.view')"
                                    @click="$router.push({ name: 'letters.show', params: { id: item.id } })"
                                    class="p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:text-slate-200 dark:hover:bg-slate-700 transition-all shrink-0"
                                    v-tooltip.top="'عرض التفاصيل'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>

                                <!-- Edit -->
                                <button v-if="can('letters.update')" @click="$emit('edit', item)"
                                    class="p-2 rounded-lg text-sky-500 hover:text-sky-700 hover:bg-sky-50 dark:text-sky-400 dark:hover:text-sky-200 dark:hover:bg-sky-900/30 transition-all shrink-0"
                                    v-tooltip.top="'تعديل'">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                <!-- Delete -->
                                <button v-if="can('letters.delete')" @click="$emit('delete', item)"
                                    class="p-2 rounded-lg text-red-500 hover:text-red-700 hover:bg-red-50 dark:text-red-400 dark:hover:text-red-200 dark:hover:bg-red-900/30 transition-all shrink-0"
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

        <!-- Empty State -->
        <div v-else class="p-16 text-center">
            <div
                class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 rounded-2xl flex items-center justify-center shadow-inner">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-400 dark:text-indigo-500"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">لا توجد كتابات</h3>
            <p class="text-slate-500 dark:text-slate-400 mb-6">ابدأ بإضافة كتاب جديد للنظام</p>
        </div>
    </div>
</template>

<script setup>
import AppSpinner from '../core/AppSpinner.vue'
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
    lateThreshold: {
        type: Number,
        default: 7
    }
})

defineEmits(['edit', 'delete'])

const getStatusStyle = (status) => {
    if (!status) return {};

    // Mapping titles to colors for rich aesthetics
    const titleColors = {
        'جديد': '#3b82f6',        // Blue
        'قيد المعالجة': '#f59e0b', // Amber
        'تم الرد': '#10b981',      // Emerald
        'مؤرشف': '#64748b',        // Slate
        'ملغي': '#ef4444',         // Red
        'مسودة': '#8b5cf6',        // Violet
        'معلق': '#f97316',         // Orange
        'تحت المراجعة': '#06b6d4', // Cyan
        'مكتمل': '#22c55e',        // Green
        'مرفوض': '#dc2626',        // Red
    };

    // Fallback palette for unknown statuses
    const palette = [
        '#ec4899', // Pink
        '#8b5cf6', // Violet
        '#6366f1', // Indigo
        '#3b82f6', // Blue
        '#0ea5e9', // Sky
        '#06b6d4', // Cyan
        '#14b8a6', // Teal
        '#10b981', // Emerald
        '#22c55e', // Green
        '#84cc16', // Lime
        '#eab308', // Yellow
        '#f59e0b', // Amber
        '#f97316', // Orange
        '#ef4444', // Red
        '#d946ef', // Fuchsia
        '#64748b', // Slate
    ];

    let color = titleColors[status.title] || status.color;

    if (!color) {
        // Generate a consistent color based on status title or ID
        const key = status.title || status.id || 'default';
        let hash = 0;
        for (let i = 0; i < key.length; i++) {
            hash = key.charCodeAt(i) + ((hash << 5) - hash);
        }
        const index = Math.abs(hash) % palette.length;
        color = palette[index];
    }

    return {
        color: color,
        backgroundColor: `${color}15`,
        borderColor: `${color}40`
    };
};
</script>

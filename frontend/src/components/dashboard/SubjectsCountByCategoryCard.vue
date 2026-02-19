<script setup>
import { onMounted } from 'vue'
import { useDashboardStore } from '../../stores/dashboard'

const store = useDashboardStore()

onMounted(() => {
    store.fetchSubjectsCountByCategory()
})

function retry() {
    store.fetchSubjectsCountByCategory()
}
</script>

<template>
    <div
        class="card bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-lg overflow-hidden">
        <!-- Header -->
        <div
            class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-gradient-to-r from-teal-50 to-transparent dark:from-teal-900/10">
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <span class="p-2 bg-teal-100 dark:bg-teal-900/40 rounded-lg text-teal-600 dark:text-teal-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </span>
                    المواضيع حسب التصنيف
                </h3>
                <p class="text-slate-500 dark:text-slate-400 text-sm mt-1 mr-12">
                    عدد المواضيع الفريدة المرتبطة بكل تصنيف
                </p>
            </div>
            <router-link :to="{ name: 'subjects' }"
                class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                عرض المواضيع &larr;
            </router-link>
        </div>

        <div class="p-6">
            <!-- Loading State (Skeleton) -->
            <div v-if="store.subjectsCountLoading" class="space-y-4">
                <div v-for="i in 4" :key="i" class="animate-pulse">
                    <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/30 rounded-xl">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-slate-200 dark:bg-slate-600 rounded-xl"></div>
                            <div class="h-4 w-32 bg-slate-200 dark:bg-slate-600 rounded"></div>
                        </div>
                        <div class="h-6 w-12 bg-slate-200 dark:bg-slate-600 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="store.subjectsCountError"
                class="p-6 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl text-center">
                <div
                    class="w-12 h-12 mx-auto mb-3 bg-red-100 dark:bg-red-900/40 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <p class="font-medium mb-2">{{ store.subjectsCountError }}</p>
                <button @click="retry"
                    class="mt-2 px-4 py-2 text-sm font-bold bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    إعادة المحاولة
                </button>
            </div>

            <!-- Empty State -->
            <div v-else-if="!store.subjectsCountByCategory || store.subjectsCountByCategory.length === 0"
                class="text-center py-12">
                <div
                    class="w-16 h-16 mx-auto mb-4 bg-slate-100 dark:bg-slate-700 text-slate-400 dark:text-slate-500 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-slate-900 dark:text-white">لا توجد بيانات</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm">لم يتم العثور على مواضيع مرتبطة بتصنيفات</p>
            </div>

            <!-- Content -->
            <div v-else class="space-y-3">
                <div v-for="item in store.subjectsCountByCategory" :key="item.category.id"
                    class="group flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-700/30 hover:bg-white dark:hover:bg-slate-700 border border-transparent hover:border-teal-200 dark:hover:border-teal-500/30 rounded-xl transition-all shadow-sm hover:shadow-md">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-teal-100 dark:bg-teal-900/40 flex items-center justify-center text-teal-600 dark:text-teal-400 group-hover:bg-teal-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ item.category.title }}</span>
                    </div>
                    <span
                        class="px-3 py-1 bg-teal-100 dark:bg-teal-900/40 text-teal-700 dark:text-teal-300 text-sm font-bold rounded-full">
                        {{ item.subjects_count }} موضوع
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

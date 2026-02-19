<template>
    <div class="space-y-8 p-6" dir="rtl">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">لوحة التحكم</h1>
                <p class="text-slate-600 dark:text-slate-400 mt-2 text-lg">نظام أرشفة الكتب</p>
                <p class="text-sm font-bold text-slate-500 dark:text-slate-400 mb-1">
                    اعداد / المهندس ياسين رعد حسين
                </p>
                <p class="text-indigo-600 dark:text-indigo-400 mt-1 text-base font-medium">دائرة تدقيق الزراعة والتعمير
                    / هيئة تدقيق التكليفات</p>
            </div>
        </div>

        <!-- Loading State -->
        <div v-if="dashboardStore.loading" class="flex items-center justify-center py-20">
            <div class="animate-spin rounded-full h-16 w-16 border-b-4 border-indigo-600"></div>
        </div>

        <template v-else-if="stats">
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Letters -->
                <div
                    class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl p-8 transition-all hover:shadow-2xl">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-indigo-500/10 rounded-full blur-3xl group-hover:bg-indigo-500/20 transition-all">
                    </div>
                    <div class="flex items-center gap-6 relative">
                        <div
                            class="w-16 h-16 rounded-2xl bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">
                                إجمالي الكتب الواردة </p>
                            <p class="text-4xl font-black text-slate-900 dark:text-white mt-1">{{ stats.total_letters }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Outgoing Letters -->
                <div
                    class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl p-8 transition-all hover:shadow-2xl">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-emerald-500/10 rounded-full blur-3xl group-hover:bg-emerald-500/20 transition-all">
                    </div>
                    <div class="flex items-center gap-6 relative">
                        <div
                            class="w-16 h-16 rounded-2xl bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">
                                الكتب الصادرة</p>
                            <p class="text-4xl font-black text-slate-900 dark:text-white mt-1">{{ stats.outgoing_letters
                            }}</p>
                        </div>
                    </div>
                </div>
                <!-- Transformed Letters (Total - Exported) -->
                <div
                    class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl p-8 transition-all hover:shadow-2xl">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-purple-500/10 rounded-full blur-3xl group-hover:bg-purple-500/20 transition-all">
                    </div>
                    <div class="flex items-center gap-6 relative">
                        <div
                            class="w-16 h-16 rounded-2xl bg-purple-100 dark:bg-purple-900/40 flex items-center justify-center text-purple-600 dark:text-purple-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">
                                الكتب المحولة</p>
                            <p class="text-4xl font-black text-slate-900 dark:text-white mt-1">{{
                                stats.transformed_letters
                            }}</p>
                        </div>
                    </div>
                </div>
                <!-- Other Letters -->
                <div
                    class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl p-8 transition-all hover:shadow-2xl">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-teal-500/10 rounded-full blur-3xl group-hover:bg-teal-500/20 transition-all">
                    </div>
                    <div class="flex items-center gap-6 relative">
                        <div
                            class="w-16 h-16 rounded-2xl bg-teal-100 dark:bg-teal-900/40 flex items-center justify-center text-teal-600 dark:text-teal-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">
                                كتب أخرى</p>
                            <p class="text-4xl font-black text-slate-900 dark:text-white mt-1">{{ stats.other_letters
                            }}</p>
                        </div>
                    </div>
                </div>
                <!-- Imported Letters (Total - Exported) -->
                <div
                    class="group relative overflow-hidden rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xl p-8 transition-all hover:shadow-2xl">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-amber-500/10 rounded-full blur-3xl group-hover:bg-amber-500/20 transition-all">
                    </div>
                    <div class="flex items-center gap-6 relative">
                        <div
                            class="w-16 h-16 rounded-2xl bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium uppercase tracking-wider">
                                إجمالي الكتب المتبقية</p>
                            <p class="text-4xl font-black text-slate-900 dark:text-white mt-1">{{ stats.total_letters -
                                stats.other_letters - stats.outgoing_letters - stats.transformed_letters
                                }}</p>
                        </div>
                    </div>
                </div>


            </div>

            <!-- Letters by Category -->
            <div class="space-y-6">
                <h3 class="text-xl font-bold text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                    إحصائيات التصنيفات
                </h3>

                <div v-if="stats.letters_by_category && stats.letters_by_category.length > 0"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div v-for="item in stats.letters_by_category" :key="item.category"
                        class="group p-6 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                            </div>
                            <span class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ item.total
                            }}</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 dark:text-slate-200 truncate">{{ item.category }}
                        </h4>
                        <div class="mt-4 w-full bg-slate-100 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                            <div class="bg-indigo-600 h-full rounded-full transition-all duration-1000"
                                :style="{ width: (item.total / stats.total_letters * 100) + '%' }"></div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500 text-left">{{ Math.round(item.total / stats.total_letters
                            * 100) }}% من الإجمالي</p>
                    </div>
                </div>

                <div v-else
                    class="bg-white dark:bg-slate-800 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-700 p-12 text-center">
                    <p class="text-slate-500 dark:text-slate-400">لا توجد بيانات متاحة للتصنيفات</p>
                </div>
            </div>

            <!-- Non-Cooperative Letters Stats -->
            <NonCooperativeLetters />

            <!-- Subjects Count by Category Widget -->
            <SubjectsCountByCategoryCard />

            <!-- Late Letters Widget -->
            <LateLettersByCategory />

            <!-- Quick Actions -->
            <div
                class="p-8 bg-linear-to-r from-indigo-600 to-purple-700 rounded-3xl text-white shadow-2xl relative overflow-hidden group">
                <div
                    class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_0%,rgba(255,255,255,0.1),transparent_50%)]">
                </div>
                <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                    <div class="text-center md:text-right">
                        <h3 class="text-2xl font-black mb-2">إدارة الكتب</h3>
                        <p class="text-indigo-100 opacity-90 text-lg">يمكنك تصفح الكتب وإضافة الجديد من خلال قائمة
                            الإدارة</p>
                    </div>
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <router-link :to="{ name: 'letters' }"
                            class="px-8 py-3 bg-white text-indigo-600 rounded-2xl font-bold shadow-lg hover:bg-slate-50 transition-all hover:scale-105 active:scale-95">
                            سجل الكتب
                        </router-link>
                        <router-link :to="{ name: 'categories' }"
                            class="px-8 py-3 bg-indigo-500 text-white border border-indigo-400 rounded-2xl font-bold shadow-lg hover:bg-indigo-400 transition-all hover:scale-105 active:scale-95">
                            التصنيفات
                        </router-link>
                    </div>
                </div>
            </div>
        </template>

        <!-- Error State -->
        <div v-else-if="dashboardStore.error"
            class="card p-12 text-center bg-red-50 dark:bg-red-900/10 border-red-100 dark:border-red-900/30">
            <div
                class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-red-900 dark:text-red-400 mb-2">حدث خطأ</h3>
            <p class="text-red-700 dark:text-red-500">{{ dashboardStore.error }}</p>
            <!-- <button @click="dashboardStore.fetchStatistics()"
                class="mt-6 px-6 py-2 bg-red-600 text-white rounded-xl font-medium hover:bg-red-700 transition-colors">إعادة
                المحاولة</button> -->
        </div>

        <!-- Empty State -->
        <div v-else
            class="card p-16 text-center bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xl">
            <div
                class="w-20 h-20 mx-auto mb-6 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-3">لا توجد إحصائيات متاحة حالياً</h3>
            <p class="text-slate-600 dark:text-slate-400 text-lg">ابدأ بإدخال الكتب لعرض ملخص الإحصائيات</p>
        </div>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue'
import { useDashboardStore } from '../stores/dashboard'
import LateLettersByCategory from '../components/dashboard/LateLettersByCategory.vue'
import NonCooperativeLetters from '../components/dashboard/NonCooperativeLetters.vue'
import SubjectsCountByCategoryCard from '../components/dashboard/SubjectsCountByCategoryCard.vue'

const dashboardStore = useDashboardStore()
const stats = ref(null)

onMounted(() => {
    dashboardStore.fetchStatistics()
        .then((result) => {
            if (result.success) {
                stats.value = result.data
            }
        })
})
</script>
<style scoped>
.card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>

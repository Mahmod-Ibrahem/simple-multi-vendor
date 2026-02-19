<script setup>
import { onMounted } from 'vue'
import { useDashboardStore } from '../../stores/dashboard'
import { overdueDays } from '../../utils/lateLetters'

const store = useDashboardStore()

onMounted(() => {
    store.fetchLateLetters()
})

const getOverdueDays = (date, deadlineDays) => {
    return overdueDays(date, deadlineDays)
}
</script>

<template>
    <div
        class="card bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-lg overflow-hidden">
        <div
            class="p-6 border-b border-slate-100 dark:border-slate-700 flex justify-between items-center bg-gradient-to-r from-red-50 to-transparent dark:from-red-900/10">
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                    <span class="p-2 bg-red-100 dark:bg-red-900/40 rounded-lg text-red-600 dark:text-red-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    الكتب المتأخرة
                </h3>
            </div>
            <router-link :to="{ name: 'letters' }"
                class="text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors">
                عرض الكل &larr;
            </router-link>
        </div>

        <div class="p-6">
            <!-- Loading State -->
            <div v-if="store.lateLettersLoading" class="space-y-4">
                <div v-for="i in 3" :key="i" class="animate-pulse flex gap-4">
                    <div class="h-24 w-full bg-slate-100 dark:bg-slate-700 rounded-2xl"></div>
                </div>
            </div>

            <!-- Error State -->
            <div v-else-if="store.lateLettersError"
                class="p-4 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-xl text-center">
                <p>{{ store.lateLettersError }}</p>
                <button @click="store.fetchLateLetters()"
                    class="mt-2 text-sm underline hover:no-underline font-bold">إعادة المحاولة</button>
            </div>

            <!-- Empty State -->
            <div v-else-if="!store.lateLetters || store.lateLetters.length === 0" class="text-center py-12">
                <div
                    class="w-16 h-16 mx-auto mb-4 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-full flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h4 class="text-lg font-bold text-slate-900 dark:text-white">ممتاز! لا توجد كتابات متأخرة</h4>
                <p class="text-slate-500 dark:text-slate-400 text-sm">جميع الكتب تم الرد عليها في الوقت المحدد</p>
            </div>

            <!-- Content -->
            <div v-else class="space-y-8">
                <div v-for="group in store.lateLetters" :key="group.category" class="space-y-3">
                    <h4
                        class="font-bold text-slate-700 dark:text-slate-300 flex items-center gap-2 border-b border-slate-100 dark:border-slate-700 pb-2">
                        <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        {{ group.category }}
                        <span
                            class="bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400 text-xs px-2 py-0.5 rounded-full font-bold">
                            {{ group.count }}
                        </span>
                    </h4>

                    <div class="grid gap-3">
                        <router-link v-for="letter in group.letters" :key="letter.id"
                            :to="{ name: 'letters.show', params: { id: letter.id } }"
                            class="block group/item bg-slate-50 dark:bg-slate-700/50 hover:bg-white dark:hover:bg-slate-700 border border-transparent hover:border-indigo-200 dark:hover:border-indigo-500/30 p-4 rounded-xl transition-all shadow-sm hover:shadow-md">
                            <div class="flex justify-between items-start gap-4">
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="text-xs font-mono bg-slate-200 dark:bg-slate-600 text-slate-600 dark:text-slate-300 px-2 py-0.5 rounded">
                                            #{{ letter.letter_number }}
                                        </span>
                                        <span class="text-xs text-slate-400">{{ letter.on_going_date }}</span>
                                    </div>
                                    <h5
                                        class="font-bold text-slate-800 dark:text-slate-200 group-hover/item:text-indigo-600 dark:group-hover/item:text-indigo-400 transition-colors line-clamp-1">
                                        {{ letter.subject?.title || 'بدون موضوع' }}
                                    </h5>
                                </div>
                                <div class="text-right shrink-0">
                                    <span
                                        class="block text-xs font-bold text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-lg whitespace-nowrap">
                                        متأخر {{ getOverdueDays(letter.on_going_date, letter.reply_deadline_days) }} يوم
                                    </span>
                                </div>
                            </div>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

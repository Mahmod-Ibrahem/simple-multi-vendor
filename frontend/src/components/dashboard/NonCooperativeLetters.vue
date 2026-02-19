<template>
    <div class="space-y-6">
        <!-- Section Header -->
        <div class="flex items-center gap-3">
            <div class="p-2 bg-orange-100 dark:bg-orange-900/40 rounded-lg text-orange-600 dark:text-orange-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">إحصائيات عدم التعاون</h3>
        </div>

        <!-- Loading State -->
        <div v-if="loading" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div v-for="i in 4" :key="i" class="animate-pulse bg-white dark:bg-slate-800 rounded-3xl p-6 h-32">
                <div class="h-4 bg-slate-200 dark:bg-slate-700 rounded w-1/2 mb-4"></div>
                <div class="h-8 bg-slate-200 dark:bg-slate-700 rounded w-1/3"></div>
            </div>
        </div>

        <!-- Error State -->
        <div v-else-if="error"
            class="p-6 bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/30 rounded-3xl text-center">
            <p class="text-red-600 dark:text-red-400 font-medium">{{ error }}</p>
            <button @click="fetchData"
                class="mt-2 text-sm text-red-700 dark:text-red-300 underline hover:no-underline">إعادة المحاولة</button>
        </div>

        <!-- Content -->
        <div v-else class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <!-- Total Count Card -->
            <div
                class="group relative overflow-hidden bg-linear-to-br from-orange-500 to-red-600 rounded-3xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute -right-6 -top-6 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-500">
                </div>

                <div class="relative z-10">
                    <p class="text-orange-100 font-medium mb-2 text-sm">إجمالي عدم التعاون</p>
                    <h4 class="text-4xl font-black text-white flex items-baseline gap-1">
                        {{ animatedTotal }}
                        <span class="text-lg font-normal opacity-80">كتاب</span>
                    </h4>
                </div>
            </div>

            <!-- Empty State for Categories -->
            <div v-if="categories.length === 0 && totalCount > 0" class="col-span-full py-8 text-center text-slate-500">
                لا توجد تفاصيل للتصنيفات
            </div>

            <!-- Category Cards -->
            <div v-for="(cat, index) in categories" :key="cat.category_id"
                class="group relative bg-white dark:bg-slate-800 rounded-3xl p-6 border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                <div
                    class="absolute top-0 right-0 w-1 h-full bg-orange-500 rounded-r-3xl opacity-0 group-hover:opacity-100 transition-opacity">
                </div>

                <div class="flex items-start justify-between mb-4">
                    <div
                        class="p-2 bg-orange-50 dark:bg-orange-900/20 rounded-xl text-orange-600 dark:text-orange-400 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-bold text-slate-800 dark:text-white">{{ cat.animatedCount || 0 }}</span>
                </div>

                <h5
                    class="font-medium text-slate-600 dark:text-slate-300 line-clamp-1 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                    {{ cat.category_name }}
                </h5>
                <div class="mt-3 w-full bg-slate-100 dark:bg-slate-700 h-1.5 rounded-full overflow-hidden">
                    <div class="h-full bg-orange-500 rounded-full transition-all duration-1000 ease-out"
                        :style="{ width: `${(cat.count / totalCount) * 100}%` }"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue'
import { useDashboardStore } from '../../stores/dashboard'

const store = useDashboardStore()
const animatedTotal = ref(0)
const animatedCategories = ref([])

const loading = computed(() => store.nonCooperativeLoading)
const error = computed(() => store.nonCooperativeError)
const totalCount = computed(() => store.nonCooperativeCount)
const categories = computed(() => {
    return store.nonCooperativeByCategory.map((cat, index) => ({
        ...cat,
        animatedCount: animatedCategories.value[index] || 0
    }))
})

const fetchData = () => {
    store.fetchNonCooperativeStats()
}

// Animation function
const animateValue = (start, end, duration, updateCallback) => {
    if (start === end) return;
    const range = end - start;
    let current = start;
    const increment = end > start ? 1 : -1;
    const stepTime = Math.abs(Math.floor(duration / range));

    // Ensure animation completes reasonably fast for small numbers, but not too slow for large
    const adjustedStepTime = Math.max(stepTime, 10);

    const timer = setInterval(() => {
        current += increment;
        updateCallback(current);
        if (current === end) {
            clearInterval(timer);
        }
    }, adjustedStepTime);
}

// Better easing animation using requestAnimationFrame
const easeOutQuad = (t) => t * (2 - t);

const animateCountUp = (target, duration, callback) => {
    const start = 0;
    const startTime = performance.now();

    const update = (currentTime) => {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        const ease = easeOutQuad(progress);

        const current = Math.floor(start + (target - start) * ease);
        callback(current);

        if (progress < 1) {
            requestAnimationFrame(update);
        } else {
            callback(target); // Ensure final value is exact
        }
    };

    requestAnimationFrame(update);
}

watch(totalCount, (newVal) => {
    animateCountUp(newVal, 1500, (val) => animatedTotal.value = val);
})

watch(() => store.nonCooperativeByCategory, (newVal) => {
    animatedCategories.value = new Array(newVal.length).fill(0);
    newVal.forEach((cat, index) => {
        animateCountUp(cat.count, 1500 + (index * 100), (val) => {
            animatedCategories.value[index] = val;
        });
    });
}, { deep: true })

onMounted(() => {
    fetchData();
})
</script>

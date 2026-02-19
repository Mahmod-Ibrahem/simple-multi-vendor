<template>
    <div class="bg-white dark:bg-dark-800 rounded-xl shadow-sm border border-gray-200 dark:border-dark-700 p-6">
        <div class="flex items-start justify-between mb-6">
            <div class="flex gap-3">
                <div class="p-3 rounded-lg bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">تنبيهات التأخير</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        تحديد عدد الأيام التي يعتبر بعدها الكتاب متأخراً (Late Letters)
                    </p>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-4 max-w-md">
            <!-- Late Letter Days -->
            <div class="flex flex-col gap-2">
                <label for="late_days" class="text-sm font-medium text-gray-700 dark:text-gray-300">
                    عدد الأيام المسموح بها
                </label>
                <div class="flex gap-3 items-center">
                    <InputText v-model="lateDays" inputId="late_days" class="w-full" placeholder="7">
                    </InputText>
                    <span class="text-gray-500 dark:text-gray-400 whitespace-nowrap">يوم</span>
                </div>
                <small class="text-gray-500">
                    سيظهر تنبيه "متأخر" على الكتب التي لم يتم الرد عليها بعد هذه المدة.
                </small>
            </div>

            <div class="flex justify-end pt-2">
                <Button label="حفظ التغييرات" icon="pi pi-check" :loading="loading" @click="saveSettings" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue'
import { useSettingStore } from '../../stores/settingStore'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'

const store = useSettingStore()
const lateDays = ref('7')
const loading = ref(false)


function saveSettings() {
    loading.value = true
    store.updateSetting(settings)
        .then(() => {
            loading.value = false
        })
        .catch(() => {
            loading.value = false
        })
}
</script>

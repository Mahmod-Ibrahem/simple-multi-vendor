<template>
    <Menu as="div" class="relative">
        <div class="flex items-center justify-center">
            <MenuButton
                class="relative p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-full transition-all duration-200 focus:outline-none">
                <span v-if="unreadCount > 0"
                    class="absolute top-1 right-1 h-3 w-3 bg-red-600 rounded-full border-2 border-white animate-pulse"></span>
                <BellIcon class="h-6 w-6" aria-hidden="true" />
            </MenuButton>
        </div>

        <transition enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95 translate-y-2"
            enter-to-class="transform opacity-100 scale-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="transform opacity-100 scale-100 translate-y-0"
            leave-to-class="transform opacity-0 scale-95 translate-y-2">
            <MenuItems
                class="absolute left-0 w-80 md:w-96 z-50 mt-3 origin-top-left bg-white dark:bg-slate-800 rounded-xl shadow-xl ring-1 ring-black/5 focus:outline-none overflow-hidden divide-y divide-slate-100 dark:divide-slate-700/50">
                <div
                    class="px-4 py-3 bg-slate-50/80 dark:bg-slate-800/80 backdrop-blur-sm border-b border-slate-100 dark:border-slate-700 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-slate-200">التنبيهات (كتابات متأخرة)</h3>
                    <span v-if="unreadCount > 0"
                        class="text-xs font-medium text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400 px-2 py-0.5 rounded-full">
                        {{ unreadCount }} جديد
                    </span>
                </div>

                <!-- Scrollable Wrapper -->
                <div class="max-h-112 overflow-y-auto custom-scrollbar">
                    <div v-if="store.loading" class="p-4 text-center">
                        <i class="pi pi-spin pi-spinner text-slate-400"></i>
                    </div>

                    <MenuItem v-else-if="store.items.length > 0" v-for="notification in store.items"
                        :key="notification.id" v-slot="{ active }">
                    <RouterLink :to="{ name: 'letters.show', params: { id: notification.id } }" :class="[
                        active ? 'bg-slate-50 dark:bg-slate-700/50' : notification.read_at ? 'bg-white dark:bg-slate-800' : 'bg-blue-50/40 dark:bg-slate-700/30',
                        'block px-4 py-3 transition-colors duration-200 border-b border-slate-50 dark:border-slate-700/50 last:border-0'
                    ]">
                        <div class="flex gap-3" @click="store.markAsRead(notification.notification_id)">
                            <div class="shrink-0 mt-1">
                                <div
                                    class="h-8 w-8 rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0 text-right">
                                <p class="text-sm font-medium text-slate-900 dark:text-slate-100 truncate">
                                    {{ notification.title }}
                                </p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-xs px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400">
                                        #{{ notification.letter_number }}
                                    </span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400 truncate">
                                        {{ notification.category }}
                                    </span>
                                </div>
                                <p class="text-xs text-red-500 mt-1.5 flex items-center justify-end gap-1">
                                    <span>متأخر منذ {{ notification.overdue_days }} يوم (المهلة: {{
                                        notification.deadline_days }} أيام)</span>
                                </p>
                            </div>
                        </div>
                    </RouterLink>
                    </MenuItem>

                    <div v-else class="px-4 py-8 text-center text-slate-500 dark:text-slate-400">
                        <div class="mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8 mx-auto text-slate-300 dark:text-slate-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <p class="text-sm">لا توجد تنبيهات جديدة</p>
                    </div>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { onMounted, onUnmounted, computed } from 'vue';
import { RouterLink } from 'vue-router';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { BellIcon } from '@heroicons/vue/24/outline';
import { useNotificationStore } from '../../stores/notifications';

const store = useNotificationStore();

const unreadCount = computed(() => store.items.filter(n => !n.read_at).length);

onMounted(() => {
    store.fetchAll();
    // Optional: Start polling
    store.startPolling(60000); // Check every minute
});

onUnmounted(() => {
    store.stopPolling();
});
</script>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 20px;
}

.dark .custom-scrollbar::-webkit-scrollbar-thumb {
    background-color: #475569;
}
</style>

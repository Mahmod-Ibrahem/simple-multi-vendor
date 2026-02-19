<template>
    <main
        class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 antialiased relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8"
        dir="rtl">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-30 pointer-events-none">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_50%,rgba(120,119,198,0.1),transparent_50%)]">
            </div>
        </div>

        <div class="max-w-md w-full relative">
            <div
                class="group relative overflow-hidden rounded-3xl bg-white/5 backdrop-blur-xl border border-white/10 shadow-2xl shadow-black/40 p-8">
                <!-- Top Gradient Accent -->
                <div
                    class="absolute top-0 right-0 w-full h-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 transition-all duration-500 group-hover:h-1.5">
                </div>

                <div class="mb-10 text-center">
                    <h1
                        class="text-3xl font-bold bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">
                        تسجيل الدخول
                    </h1>
                    <p class="mt-2 text-slate-400">مرحباً بك مجدداً! يرجى إدخال بياناتك المعتمدة.</p>
                </div>

                <form class="space-y-6" @submit.prevent="login">
                    <!-- Global Error Message -->
                    <Transition name="fade">
                        <div v-if="errorMsg"
                            class="flex items-center justify-between py-3 px-4 bg-red-500/10 border border-red-500/50 text-red-200 rounded-2xl animate-shake"
                            role="alert">
                            <div class="flex items-center">
                                <ExclamationTriangleIcon class="h-5 w-5 ml-2 shrink-0 text-red-400" />
                                <span class="text-sm font-medium">{{ errorMsg }}</span>
                            </div>
                            <button @click="errorMsg = ''" type="button"
                                class="mr-auto p-1 rounded-full hover:bg-red-500/20 transition-colors"
                                aria-label="Dismiss error">
                                <XMarkIcon class="h-4 w-4" />
                            </button>
                        </div>
                    </Transition>

                    <div class="space-y-5">
                        <!-- Email Field -->
                        <div>
                            <label for="email-address" class="block text-sm font-medium text-slate-300 mb-2">
                                البريد الإلكتروني
                            </label>
                            <div class="relative group/input">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <EnvelopeIcon
                                        class="h-5 w-5 text-slate-500 group-focus-within/input:text-indigo-400 transition-colors"
                                        aria-hidden="true" />
                                </div>
                                <input id="email-address" name="email" type="email" autocomplete="email" required
                                    v-model="form.email" @input="clearValidationError('email')" :class="[
                                        'block w-full pr-11 pl-4 py-3.5 bg-slate-800/50 border rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300',
                                        errors.email ? 'border-red-500/50 bg-red-500/5' : 'border-slate-700 hover:border-slate-600'
                                    ]" placeholder="example@mail.com" dir="ltr" :aria-invalid="!!errors.email"
                                    aria-describedby="email-error" />
                            </div>
                            <p v-if="errors.email" class="mt-1.5 text-xs text-red-400 font-medium px-1"
                                id="email-error">
                                {{ errors.email[0] }}
                            </p>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label for="password" class="block text-sm font-medium text-slate-300">
                                    كلمة المرور
                                </label>
                            </div>
                            <div class="relative group/input">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <LockClosedIcon
                                        class="h-5 w-5 text-slate-500 group-focus-within/input:text-indigo-400 transition-colors"
                                        aria-hidden="true" />
                                </div>
                                <input :id="passwordId" name="password" :type="showPassword ? 'text' : 'password'"
                                    autocomplete="current-password" required v-model="form.password"
                                    @input="clearValidationError('password')" :class="[
                                        'block w-full pr-11 pl-12 py-3.5 bg-slate-800/50 border rounded-2xl text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-300',
                                        errors.password ? 'border-red-500/50 bg-red-500/5' : 'border-slate-700 hover:border-slate-600'
                                    ]" placeholder="••••••••" dir="ltr" :aria-invalid="!!errors.password"
                                    aria-describedby="password-error" />
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none transition-colors"
                                    :aria-label="showPassword ? 'إخفاء كلمة المرور' : 'إظهار كلمة المرور'">
                                    <EyeIcon v-if="!showPassword" class="h-5 w-5" aria-hidden="true" />
                                    <EyeSlashIcon v-else class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                            <p v-if="errors.password" class="mt-1.5 text-xs text-red-400 font-medium px-1"
                                id="password-error">
                                {{ errors.password[0] }}
                            </p>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" v-model="form.remember"
                            class="h-4.5 w-4.5 text-indigo-500 focus:ring-indigo-500/50 bg-slate-800 border-slate-700 rounded-lg cursor-pointer transition-colors" />
                        <label for="remember-me"
                            class="mr-2.5 block text-sm text-slate-400 hover:text-slate-300 cursor-pointer select-none transition-colors">
                            البقاء متصلاً لمدة 30 يوماً
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" :disabled="loading"
                            class="group/btn relative w-full flex justify-center py-4 px-4 text-sm font-bold rounded-2xl text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:ring-offset-2 focus:ring-offset-slate-900 transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed shadow-xl shadow-indigo-500/20 hover:shadow-indigo-500/40 active:scale-[0.98]">
                            <span v-if="loading" class="ml-3">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                            </span>
                            {{ loading ? 'جاري التحقق...' : 'دخول' }}
                            <ArrowRightIcon v-if="!loading"
                                class="mr-2 h-4 w-4 transform group-hover/btn:-translate-x-1 transition-transform rotate-180" />
                        </button>
                    </div>
                </form>

                <!-- Optional: Footer links -->
                <div class="mt-8 pt-6 border-t border-white/5 text-center">
                    <p class="text-sm text-slate-500">
                        وصول آمن ومضمون للنظام
                    </p>
                </div>
            </div>

            <!-- Security Badge -->
            <div class="mt-8 flex items-center justify-center gap-2 text-slate-500 text-xs tracking-wider uppercase">
                <LockClosedIcon class="w-3.5 h-3.5" />
                <span>محمي بتشفير بيانات متقدم</span>
            </div>
        </div>
    </main>
</template>

<script setup>
import {
    LockClosedIcon,
    EnvelopeIcon,
    EyeIcon,
    EyeSlashIcon,
    ExclamationTriangleIcon,
    XMarkIcon,
    ArrowRightIcon
} from '@heroicons/vue/24/outline'
import { ref, reactive } from "vue"
import router from '../router';
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();

const form = reactive({
    email: '',
    password: '',
    remember: false
})

const errors = ref({})
const loading = ref(false)
const errorMsg = ref("")
const showPassword = ref(false)
const passwordId = `password-${Math.random().toString(36).slice(2, 9)}`

function clearValidationError(field) {
    if (errors.value[field]) {
        delete errors.value[field]
    }
}

function login() {
    loading.value = true
    errorMsg.value = ""
    errors.value = {}

    authStore.login(form)
        .then((result) => {
            if (result.success) {
                router.push({ name: 'dashboard' })
            } else {
                errorMsg.value = result.message || "خطأ في البريد الإلكتروني أو كلمة المرور";
            }
        })
        .catch((err) => {
            errorMsg.value = err.response?.data?.message || "حدث خطأ غير متوقع. يرجى المحاولة مرة أخرى.";
            if (err.response?.data?.errors) {
                errors.value = err.response.data.errors
            }
        })
        .finally(() => {
            loading.value = false
        })
}
</script>

<style scoped>
.animate-shake {
    animation: shake 0.5s cubic-bezier(.36, .07, .19, .97) both;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

@keyframes shake {

    10%,
    90% {
        transform: translate3d(-1px, 0, 0);
    }

    20%,
    80% {
        transform: translate3d(2px, 0, 0);
    }

    30%,
    50%,
    70% {
        transform: translate3d(-4px, 0, 0);
    }

    40%,
    60% {
        transform: translate3d(4px, 0, 0);
    }
}
</style>

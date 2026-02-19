import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../services/api'

export const useAuthStore = defineStore('auth', () => {
    //states
    const user = ref(JSON.parse(localStorage.getItem('user')) || null)
    const token = ref(localStorage.getItem('token') || null)
    const loading = ref(false)
    const error = ref(null)

    //computed
    const isAuthenticated = computed(() => !!token.value)
    const isAdmin = computed(() => user.value?.role === 'مدير النظام' || user.value?.role === 'مشرف')
    const isClient = computed(() => user.value?.role === 'عميل')
    const permissions = computed(() => user.value?.permissions || [])

    //actions
    function login(credentials) {
        loading.value = true
        error.value = null
    
        return api.post('/login', credentials)
      .then((response) => {
        token.value = response.data.data.token
        user.value = response.data.data.user
        
        localStorage.setItem('token', token.value)
        localStorage.setItem('user', JSON.stringify(user.value))
        
        loading.value = false
        return { success: true }
      })
      .catch((err) => {
        error.value = err.response?.data?.message || 'فشل تسجيل الدخول'
        loading.value = false
        return { success: false, message: error.value }
      })
    }

    function logout() {
        loading.value = true
    
        return api.post('/logout')
      .then(() => {
        clearAuth()
        loading.value = false
      })
      .catch(() => {
        // Ignore logout errors, clear local state anyway
        clearAuth()
        loading.value = false
      })
    }

    function clearAuth() {
        token.value = null
        user.value = null
        localStorage.removeItem('token')
        localStorage.removeItem('user')
    }

    function fetchUser() {
        if (!token.value) return Promise.resolve()

        return api.get('/me')
      .then((response) => {
        user.value = response.data.data
        localStorage.setItem('user', JSON.stringify(user.value))
      })
      .catch(() => {
        // Token invalid, clear auth
        clearAuth()
      })
    }

    return {
    user,
    token,
    loading,
    error,
    isAuthenticated,
    isAdmin,
    isClient,
    permissions,
    login,
    logout,
    fetchUser,
    clearAuth
    }
})

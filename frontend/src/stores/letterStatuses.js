import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../services/api'

export const useLetterStatusStore = defineStore('letterStatuses', () => {
    // State
    const items = ref([])
    const currentItem = ref(null)
    const loading = ref(false)
    const error = ref(null)
    const pagination = ref({
        currentPage: 1,
        lastPage: 1,
        perPage: 15,
        total: 0
    })

    // Getters
    const isEmpty = computed(() => items.value.length === 0)
    const activeStatuses = computed(() => items.value.filter(s => s.is_active))

    // Actions
    function fetchAll(page = 1) {
        loading.value = true
        error.value = null

        return api.get('/letter-statuses', { params: { page, per_page: pagination.value.perPage } })
            .then((response) => {
                items.value = response.data.data
                if (response.data.meta) {
                    pagination.value = {
                        currentPage: response.data.meta.current_page,
                        lastPage: response.data.meta.last_page,
                        perPage: response.data.meta.per_page,
                        total: response.data.meta.total
                    }
                }
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في جلب حالات الكتب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function fetchAllForDropdown() {
        loading.value = true
        error.value = null

        return api.get('/letter-statuses', { params: { paginate: false } })
            .then((response) => {
                const data = response.data.data || response.data
                items.value = data
                return data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في جلب حالات الكتب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function fetchOne(id) {
        loading.value = true
        error.value = null

        return api.get(`/letter-statuses/${id}`)
            .then((response) => {
                currentItem.value = response.data.data || response.data
                return currentItem.value
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في جلب الحالة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function create(data) {
        loading.value = true
        error.value = null

        return api.post('/letter-statuses', data)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في إنشاء الحالة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function update(id, data) {
        loading.value = true
        error.value = null

        return api.put(`/letter-statuses/${id}`, data)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في تحديث الحالة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function remove(id) {
        loading.value = true
        error.value = null

        return api.delete(`/letter-statuses/${id}`)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في حذف الحالة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function resetCurrent() {
        currentItem.value = null
    }

    return {
        items,
        currentItem,
        loading,
        error,
        pagination,
        isEmpty,
        activeStatuses,
        fetchAll,
        fetchAllForDropdown,
        fetchOne,
        create,
        update,
        remove,
        resetCurrent
    }
})

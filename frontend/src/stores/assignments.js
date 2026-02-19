import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../services/api'

export const useAssignmentStore = defineStore('assignments', () => {
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

    // Actions
    function fetchAll(page = 1) {
        loading.value = true
        error.value = null

        return api.get('/assignments', { params: { page, per_page: pagination.value.perPage } })
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
                error.value = err.response?.data?.message || 'فشل في جلب الجهات المكلفة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function fetchAllForDropdown() {
        return api.get('/assignments', { params: { paginate: false } })
            .then((response) => {
                return response.data.data
            })
            .catch((err) => {
                console.error('Failed to fetch assignments for dropdown:', err)
                return []
            })
    }

    function fetchOne(id) {
        loading.value = true
        error.value = null

        return api.get(`/assignments/${id}`)
            .then((response) => {
                currentItem.value = response.data.data || response.data
                return currentItem.value
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في جلب الجهة المكلفة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function create(data) {
        loading.value = true
        error.value = null

        return api.post('/assignments', data)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في إنشاء الجهة المكلفة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function update(id, data) {
        loading.value = true
        error.value = null

        return api.put(`/assignments/${id}`, data)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في تحديث الجهة المكلفة'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function remove(id) {
        loading.value = true
        error.value = null

        return api.delete(`/assignments/${id}`)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في حذف الجهة المكلفة'
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
        fetchAll,
        fetchAllForDropdown,
        fetchOne,
        create,
        update,
        remove,
        resetCurrent
    }
})

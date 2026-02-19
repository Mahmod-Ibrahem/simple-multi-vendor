import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '../services/api'

export const useLetterStore = defineStore('letters', () => {
    // State
    const items = ref([])
    const currentItem = ref(null)
    const loading = ref(false)
    const error = ref(null)
    const pagination = ref({
        currentPage: 1,
        lastPage: 1,
        perPage: 10,
        total: 0
    })
    const filters = ref({
        category_id: null,
        subject_id: null,
        assignment_id: null,
        letter_status_id: null,
        letter_number: null,
        date_from: null,
        date_to: null,
        outgoing_number: null,
        outgoing_date_from: null,
        outgoing_date_to: null,
        export: null
    })

    // Getters
    const isEmpty = computed(() => items.value.length === 0)

    // Helper to build query params
    function buildParams(page) {
        const params = { page, per_page: pagination.value.perPage }
        
        Object.keys(filters.value).forEach(key => {
            const val = filters.value[key]
            if (val !== null && val !== '' && val !== undefined) {
                params[key] = val
            }
        })
        
        return params
    }

    // Actions
    function fetchAll(page = 1) {
        loading.value = true
        error.value = null

        return api.get('/letters', { params: buildParams(page) })
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
                error.value = err.response?.data?.message || 'فشل في جلب الكتب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function fetchOne(id) {
        loading.value = true
        error.value = null

        return api.get(`/letters/${id}`)
            .then((response) => {
                currentItem.value = response.data.data || response.data
                return currentItem.value
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في جلب الكتاب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function create(data) {
        loading.value = true
        error.value = null

        return api.post('/letters', data)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في إنشاء الكتاب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function update(id, data) {
        loading.value = true
        error.value = null
        console.log(data)
        let request;
        if (data instanceof FormData) {
            data.append('_method', 'PUT');
            request = api.post(`/letters/${id}`, data);
        } else {
            request = api.put(`/letters/${id}`, data);
        }

        return request
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في تحديث الكتاب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function remove(id) {
        loading.value = true
        error.value = null

        return api.delete(`/letters/${id}`)
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في حذف الكتاب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    function setFilter(key, value) {
        filters.value[key] = value
    }

    function resetFilters() {
        filters.value = {
            category_id: null,
            subject_id: null,
            assignment_id: null,
            letter_status_id: null,
            letter_number: null,
            date_from: null,
            date_to: null,
            outgoing_number: null,
            outgoing_date_from: null,
            outgoing_date_to: null,
            export: null
        }
    }

    function resetCurrent() {
        currentItem.value = null
    }

    // FormData-based create for file uploads
    function createWithFormData(formData) {
        loading.value = true
        error.value = null

        return api.post('/letters', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        })
            .then((response) => {
                return response.data
            })
            .catch((err) => {
                error.value = err.response?.data?.message || 'فشل في إنشاء الكتاب'
                throw err
            })
            .finally(() => {
                loading.value = false
            })
    }

    // FormData-based update for file uploads (uses POST with _method: PUT)
    async function updateWithFormData(id, formData) {
        loading.value = true
        error.value = null
        try {
            const response = await api.post(`/letters/${id}`, formData, {
                headers: { 'Content-Type': 'multipart/form-data' }
            })
            // Update item in list
            const index = items.value.findIndex(i => i.id === id)
            if (index !== -1) {
                items.value[index] = response.data.data
            }
            return response.data
        } catch (err) {
            console.error('Error updating letter:', err)
            error.value = err.response?.data?.message || 'Failed to update letter'
            throw err
        } finally {
            loading.value = false
        }
    }

    async function exportLetters(filters) {
        try {
            const response = await api.get('/letters/export', {
                params: filters,
                responseType: 'blob'
            })
            return response.data
        } catch (err) {
            console.error('Error exporting letters:', err)
            throw err
        }
    }

    return {
        items,
        currentItem,
        loading,
        error,
        pagination,
        filters,
        isEmpty,
        fetchAll,
        fetchOne,
        create,
        update,
        remove,
        setFilter,
        resetFilters,
        resetCurrent,
        createWithFormData,
        updateWithFormData,
        exportLetters
    }
})

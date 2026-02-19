import { defineStore } from 'pinia'
import axios from '../services/api'

export const useEmployeeStore = defineStore('employees', {
  state: () => ({
    items: [],
    meta: {
      currentPage: 1,
      lastPage: 1,
      perPage: 15,
      total: 0
    },
    loading: false,
    error: null,
    current: null
  }),

  actions: {
    /**
     * Fetch all employees with pagination
     */
    fetchEmployees(params = {}) {
      this.loading = true
      this.error = null

      const queryParams = {
        page: params.page || 1,
        per_page: params.per_page || 15,
        paginate: true
      }

      return axios.get('/employees', { params: queryParams })
        .then((response) => {
          if (response.data.success) {
            const data = response.data.data
            this.items = data.data || []
            this.meta = {
              currentPage: data.current_page || 1,
              lastPage: data.last_page || 1,
              perPage: data.per_page || 15,
              total: data.total || 0
            }
            return { success: true }
          }
          return { success: false }
        })
        .catch((error) => {
          console.error('Error fetching employees:', error)
          this.error = error.response?.data?.message || 'حدث خطأ أثناء تحميل الموظفين'
          return { success: false, error: this.error }
        })
        .finally(() => {
          this.loading = false
        })
    },

    /**
     * Fetch all employees for dropdown (no pagination)
     */
    fetchAllForDropdown() {
      return axios.get('/employees', { params: { paginate: false } })
        .then((response) => {
          if (response.data.success) {
            return response.data.data || []
          }
          return []
        })
        .catch((error) => {
          console.error('Error fetching employees for dropdown:', error)
          return []
        })
    },

    /**
     * Fetch single employee by ID
     */
    fetchEmployee(id) {
      this.loading = true
      this.error = null

      return axios.get(`/employees/${id}`)
        .then((response) => {
          if (response.data.success) {
            this.current = response.data.data
            return { success: true, data: response.data.data }
          }
          return { success: false }
        })
        .catch((error) => {
          console.error('Error fetching employee:', error)
          this.error = error.response?.data?.message || 'حدث خطأ أثناء تحميل بيانات الموظف'
          return { success: false, error: this.error }
        })
        .finally(() => {
          this.loading = false
        })
    },

    /**
     * Create new employee
     */
    createEmployee(payload) {
      return axios.post('/employees', payload)
        .then((response) => {
          if (response.data.success) {
            return { success: true, data: response.data.data }
          }
          return { success: false, message: response.data.message }
        })
        .catch((error) => {
          console.error('Error creating employee:', error)
          const errorData = error.response?.data
          return { 
            success: false, 
            errors: errorData?.errors || {},
            message: errorData?.message || 'حدث خطأ أثناء إنشاء الموظف'
          }
        })
    },

    /**
     * Update existing employee
     */
    updateEmployee(id, payload) {
      return axios.put(`/employees/${id}`, payload)
        .then((response) => {
          if (response.data.success) {
            return { success: true, data: response.data.data }
          }
          return { success: false, message: response.data.message }
        })
        .catch((error) => {
          console.error('Error updating employee:', error)
          const errorData = error.response?.data
          return { 
            success: false, 
            errors: errorData?.errors || {},
            message: errorData?.message || 'حدث خطأ أثناء تحديث الموظف'
          }
        })
    },

    /**
     * Delete employee
     */
    deleteEmployee(id) {
      return axios.delete(`/employees/${id}`)
        .then((response) => {
          if (response.data.success) {
            this.items = this.items.filter(item => item.id !== id)
            return { success: true }
          }
          return { success: false, message: response.data.message }
        })
        .catch((error) => {
          console.error('Error deleting employee:', error)
          return { 
            success: false, 
            message: error.response?.data?.message || 'حدث خطأ أثناء حذف الموظف'
          }
        })
    }
  }
})

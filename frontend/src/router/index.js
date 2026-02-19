import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const routes = [
  {
    path: '/login',
    name: 'login',
    component: () => import('../pages/Login.vue'),
    meta: { guest: true }
  },
  {
    path: '/',
    component: () => import('../layouts/AdminLayout.vue'),
    meta: { requiresAuth: true },
    children: [
      {
        path: '',
        name: 'dashboard',
        component: () => import('../pages/Dashboard.vue'),
        meta: { requiresAdmin: true }
      },
      // User Management Routes (Admin Only)
      {
        path: 'users',
        name: 'users',
        component: () => import('../pages/users/List.vue'),
        meta: { requiresAdmin: true }
      },
      {
        path: 'users/create',
        name: 'users.create',
        component: () => import('../pages/users/Form.vue'),
        meta: { requiresAdmin: true }
      },
      {
        path: 'users/:id/edit',
        name: 'users.edit',
        component: () => import('../pages/users/Form.vue'),
        meta: { requiresAdmin: true }
      },
      // Letters Module Routes
      {
        path: 'letters',
        name: 'letters',
        component: () => import('../pages/letters/LettersPage.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'letters/:id',
        name: 'letters.show',
        component: () => import('../pages/letters/LetterDetailPage.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'categories',
        name: 'categories',
        component: () => import('../pages/letters/CategoriesPage.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'subjects',
        name: 'subjects',
        component: () => import('../pages/letters/SubjectsPage.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'assignments',
        name: 'assignments',
        component: () => import('../pages/letters/AssignmentsPage.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'letter-statuses',
        name: 'letter-statuses',
        component: () => import('../pages/letters/LetterStatusesPage.vue'),
        meta: { requiresAuth: true }
      },
      {
        path: 'employees',
        name: 'employees',
        component: () => import('../pages/EmployeesPage.vue'),
        meta: { requiresAuth: true }
      },
      // Settings
      {
        path: 'settings',
        name: 'settings',
        component: () => import('../pages/Setting/Settings.vue'),
        meta: { requiresAdmin: true, title: 'الإعدادات' }
      },
      {
        path: 'settings/create',
        name: 'settings.create',
        component: () => import('../pages/Setting/SettingForm.vue'),
        meta: { requiresAdmin: true, title: 'إضافة إعداد' }
      },
      {
        path: 'settings/:id/edit',
        name: 'settings.edit',
        component: () => import('../pages/Setting/SettingForm.vue'),
        meta: { requiresAdmin: true, title: 'تعديل إعداد' }
      },
      // RBAC Routes
      {
        path: 'roles',
        name: 'roles',
        component: () => import('../pages/RBAC/Roles.vue'),
        meta: { requiresAdmin: true, title: 'إدارة الأدوار' }
      },
      {
        path: 'permissions',
        name: 'permissions',
        component: () => import('../pages/RBAC/Permissions.vue'),
        meta: { requiresAdmin: true, title: 'إدارة الصلاحيات' }
      },
    ]
  },
  {
    path: '/:pathMatch(.*)*',
    redirect: '/'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Navigation guards
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore()
  
  // Wait if store is still loading (optional, but good for refresh)
  const isAuthenticated = authStore.isAuthenticated
  const isAdmin = authStore.isAdmin

  // Check authentication
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'login' })
  } 
  // Check guest access
  else if (to.meta.guest && isAuthenticated) {
    next({ name: 'dashboard' })
  }
  // Check admin privileges
  else if (to.meta.requiresAdmin && !isAdmin) {
    // Redirect to letters or something else if not admin
    next({ name: 'letters' })
  }
  else {
    next()
  }
})

export default router

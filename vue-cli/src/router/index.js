import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'Login',
    meta: {
      guest: true
    },
    component: () => import(/* webpackChunkName: "about" */ '../views/Login.vue')
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import(/* webpackChunkName: "about" */ '../views/Register.vue')
  },
  {
    path: '/home',
    name: 'Home',
    meta: {
      requiresAuth: true,
    },
    component: () => import(/* webpackChunkName: "about" */ '../views/Home.vue')
  },
  {
    path: '/user/create',
    name: 'Create',
    meta: {
      requiresAuth: true,
    },
    component: () => import(/* webpackChunkName: "about" */ '../views/accounts/Create.vue')
  },
  {
    path: '/user/:id',
    name: 'Detail',
    meta: {
      requiresAuth: true,
    },
    component: () => import(/* webpackChunkName: "about" */ '../views/accounts/Detail.vue')
  },
  {
    path: '/user/:id/edit',
    name: 'Edit',
    meta: {
      requiresAuth: true,
    },
    component: () => import(/* webpackChunkName: "about" */ '../views/accounts/Edit.vue')
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  if(to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters['auth/authenticated']) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.guest)) {
    if (store.getters['auth/authenticated']) {
      next("/home")
      return
    }
    next()
  } else {
    next()
  }
});

export default router

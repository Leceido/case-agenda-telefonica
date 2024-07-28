import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/user/login',
      name: 'login',
      component: () => import('../views/LoginView.vue'),
      meta: {
        requiresNoAuth: true
      }
    },
    {
      path: '/user/register',
      name: 'register',
      component: () => import('../views/RegisterView.vue'),
      meta: {
        requiresNoAuth: true
      }
    }
    /*{
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/AboutView.vue')
    }*/
  ]
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  const requiresNoAuth = to.matched.some(record => record.meta.requiresNoAuth);
  if (requiresAuth && !token) {
    next('/user/login')
  } else if (requiresNoAuth && token) {
    next('/')
  } else {
    next()
  }

});

export default router

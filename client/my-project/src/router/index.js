import Vue from 'vue'
import Router from 'vue-router'
import Home from '@/components/Home'
import Cars from '@/components/Cars'
import Register from '@/components/Register'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/cars/',
      name: 'Cars',
      component: Cars
    },
    {
      path: '/register/',
      name: 'Register',
      component: Register
    }
  ]
})

import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: () => import('@/views/Home'),
      children: [
        {
          path: '',
          name: 'home',
          component: () => import('@/views/HomeGlobal')
        },
        {
          path: 'my-feed',
          name: 'home-my-feed',
          component: () => import('@/views/HomeMyFeed')
        },
        {
          path: 'author/:author',
          name: 'home-author',
          component: () => import('@/views/HomeAuthor')
        }
      ]
    },
    {
      name: 'login',
      path: '/login',
      component: () => import('@/views/Login')
    },
    {
      name: 'register',
      path: '/register',
      component: () => import('@/views/Register')
    },
    {
      name: 'settings',
      path: '/settings',
      component: () => import('@/views/Settings')
    },
    // Handle child routes with a default, by giving the name to the
    // child.
    // SO: https://github.com/vuejs/vue-router/issues/777
    {
      path: '/@:username',
      component: () => import('@/views/Profile'),
      children: [
        {
          path: '',
          name: 'profile',
          component: () => import('@/views/ProfileBooks')
        },
        {
          name: 'profile-favorites',
          path: 'favorites',
          component: () => import('@/views/ProfileFavorited')
        }
      ]
    },
    {
      name: 'book',
      path: '/books/:slug',
      component: () => import('@/views/Book'),
      props: true
    },
    {
      name: 'book-edit',
      path: '/editor/:slug?',
      props: true,
      component: () => import('@/views/BookEdit')
    }
  ]
})

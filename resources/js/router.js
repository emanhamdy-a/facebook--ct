import Vue from 'vue';
import VueRouter from 'vue-router';
import Start from './views/Start';
import Newsfeed from './views/Newsfeed';
import userShow from './views/Users/Show';
Vue.use(VueRouter);

export default new VueRouter({
  mode: 'history',

  routes: [
    {
      path: '/', name: 'home', component: Newsfeed,
      meta:{title:'News feed'}
    },
    {
      path: '/users/:userId', name: 'user.show', component: userShow,
      meta:{title:'Profile'}
    },
  ]
});

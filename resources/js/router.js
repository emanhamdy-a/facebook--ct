import Vue from 'vue';
import VueRouter from 'vue-router';
import Start from './views/Start';
import Newsfeed from './views/Newsfeed';
import userShow from './views/Users/Show';
import userFriends from './views/Users/Friends';
import userFriendRequests from './views/Users/FriendRequests';
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
    {
      path: '/friends/:friendId'
      , name: 'user.friends'
      , component: userFriends,
      meta:{title:'Friends'}
    },
    {
      path: '/friend-requests/:friendId'
      , name: 'user.FriendRequests'
      , component: userFriendRequests,
      meta:{title:'Friend Requests'}
    },
  ]
});

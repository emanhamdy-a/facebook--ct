// rootGetters

const state={
  user:null,
  userStatus:null,
};

const getters={
  user:state=>{
    return state.user;
  },
  status:state=>{
    return {
     user:state.userStatus,
     posts:state.postsStatus,
    }
  },
  friendShip:state=>{
    return state.user.data.attributes.friendship;
  },
  friendButtonText:(state,getters,rootState)=>{
    if(rootState.User.user){

      if (rootState.User.user.data.user_id === state.user.data.user_id) {
        return '';
      } else if (getters.friendShip === null) {
        // alert('Add Friend');
        return 'Add Friend';
      } else if (getters.friendShip.data.attributes.confirmed_at === null
        && getters.friendShip.data.attributes.friend_id !== rootState.User.user.data.user_id) {
          return 'Cancel Friend Request';
      } else if (getters.friendShip.data.attributes.confirmed_at !== null) {
          return 'Cancel Friend Ship';
      }
      // return 'Accept';
    }
  }
};

const actions={
  fetchUser({commit},userId){
    commit('setUserStatus','loading');
    axios.get('/wb/users/' + userId)
    .then(res=>{
      commit('setUser',res.data);
      commit('setUserStatus','success');
    })
    .catch(err=>{
      commit('setUserStatus','error');
    });
  },
  sendFriendRequest({commit,getters},friendId){
    if(getters.friendButtonText !== 'Add Friend'){
      return;
    }
    axios.post('/wb/friend-request',{'friend_id':friendId})
    .then(res=>{
      // commit('setUserFriendShip',res.data);
      // dispatch('fetchUser',5);
      // dispatch('fetchAuthUser', { root: true });
    })
  },
  acceptFriendRequest({commit,state,dispatch,rootState},friendId){
    // axios.post('/wb/friend-request-responce',{'friend_id':friendId})
    axios.get('/wb/friend-request-responce/'+ friendId)
    .then(res=>{
      commit('setUserFriendShip',res.data);
      dispatch('fetchUser',rootState.User.user.data.user_id);
      dispatch('fetchAuthUser', { root: true });
    })
  },
  CancelFriendShips({commit,state},data){
    // console.log(data.friend_id);
    axios.delete('/wb/friend-request-response/'+ data.friend_id)
    .then(res=>{
      commit('rempoveFriendShip', data.key, { root: true })
      commit('setUserFriendShip',null);
    })
  },
  // /wb/friend-request-responce/accept
  IgnoreFriendRequest({commit,state},data){
    axios.delete('/wb/friend-request-response/'+ data.friend_id)
    .then(res=>{
      commit('rempoveFriendRequest', data.key, { root: true }) //
      commit('setUserFriendShip',null);
    })
  },
  CancelFriendShipOrFriendRequest({ dispatch,commit,state},userId){
    axios.post('/wb/friendShip',{'user_id':userId})
    .then(res=>{
      // commit('setUserFriendShip',null);
      // dispatch('fetchUser',5);
      // dispatch('fetchAuthUser', { root: true });
    })
  },
};

const mutations={
  setUserStatus(state,status){
    state.userStatus=status;
  },
  setUserFriendShip(state,friends){
    // state.user.data.attributes.friendship=friends;
  },
  setUser(state,user){
    state.user=user;
  },
};

export default {
  state,getters,actions,mutations
}

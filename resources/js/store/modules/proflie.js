const state={
  user:null,
  userStatus:null,
  // friendButtonText:null,
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
          return 'Add Friend';
      } else if (getters.friendShip.data.attributes.confirmed_at === null
          && getters.friendShip.data.attributes.friend_id !== rootState.User.user.data.user_id) {
          return 'Pending Friend Request';
      } else if (getters.friendShip.data.attributes.confirmed_at !== null) {
          return '';
      }
      return 'Accept';
    }

    // return state.friendButtonText;
  }
};

const actions={
  fetchUser({commit,dispatch},userId){
    commit('setUserStatus','loading');
    axios.get('/wb/users/' + userId)
    .then(res=>{
      commit('setUser',res.data);
      commit('setUserStatus','success');
      // dispatch('setFriendButton');
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
      commit('setUserFriendShip',res.data);
    })
    .catch(error=>{
      // commit('setfriendButtonText','Add Friend');
    });
  },
  acceptFriendRequest({commit,state},userId){
    axios.post('/wb/friend-request-responce',{data:{'user_id':userId}})
    .then(res=>{
      commit('setUserFriendShip',res.data);
    })
    .catch(error=>{
    });
  },
  ignoreFriendRequest({commit,state},userId){
    axios.delete('/wb/friend-request-responce/delete',{'user_id':userId})
    .then(res=>{
      commit('setUserFriendShip',res.data);
    })
    .catch(error=>{
    });
  },
  // setFriendButton({commit,getters}){
  //   if(getters.friendShip === null){
  //     commit('setfriendButtonText','Add Friend');
  //   }else if(getters.friendShip.data.attributes.confirmed_at === null){
  //     commit('setfriendButtonText','Pending Friend Request');
  //   }else if(getters.friendShip.data.attributes.confirmed_at !== null){
  //     commit('setfriendButtonText','');
  //   }
  // }
};

const mutations={
  setUserStatus(state,status){
    state.userStatus=status;
  },
  setUserFriendShip(state,friends){
    state.user.data.attributes.friendship=friends;
  },
  setUser(state,user){
    state.user=user;
  },

  // setfriendButtonText(state,text){
  //   state.friendButtonText=text;
  // },
};

export default {
  state,getters,actions,mutations
}

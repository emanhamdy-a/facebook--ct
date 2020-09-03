const state={
  user:null,
  userStatus:null,
  posts:null,
  postStatus:false,
  // friendButtonText:null,
};

const getters={
  user:state=>{
    return state.user;
  },
  posts:state=>{
    return state.posts;
  },
  postStatus:state=>{
    return state.postStatus;
  },
  friendShip:state=>{
    return state.user.data.attributes.friendship;
  },
  friendButtonText:(state,getters,rootState)=>{
    // alert(rootState.user.user.data.user_id);
    if(getters.friendShip === null){
     return'Add Friend';
    }else if(getters.friendShip.data.attributes.confirmed_at === null
      && getters.friendShip.data.attributes.friend_id
      !== rootState.user.user.data.user_id){
        return'Pending Friend Request';
    }
    return 'Accept';
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
  fetchUserPosts({commit,state},userId){
    commit('setpostStatus',true);
    axios.get('/wb/users/' + userId + '/posts')
    .then(res=>{
      commit('setPosts',res.data);
    })
    .catch(error=>{
      console.log('unable to fech posts');
    })
    .finally(()=>{
      commit('setpostStatus',false);
    });
  },
  sendFriendRequest({commit,state},friendId){
    axios.post('/wb/friend-request',{'friend_id':friendId})
    .then(res=>{
      commit('setUserFriendship',res.data);
    })
    .catch(error=>{
      // commit('setfriendButtonText','Add Friend');
    });
  },
  acceptFriendRequest({commit,state},userId){
    axios.post('/wb/friend-request-responce',{data:{'user_id':userId}})
    .then(res=>{
      commit('setUserFriendship',res.data);
    })
    .catch(error=>{
    });
  },
  ignoreFriendRequest({commit,state},userId){
    axios.delete('/wb/friend-request-responce/delete',{'user_id':userId})
    .then(res=>{
      commit('setUserFriendship',res.data);
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
  setUserFriendship(state,friends){
    state.user.data.attributes.friendship=friends;
  },
  setUser(state,user){
    state.user=user;
  },
  setpostStatus(state,status){
    state.postStatus=status;
  },
  setPosts(state,data){
    state.posts=data;
  },
  // setfriendButtonText(state,text){
  //   state.friendButtonText=text;
  // },
};

export default {
  state,getters,actions,mutations
}

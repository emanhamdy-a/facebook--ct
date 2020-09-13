const state={
  user:null,
  userState:null,
};

const getters={
  authUser:state=>{
    return state.user;
  }
};

const actions={
  fetchAuthUser({commit,state}){
    axios.get('/wb/auth-user')
    .then(res=>{
      commit('setAuthUser',res.data);
    })
    .catch(err=>{
    })
  },
  change_cover_image({commit},cover_image){
    commit('change_cover_img',cover_image);
  },
};

const mutations={
  setAuthUser(state,user){
    state.user=user;
  },
  rempoveFriendShip(state,friendShipKey){
    if(friendShipKey == 0){
      state.user.data.attributes.friendships.data.shift();
    }else{
      state.user.data.attributes.friendships.data.splice(friendShipKey);
    }
  },
  rempoveFriendRequest(state,friendShipKey){
    if(friendShipKey == 0){
      state.user.data.attributes.friendequests.data.shift();
    }else{
      state.user.data.attributes.friendequests.data.splice(friendShipKey);
    }
  },
  change_profile_image(state,cover_img){
    state.user.data.attributes.cover_image.data=cover_img;
  },
};

export default {
  state,getters,actions,mutations
}

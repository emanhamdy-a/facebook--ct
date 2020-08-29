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
  }
};

const mutations={
  setAuthUser(state,user){
    state.user=user;
  }
};

export default {
  state,getters,actions,mutations
}

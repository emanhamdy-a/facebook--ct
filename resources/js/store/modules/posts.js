const state={
  newsPosts:null,
  newsPostsStatus:null,
  postMessage:'',
  Likes:null,
};

const getters={
  newsPosts:state=>{
    return state.newsPosts;
  },
  newsStatus:state=>{
    return{
      newsStatus:state.newsPostsStatus,
    }
  },
  postMessage:state=>{
    return state.postMessage;
  },
  Likes:state=>{
    return state.Likes;
  }
};

const actions={
  fetchNewsPosts({commit,state}){
    commit('setPostsStatus','loading');
    axios.get('/wb/posts')
    .then(res=>{
      commit('setPosts',res.data);
      commit('setPostsStatus','success');
    })
    .catch(error=>{
      commit('setPostsStatus','error');
    });
  },
  postMessage({commit,state}){
    axios.post('/wb/posts',{body:state.postMessage})
    .then(res=>{
      commit('pushPost',res.data);
      commit('updateMessage','');
      // commit('setPostsStatus','success');
    })
    .catch(error=>{
      // commit('setPostsStatus','error');
    });
  },
  likePost({commit,state},data){
    axios.post('/wb/posts/'+ data.postId + '/like')
    .then(res=>{
      commit('pushLikes',{ likes:res.data,postKey:data.postKey});
      // commit('setPostsStatus','success');
    })
    .catch(error=>{
      // commit('setPostsStatus','error');
    });
  },
};

const mutations={
  setPostsStatus(state,status){
    state.newsPostsStatus=status;
  },
  setPosts(state,posts){
    state.newsPosts=posts;
  },
  updateMessage(state,message){
    state.postMessage=message;
  },
  pushPost(state,post){
    state.newsPosts.data.unshift(post);
  },
  pushLikes(state,data){
    // console.log(data.postKey);
    state.newsPosts.data[data.postKey].data.attributes.likes=data.likes;
  },
};

export default {
  state,getters,actions,mutations
}

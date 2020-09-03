const state={
  posts:null,
  postsStatus:null,
  postMessage:'',
  Likes:null,
};

const getters={
  posts:state=>{
    return state.posts;
  },
  newsStatus:state=>{
    return{
      newsStatus:state.postsStatus,
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
  fetchUserPosts({commit,state},userId){
    commit('setPostsStatus','loading');
    axios.get('/wb/users/' + userId + '/posts')
    .then(res=>{
      commit('setPosts',res.data);
      commit('setPostsStatus','success');
    })
    .catch(error=>{
      commit('setPostsStatus','error');
    });

  },
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
  commentPost({commit,state},data){
    axios.post('/wb/posts/'+ data.postId + '/comment',{body:data.body})
    .then(res=>{
      commit('pushComments',{ comments:res.data,postKey:data.postKey});
      // commit('setPostsStatus','success');
    })
    .catch(error=>{
      // commit('setPostsStatus','error');
    });
  },
};

const mutations={
  setPostsStatus(state,status){
    state.postsStatus=status;
  },
  setPosts(state,posts){
    state.posts=posts;
  },
  updateMessage(state,message){
    state.postMessage=message;
  },
  pushPost(state,post){
    state.posts.data.unshift(post);
  },
  pushLikes(state,data){
    // console.log(data.postKey);
    state.posts.data[data.postKey].data.attributes.likes=data.likes;
  },
  pushComments(state,data){
    state.posts.data[data.postKey].data.attributes.comments=data.comments;
  },
  setPostsStatus(state,status){
    state.postsStatus=status;
  },
  setPosts(state,data){
    state.posts=data;
  },
};

export default {
  state,getters,actions,mutations
}

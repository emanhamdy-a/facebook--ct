<template>
  <div class=" flex flex-col items-center py-4">
    <Newpost></Newpost>
    <p v-if="loading">Posts loading ...</p>
    <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"></Post>
  </div>
</template>

<script>
import Post from '../components/Post'
import Newpost from '../components/Newpost'

export default {
  components: {
    Post, Newpost },
  name: "Newsfeed",
  data() {
    return {
      posts:[],
      loading:true,
    };
  },
    // alert(window.laravel);
    // axios.get('/api/posts')
  methods: {
    },
  mounted(){
    axios.get('/posts')
    .then(res=>{
      console.log('done');
      this.loading=false;
      this.posts=res.data;
    })
    .catch(error=>{
      this.loading=false;
      console.log('unable to fech posts');
    });
  }
};
</script>

<style scoped></style>

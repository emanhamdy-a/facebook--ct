<template>
  <div class=" flex flex-col items-center py-4">
    <Newpost></Newpost>
    <p v-if="newsStatus.newsStatus === 'loading'">Posts loading ...</p>
    <Post v-else-if="newsStatus.newsStatus === 'success'" v-for="(post,postKey) in posts.data" :key="postKey" :post="post"></Post>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Post from '../components/Post'
import Newpost from '../components/Newpost'
export default {
  components: {
    Post, Newpost },
  name: "Newsfeed",

  methods: {
    },
  mounted(){
    this.$store.dispatch('fetchNewsPosts');
  },
  computed:{
    ...mapGetters({
      posts:'posts',
      newsStatus:'newsStatus',
    })
  }
};
</script>

<style scoped></style>

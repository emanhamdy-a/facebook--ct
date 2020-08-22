<template>
  <div class=" flex flex-col items-center py-4">
    <Newpost></Newpost>
    <Post></Post>
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
    return {};
  },
  methods: {}
};
</script>

<style scoped></style>

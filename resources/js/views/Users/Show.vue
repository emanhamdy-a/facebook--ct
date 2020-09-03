<template>
  <div class="flex flex-col items-center">
    <div class="relative w-full mb-8">
      <div class="w-100 h-64 overflow-hidden z-10">
        <img src="http://127.0.0.1:8000/images/profile3.jpg" alt="profile image" class="object-cover w-full ">
      </div>
      <div class="absolute bottom-0 left-0 -mb-8 flex items-center z-20" v-if="status.user==='success'">
        <img src="http://127.0.0.1:8000/images\person1.jpeg" alt="image profile" class="w-32 h-32  ml-8 rounded-full object-cover border-gray-200 border-4 shadow-lg">
        <p class="text-2xl text-gray-600 ml-8">{{ user.data.attributes.name }}</p>
      </div>
      <div
        class="absolute bottom-0 right-0 mb-4 flex items-center mr-10 z-20">
        <button class="py-1 px-3 rounded bg-gray-400"
          v-if="friendButtonText && friendButtonText !=='Accept'"
          @click="$store.dispatch('sendFriendRequest',$route.params.userId)">
          {{ friendButtonText }}
        </button>
        <button class="mr-2 py-1 px-3 rounded bg-blue-500"
          v-if="friendButtonText && friendButtonText ==='Accept'"
          @click="$store.dispatch('acceptFriendRequest',$route.params.userId)">
          Accept
        </button>
        <button class="mr-2 py-1 px-3 rounded bg-gray-400"
          v-if="friendButtonText && friendButtonText ==='Accept'"
          @click="$store.dispatch('ignoreFriendRequest',$route.params.userId)">
          Ignore
        </button>
      </div>
    </div>
    <p v-if="status.posts === 'loading'">Posts loading ...</p>
    <p v-else-if="status.posts === 'success' && posts.data.length < 1"> No posts ...</p>
    <p v-else-if="status.posts === 'error'"> Error ...</p>
    <Post v-else v-for="(post,postKey) in posts.data" :key="postKey" :post="post"></Post>
  </div>
</template>

<script>
import Post from "../../components/Post";
// import UploadableImage from "../../components/UploadableImage";
import { mapGetters } from "vuex";

export default {
  name: "Show",
  // data(){
  //   return{
  //     posts:[],
  //     loading:true,
  //     postLoading:true,
  //   }
  // },
  components: {
    Post,
    // UploadableImage
  },
  methods:{

    },
  mounted() {
    this.$store.dispatch('fetchUser',this.$route.params.userId);
    this.$store.dispatch("fetchUserPosts", this.$route.params.userId);
  },

  computed: {
    ...mapGetters({
      user: "user",
      posts: "posts",
      status:'status',
      // // authUser:'authUser',
      friendButtonText: "friendButtonText"
    }),
  }
};
</script>

<style scoped></style>

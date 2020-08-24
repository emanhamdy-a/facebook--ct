<template>
  <!-- <div class="flex flex-col items-center">
    <div class="relative mb-8">
      <div class="w-100 h-64 overflow-hidden z-10">
        <UploadableImage/>
      </div>

      <div class="absolute flex items-center bottom-0 left-0 -mb-8 ml-12 z-20">
        <div class="w-32">
          <UploadableImage/>
        </div>

        <p class="text-2xl text-gray-100 ml-4">
        </p>
      </div>

      <div class="absolute flex items-center bottom-0 right-0 mb-4 mr-12 z-20">
        <button>
        </button>
        <button>
          Accept
        </button>
        <button>
          Ignore
        </button>
      </div>
    </div>

    <div>Loading posts...</div>

    <div>No posts found. Get started...</div>

    <Post/>
  </div> -->
  <div class="flex flex-col items-center">
    <div class="relative w-full mb-8">
      <div class="w-100 h-64 overflow-hidden z-10">
        <img src="http://127.0.0.1:8000/images/profile3.jpg" alt="profile image" class="object-cover w-full ">
      </div>
      <div class="absolute bottom-0 left-0 -mb-8 flex items-center z-20">
        <img src="http://127.0.0.1:8000/images\person1.jpeg" alt="image profile" class="w-32 h-32  ml-8 rounded-full object-cover border-gray-200 border-4 shadow-lg">
        <p class="text-2xl text-gray-600 ml-8">{{ user.data.attributes.name }}</p>
      </div>
    </div>
    <p v-if="postLoading">Posts loading ...</p>
    <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"></Post>
    <p v-if="!postLoading && posts.lenth < 1"> No posts ...</p>
  </div>
</template>

<script>
import Post from "../../components/Post";
// import UploadableImage from "../../components/UploadableImage";
// import { mapGetters } from "vuex";

export default {
  name: "Show",
  data(){
    return{
      user:[],
      posts:[],
      loading:true,
      postLoading:true,
    }
  },
  components: {
    Post,
    // UploadableImage
  },
  methods:{

    },
  mounted() {
    axios.get('/wb/users/' + this.$route.params.userId)
      .then(res=>{
        this.user=res.data;
      })
      .catch(err=>{
        console.log('unable to fetch user data');
      })
      .finally(()=>{
        this.postLoading=false;
      });
    axios.get('/wb/users/' + this.$route.params.userId + '/posts')
      .then(res=>{
        // console.log(res.data);
        this.posts=res.data;
      })
      .catch(error=>{
        console.log('unable to fech posts');
      })
      .finally(()=>{
        this.loading=false;
      });
    // this.$store.dispatch("fetchUser", this.$route.params.userId);
    // this.$store.dispatch("fetchUserPosts", this.$route.params.userId);
  },

  computed: {
    // ...mapGetters({
    //   user: "user",
    //   posts: "posts",
    //   status: "status",
    //   friendButtonText: "friendButtonText"
    // })
  }
};
</script>

<style scoped></style>

<template>
  <div class="flex flex-col items-center">
    <div class="relative w-full mb-8">
      <div class="w-100 h-64 overflow-hidden z-10"
        v-if="authUser.data.user_id == $route.params.userId">
        <UploadableImage
          image-width='1500'
          image-height='500'
          location='cover'
          :alt="'user image'"
          :classes="'object-cover w-full'"
          :user-image="user.data.attributes.cover_image"
        />
      </div>
      <div class="w-100 h-64 overflow-hidden z-10" v-else>
        <img image-width='1500'
          v-if="user.data.attributes.cover_image !== null"
          :src="user.data.attributes.cover_image.data.attributes.path" class="object-cover w-full"
          image-height='500' location='cover'
        />
      </div>
      <div class="absolute bottom-0 left-0 -mb-8 flex items-center z-20"
        v-if="status.user==='success'">
        <UploadableImage
          v-if="authUser.data.user_id == $route.params.userId"
          image-width='750'
          image-height='750'
          location='profile'
          :alt="'profile image'"
          :classes="'w-32 h-32  ml-8 rounded-full object-cover border-gray-200 border-4 shadow-lg'"
          :user-image="user.data.attributes.profile_image"
        />
        <img
         v-else
          image-width='750'
          image-height='750'
          alt="'profile image'"
          class="'w-32 h-32  ml-8 rounded-full object-cover border-gray-200 border-4 shadow-lg'"
          :src="user.data.attributes.profile_image.data.attributes.path"
        />
        <p class="text-2xl text-gray-600 ml-8">{{ user.data.attributes.name }}</p>
      </div>
      <div
        class="absolute bottom-0 right-0 mb-4 flex items-center mr-10 z-20">
        <button class="mr-2 py-1 px-3 rounded bg-blue-500 text-white"
          v-if="friendButtonText && friendButtonText ==='Add Friend'"
          @click="$store.dispatch('sendFriendRequest',$route.params.userId)">
           {{ friendButtonText }}
        </button>
        <button class="mr-2 py-1 px-3 rounded bg-gray-400"
          v-else-if="friendButtonText && friendButtonText ==='Cancel Friend Request'"
          @click="$store.dispatch('UserCancelFriendRequestOrFriendShip',$route.params.userId)">
          {{ friendButtonText }}
        </button>
        <button class="mr-2 py-1 px-3 rounded bg-gray-400"
          v-else-if="friendButtonText && friendButtonText ==='Cancel Friend Ship'"
          @click="$store.dispatch('UserCancelFriendRequestOrFriendShip',$route.params.userId)">
          {{ friendButtonText }}
        </button>
        <!-- <button class="mr-2 py-1 px-3 rounded bg-blue-500"
          v-if="friendButtonText && friendButtonText ==='Accept'"
          @click="$store.dispatch('acceptFriendRequest',$route.params.userId)">
          Accept
        </button> -->
        <!-- <button class="mr-2 py-1 px-3 rounded bg-gray-400"
          v-if="friendButtonText && friendButtonText ==='Accept'"
          @click="$store.dispatch('FriendCancelFriendShipOrIgnoreFriendRequest',$route.params.userId)">
          Ignore
        </button> -->
      </div>
    </div>
    <p v-if="status.posts === 'loading'">Posts loading ...</p>
    <p v-else-if="status.posts === 'success' && posts.data.length < 1">
      No posts ...
    </p>
    <p v-else-if="status.posts === 'error'"> Error ...</p>
    <Post
      v-else v-for="(post,postKey) in posts.data" :key="postKey" :post="post">
    </Post>
  </div>
</template>

<script>
import Post from "../../components/Post";
import UploadableImage from "../../components/UploadableImage";
import { mapGetters } from "vuex";

export default {
  name: "Show",
  components: {
    UploadableImage,
    Post,
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
      authUser:'authUser',
      friendButtonText: "friendButtonText"
    }),
  }
};
</script>

<style scoped></style>

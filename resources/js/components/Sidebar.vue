<template>
  <div class="w-1/4 bg-white p-4 border-r border-gray-400">
  <router-link to="/">
    <h2 class="font-bold text-2xl tracking-tight">Home</h2>
  </router-link>
  <router-link :to="'/users/' + authUser.data.user_id">
    <h2 class="font-bold text-gray-700 text-xl tracking-tight">Profile</h2>
  </router-link>
  <router-link :to="'/friends/' + authUser.data.user_id">
    <h2 class="font-bold text-gray-700 text-xl tracking-tight">Friends</h2>
  </router-link>
    <!-- <"authUser.data.attributes.profile_image.data.attributes.path"> -->
  <router-link :to="'/friend-requests/' + authUser.data.user_id">
    <h2 class="font-bold text-gray-700 text-xl tracking-tight">Friend Requests</h2>
  </router-link>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
  name: "",
  data() {
    return {};
  },

  computed:{
    ...mapGetters({
      authUser:'authUser',
    })
  },
  methods: {

  }
};
</script>

<style scoped></style>

<template>
<div>
  <div class="flex flex-col items-center"
    v-if="$route.params.friendId == authUser.data.user_id ">
    <div class="relative w-full mb-8">
      <div class="w-100 h-64 overflow-hidden z-10">
        <img image-width='1500'
          :src="authUser.data.attributes.cover_image.data.attributes.path" class="object-cover w-full"
          image-height='500' location='cover'
        />
      </div>
      <div class="absolute bottom-0 left-0 -mb-8 flex items-center z-20">
        <img
          image-width='750'
          image-height='750'
          alt="'profile image'"
          class="'w-32 h-32  ml-8 rounded-full object-cover border-gray-200 border-4 shadow-lg'"
          :src="authUser.data.attributes.profile_image.data.attributes.path"
        />
        <p class="text-2xl text-gray-600 ml-8">{{ authUser.data.attributes.name }}</p>
      </div>
    </div>
    <div
      class="bg-white rounded shadow w-2/3 mt-6 pl-4 overflow-hidden"
      v-for="(friend,friendKey) in
        authUser.data.attributes.friendships.data"
        :key="friendKey">
      <div class="p-4">
        <div class="flex items-center relative">
            <div class="w-8">
              <img
                v-if="friend.data.attributes.friend_info.image"
                :src="'../storage/' + friend.data.attributes.friend_info.image"
                alt="img"
                class="w-8 h-8 object-cover rounded-full"
              />
              <img v-else
                :src="'../storage/user-images/person1.png'"
                class="w-8 h-8 object-cover rounded-full"
              />
            </div>
            <div class="ml-6">
              <router-link
                :to="'/users/' + friend.data.attributes.friend_info.friend_id">
                <div class="text-sm font-bold">
                  {{ friend.data.attributes.friend_info.name }}
                </div>
              </router-link>
              <div class="text-sm text-gray-600">
                  {{ friend.data.attributes.confirmed_at }}
              </div>
            </div>
            <div class="absolute right-0 ">
              <button class="mr-2 py-1 px-3 rounded bg-gray-400"
                @click="$store.dispatch('CancelFriendShips',{
                  friend_id:friend.data.attributes.friend_info.friend_id,
                  key:friendKey
                })">
                Cancel
              </button>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div
    v-if="$route.params.friendId != authUser.data.user_id "
    class="bg-red-100 rounded shadow w-2/3 m-40 p-10 text-red-500 text-2xl overflow-hidden">
    You have not premission to acces this rout ...
  </div>
</div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "Friends",
  components: {
  },

  mounted() {
    this.$store.dispatch('fetchUser',this.$route.params.friendId);
  },

  computed: {
    ...mapGetters({
      authUser:'authUser',
    }),
  }
};
</script>

<style scoped></style>

<template>
  <div>
    <img
    :src="userImage.data.attributes.path"
    :alt="alt"
    ref="userImage"
    :class="classes">
  </div>
</template>

<script>
import Dropzone from 'dropzone';
import { Store } from 'vuex';
import { mapGetters } from "vuex";

export default {
 name:'UploadableImage',
  props:[
    'alt',
    'classes',
    'userImage',
    'imageWidth',
    'imageHeight',
    'location',
  ],
 data:()=>{
   return{
     dropzone:null,
    //  uploadedImage:null,
   }
 },
 mounted(){
   if(this.authUser.data.user_id == this.$route.params.userId){
     this.dropzone=new Dropzone(this.$refs.userImage,this.settings);
   }
 },
 computed:{
  ...mapGetters({
    authUser:'authUser',
  }),
  settings(){
    return{
       paramName:'image',
       url:'/wb/user-images',
       acceptedFiles:'image/*',
       params:{
         'width':this.imageWidth,
         'height':this.imageHeight,
         'location':this.location,
       },
       headers:{
         'X-CSRF-TOKEN':document.head.querySelector('meta[name=csrf-token]').content,
       },
       success:(e,res)=>{
        //  this.$store.dispatch('change_profile_image',res.data);
         this.$store.dispatch('fetchAuthUser');
         this.$store.dispatch('fetchUser',this.$route.params.userId);
         this.$store.dispatch('fetchUserPosts',this.$route.params.userId);
       }
     };
  },
  // imageObject(){
  //   return this.uploadedImage || this.$props.userImage;
  // }
 },
  methods:{

  }
}
</script>

<style>

</style>

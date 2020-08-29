import Vue from "vue";
import router from "./router";
import App from "./components/App";
import store from './store';
require("./bootstrap");

const app = new Vue({
  el: "#app",
  router,
  store,
  components: {
    App
  },
  mounted(){
    this.$store.dispatch('fetchAuthUser');
  },
  created(){
    this.$store.dispatch('setPageTitle',this.$route.meta.title)
  },
  watch:{
    $route(to,from){
      this.$store.dispatch('setPageTitle',to.meta.title)
    }
  }
});

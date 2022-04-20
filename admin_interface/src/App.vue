<template>
  <div id="app">
    <div v-if="user">
      <router-view name="header"></router-view>
      <router-view name="sideBar"></router-view>
    </div>
      <div v-else></div>
      <router-view ></router-view>
  </div>
</template>

<script>
import getCookie from './components/component/getCookie'
import {getApi} from './components/component/getApi'

export default {
  name: 'App',
  components: {
    
  },
  data(){
    return {
      get_cookie:"",
      user: null
    }
  },
  mounted(){
      this.get_cookie = getCookie.getCookie('elecshop_login');
      if(this.get_cookie){
          getApi(this.$hostname+'/api/v1/users/user_login',"",this.get_cookie)
              .then(res => {
                  if(res.message || res.code == 404){
                      this.user = null
                  }else{
                      this.user = res.data
                  }
              })
      }
  }
}
</script>

<style>

</style>

<template>
  <div id="app">
    <div v-if="user">
        <router-view name="header" v-bind:userLogin="user" v-if="user"></router-view>
        <router-view name="sideBar" v-bind:userLogin="user"  v-if="user"></router-view>
    </div>
    <div v-else>
      <!-- <div class="loader-bg">
          <div class="loader-track">
              <div class="loader-fill"></div>
          </div>
      </div> -->
    </div>
    <router-view v-bind:userLogin="user" @eventname="updateUserLogin"></router-view>
  </div>
</template>
<script>
import {getApi} from './components/component/getApi'

export default {
  name: 'App',
  components: {
    
  },
  data(){
    return {
      user: null
    }
  },
  created(){
    const verifyLogin = this.$verifyLogin()
    verifyLogin.then(res => {
      if(res.success) {
        this.user = {
          data:res.data,
            token:res.token
          }
      }
    })
  },
  methods: {
     updateUserLogin(variable) {
        console.log(variable)
        this.user = variable
    }
  }
}
</script>

<style>

</style>

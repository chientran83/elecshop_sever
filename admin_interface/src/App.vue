<template>
  <div id="app">
    <div v-if="loadingCircle">
      <div v-if="user">
          <router-view name="header" v-bind:userLogin="user" v-if="user"></router-view>
          <router-view name="sideBar" v-bind:userLogin="user"  v-if="user"></router-view>
      </div>
      <router-view v-bind:userLogin="user" @eventname="updateUserLogin"></router-view>
    </div>
    
    <div v-else>
      <div class="box">
        <div class="loader"></div>
      </div>
    </div>
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
      user: null,
      loadingCircle: false
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
    }).then(() => {
      this.loadingCircle = true;
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
    .box {
      width: 100vw;
      height: 100vh;
      display:flex;
      justify-content:center;
      align-items:center;
    }
    .loader {
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid #3498db;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite; /* Safari */
    animation: spin 2s linear infinite;
  }

  /* Safari */
  @-webkit-keyframes spin {
    0% { -webkit-transform: rotate(0deg); }
    100% { -webkit-transform: rotate(360deg); }
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

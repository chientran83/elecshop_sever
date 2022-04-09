<template>
  <div id="app">
    <!-- <Sidebar></Sidebar>
    <Header></Header> -->
    <router-view name="header"></router-view>
    <router-view name="sideBar"></router-view>
    <router-view></router-view>
    
  </div>
</template>

<script>

export default {
  name: 'App',
  components: {

  }
}
</script>

<style>

</style>

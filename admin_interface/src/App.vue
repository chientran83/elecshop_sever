<template>
  <div id="app">
    <div >
      <router-view name="header"></router-view>
      <router-view name="sideBar"></router-view>
      <router-view ></router-view>
    </div>
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

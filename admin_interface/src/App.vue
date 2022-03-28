<template>
  <div id="app">
    <Sidebar></Sidebar>
    <Header></Header>
    <router-view></router-view>
    
  </div>
</template>

<script>
import Header from './components/partial/Header'
import Sidebar from './components/partial/Sidebar'
export default {
  name: 'App',
  components: {
    Header,
    Sidebar
  }
}
</script>

<style>

</style>

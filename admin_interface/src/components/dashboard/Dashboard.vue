<template>
    <div >
         <router-view v-bind:userLogin="userLogin" ></router-view>
    </div>
</template>

<script>
   export default {
        props:['userLogin'],
        data(){
            return {

            }
        },
        created(){
            if(!this.userLogin){
                this.$router.push({ path: '/sign-in' })
            }
        }
    }
</script>

<style>

</style>

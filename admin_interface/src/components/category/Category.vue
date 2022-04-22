<template>
    <div class="pcoded-main-container" v-if="userLogin">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <router-view v-bind:userLogin="userLogin"></router-view>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        props:['userLogin'],
        created(){
            if(!this.userLogin){
                this.$router.push({ path: '/sign-in' })
            }
        }
    }
</script>
<style>
</style>
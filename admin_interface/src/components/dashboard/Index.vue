<template>
    <div class="pcoded-inner-content" v-if="userLogin">
                    <h1>Dashboard</h1>
                    <h3 >{{userLogin}}</h3>
 
    </div>
</template>
<script>
import axios from "axios"
    export default {
        props:['userLogin'],
        data(){
           return {
               user:null
           }
        },
        mounted(){
           
        }
    }
</script>
<style>

</style>
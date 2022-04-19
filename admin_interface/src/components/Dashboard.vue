<template>
    <!-- sidebar -->
    <!-- header -->
    <!-- [ Main Content ] start -->
    <div>
        <h1>sldkgj</h1>
    </div>
</template>

<script>
import getCookie from './component/getCookie'
export default {
    data(){
        return {
                categories: []
            }
    },
    props:['userData'],
    mounted(){
        fetch(this.$hostname+'/api/v1/category/index/'+this.record_number).then(res => res.json()).then(res => {
            console.log( res.data)

        })
    }
   /*  data(){
        return {
                get_cookie:"",
                user: null
            }
    },
    props:['userData'],
    mounted(){
        this.get_cookie = getCookie.getCookie('elecshop_login');
        if(this.get_cookie){
            fetch(this.$hostname + '/api/v1/users/user_login',{headers:{"Authorization" : "Bearer " + this.get_cookie,'Content-Type': 'application/json','Accept': 'application/json'}})
                .then(res => res.json())
                .then(res => {
                    if(res.message || res.code == 404){
                        this.$router.push('/sign-in')
                    }else{
                        this.user = res.data
                    }
                })
                .catch(err => {
                    console.log(err)
                })
        }else{
            this.$router.push('/sign-in')

        }
    } */
                
        
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>

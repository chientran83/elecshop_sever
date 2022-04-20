<template>
    <!-- sidebar -->
    <!-- header -->
    <!-- [ Main Content ] start -->
    <div>
        
    </div>
</template>

<script>
import getCookie from './component/getCookie'
import { getApi } from './component/getApi'
export default {
    data(){
        return {
                get_cookie:"",
                user: null
            }
    },
    props:['userData'],
    mounted(){
        this.get_cookie = getCookie.getCookie('elecshop_login');
        if(this.get_cookie){
            getApi(this.$hostname + '/api/v1/users/user_login',"",this.get_cookie).then(res => {
                 if(res.message || res.code == 404){
                        this.$router.push('/sign-in')
                    }else{
                        this.user = res.data
                    }
            });
        }else{
            this.$router.push('/sign-in')

        }
    }
                
        
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>

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
        const verifyLogin = this.$verifyLogin()
        verifyLogin.then(res => {
            if(res.success) {
                this.user = res.data;
                this.get_cookie = res.token;
            }else{
                this.$router.push('/sign-in')
            }
        })
    }
                
        
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style>

</style>

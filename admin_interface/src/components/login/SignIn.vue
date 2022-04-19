<template>
  <div class="auth-wrapper">
        <div class="auth-content">
            <div class="auth-bg">
                <span class="r"></span>
                <span class="r s"></span>
                <span class="r s"></span>
                <span class="r"></span>
            </div>
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="feather icon-unlock auth-icon"></i>
                    </div>
                    <h3 class="mb-4">Login</h3>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" v-model="user.email">
                    </div>
                    <div class="input-group mb-3">
                        <li class="text-danger float-left" v-if="error.email">{{error.email}}</li>
                    </div>
                    <div class="input-group mb-4">
                        <input type="password" class="form-control" placeholder="password" v-model="user.password">
                    </div>
                    <div class="input-group mb-4">
                        <li class="text-danger float-left" v-if="error.password">{{error.password}}</li>
                    </div>
                    <div class="form-group text-left">
                        <div class="checkbox checkbox-fill d-inline">
                            <input type="checkbox" name="checkbox-fill-1" id="checkbox-fill-a1" checked="" v-model="user.remember_token">
                            <label for="checkbox-fill-a1" class="cr"> Save Details</label>
                        </div>
                    </div>
                    <button class="btn btn-primary shadow-2 mb-4" v-on:click="singIn()">Login</button>
                    <p class="mb-2 text-muted">Forgot password? <a href="#">Reset</a></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data(){
        return {
            user:{
                email:"",
                password:"",
                remember_token:""
            },
            error:{
                email:"",
                password:""
            }
        }
    },
    mounted(){
    },
    methods:{
        singIn:function(){
            var formData = new FormData();
            formData.append('email',this.user.email);
            formData.append('password',this.user.password);
            formData.append('remember_token',this.user.remember_token);
            axios.post(this.$hostname+'/api/v1/users/login',formData)
                .then(res => {
                    if(res.data.code == 500){
                        this.error.password = res.data.message;
                        this.user.password = "";
                    }else{
                          const d = new Date();
                            d.setTime(d.getTime() + (3*24*60*60*1000));
                            let expires = "expires="+ d.toUTCString();
                            document.cookie = "elecshop_login=" + res.data.access_token + ";" + expires + ";path=/";
                            this.$router.push('/')
                    }
                })
        }
    }
}

</script>

<style>

</style>
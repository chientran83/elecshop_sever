<template>
    <!-- [ Header ] start -->
    <header class="navbar pcoded-header navbar-expand-lg navbar-light">
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse1" href="javascript:"><span></span></a>
            <a href="index.html" class="b-brand">
                   <div class="b-bg">
                       <i class="feather icon-trending-up"></i>
                   </div>
                   <span class="b-title">Datta Able</span>
               </a>
        </div>
        <a class="mobile-menu" id="mobile-header" href="javascript:">
            <i class="feather icon-more-horizontal"></i>
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li><a href="javascript:" class="full-screen" onclick="javascript:toggleFullScreen()"><i class="feather icon-maximize"></i></a></li>
                <li class="nav-item">
                    <div class="main-search">
                           <form class="form-inline my-2 my-lg-0" >
                                <input class="form-control mr-sm-2" placeholder="Search" aria-label="Search" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-on:click="getOption" v-on:keyup="getOption" ref="getOption" autocomplete="off">
                                <div class="dropdown-menu ml-5" aria-labelledby="dropdownMenuLink" >
                                    <a class="dropdown-item" 
                                        :href="option.type == 'category' ? $hostnameInterface + '/category/edit/' + option.id 
                                            : option.type == 'coupon' ? $hostnameInterface + '/coupon/edit/' + option.id 
                                            : option.type == 'product' ? $hostnameInterface + '/product/edit/' + option.id
                                            : option.type == 'slider' ? $hostnameInterface + '/slider/edit/' + option.id
                                            : option.type == 'user' ? $hostnameInterface + '/user/edit/' + option.id
                                            :  $hostnameInterface + '/roles/edit/' + option.id" 
                                            v-for="(option,key) in searchOption" v-bind:key="key">{{ option.name }} - {{ option.type }}</a>
                                </div>
                            </form>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li>
                    <div class="dropdown drp-user">
                        <a href="javascript:" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon feather icon-settings"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                                <li
                                class="pro-head">
                                <router-link 
                                tag="a"
                                to="/userProfile">
                                    <img :src="$hostname+''+ userLogin.data.image_path" class="img-radius">
                                    <span>{{userLogin.data.name}}</span>
                                </router-link>
                                <a class="dud-logout" v-on:click="logOut()" style="cursor: pointer">
                                    <i class="feather icon-log-out"></i>
                                </a>
                            </li>
                            <ul class="pro-body">
                                <li>
                                    <router-link
                                        tag="a"
                                        to="/userProfile"
                                        class="dropdown-item">
                                        <i class="feather icon-user"></i> Profile
                                    </router-link>
                                </li>
                                <!-- <li><a href="javascript:" class="dropdown-item"><i class="feather icon-settings"></i> Settings</a></li> -->
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>
</template>

<script>
import axios from 'axios';
    export default {
        props:['userLogin'],
        data(){
            return {
                searchOption : []
            }
        },

        mounted(){
            
        },
        methods:{
            logOut:function(){
                axios.get(this.$hostname+'/api/v1/users/logout',{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then(() => {
                        document.cookie = 'elecshop_login' + '=; Max-Age=0'
                        this.$emit('updateUserLogin', null)
                        this.$router.push({ path: '/sign-in' })
                    })
            },
            getOption(){
                 axios.post(this.$hostname+'/api/v1/search',{keyWord:this.$refs.getOption.value},{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then((res) => {
                        this.searchOption = res.data;
                    })
            }
        }
    }

</script>
<style>
</style>
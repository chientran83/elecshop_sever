<template>
    <div class="pcoded-inner-content" v-if="user">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Resource manager</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="javascript:">Form Componants</a></li>
                            <li class="breadcrumb-item"><a href="javascript:">Form Elements</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <div class="main-body">
            <div class="page-wrapper">
                <!-- [ Main Content ] start -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Edit resource</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                       <div>
                                            <div class="form-group">
                                                <label>Resource name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="resource.alias">
                                            </div>
                                            <div class="form-group">
                                                <label class="typo__label">Permission</label>
                                                <multiselect v-model="resource.permissions" tag-placeholder="Add this as new tag" placeholder="Choose permissions" label="name" track-by="code" :options="permissionOptions" :multiple="true" :taggable="true" @tag="addPermission"></multiselect>
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/permission">Thoát</router-link>

                                            </a>
                                            <button class="btn btn-primary" v-on:click="update_resource()">Submit</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- [ Main Content ] end -->
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios'
import Multiselect from 'vue-multiselect'
    import getCookie from '../component/getCookie'
    import {getApi} from '../component/getApi'
    export default {
        components: {
            Multiselect
        },
         data(){
            return {
                resource:{
                    alias:"",
                    permissions:[]
                },
                permissionOptions: [],
                permissionOptionsDefault: [
                    { name: 'add', code: 'add' },
                    { name: 'edit', code: 'edit' },
                    { name: 'delete', code: 'delete' },
                    { name: 'index', code: 'index' },
                    { name: 'show', code: 'show' },
                ],
                user:null,
                get_cookie:""
            }
        },
        mounted(){
            this.get_cookie = getCookie.getCookie('elecshop_login');
            if(this.get_cookie){
                getApi(this.$hostname+'/api/v1/users/user_login',"",this.get_cookie)
                    .then(res => {
                        if(res.message || res.code == 404){
                            this.$router.push('/sign-in')
                        }else{
                            this.user = res.data
                        }
                    })
                    .then(()=>{
                        getApi(this.$hostname+'/api/v1/resource/',this.$route.params.id,"")
                            .then(res => {
                                this.resource.alias = res.data.alias,
            
                                res.data.permissionsDefaults.forEach(permission => {
                                    var checkExist = this.permissionOptionsDefault.find((permissionDefault,key) => {
                                        return permissionDefault.name == permission.allow;
                                    });
                                    if(checkExist){
                                        this.resource.permissions.push(checkExist)
                                    }else{
                                        const per = {
                                                name: permission.allow,
                                                code: permission.id
                                            }
                                        this.permissionOptions.push(per)
                                        this.resource.permissions.push(per)
                                    }
                                })
                                this.permissionOptions = this.permissionOptions.concat(this.permissionOptionsDefault)
                            })
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }else{
                this.$router.push('/sign-in')

            }
            

            
        },
        methods:{
            update_resource:function(){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, I agree!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.put(this.$hostname+'/api/v1/resource/'+this.$route.params.id,{alias:this.resource.alias, permissions:JSON.stringify(this.resource.permissions)},{headers:{"Authorization" : "Bearer " + this.get_cookie}})
                    .then(res => {
                         Swal.fire(
                        'Updated!',
                        'New resource has been updated.',
                        'success'
                        )
                    })
                }
                })
            },
            addPermission (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.permissionOptions.push(tag)
                this.resource.permissions.push(tag)
            }
        }
    }
</script>
<style>
</style>
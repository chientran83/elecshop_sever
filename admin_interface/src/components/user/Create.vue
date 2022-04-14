<template>
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">User manager</h5>
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
                                <h5>Create new</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <form>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="user.name">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="user.email">
                                            </div>
                                            <div class="form-group">
                                                <label class="typo__label">Roles</label>
                                                <multiselect v-model="user.roles" :options="optionsRoles" :multiple="true" group-values="libs" group-label="language" :group-select="true" placeholder="Select roles" track-by="name" label="name"><span slot="noResult">Oops! No elements found. Consider changing the search query.</span></multiselect>
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Enter name" v-model="user.password">
                                            </div>
                                            <div class="form-group">
                                                <label>Password again</label>
                                                <input type="password" class="form-control" placeholder="Enter name" v-model="user.passwordAgain">
                                            </div>
                                             <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" class="form-control" id="imgInp" v-on:change="preview_image()">
                                                <img src="@/assets/default.jpg" alt="default.jpg" id="output" class="img-thumbnail" style="width:250px;height:250px;">
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/user">Thoát</router-link>

                                            </a>
                                            <button class="btn btn-primary" v-on:click="user_store()">Submit</button>
                                        </form>
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
    export default {
        components: {
            Multiselect
        },
        data(){
            return {
                user:{
                    name:"",
                    email:"",
                    roles:[],
                    password:"",
                    passwordAgain:"",
                },
                optionsRoles: [
                    {
                        language: 'choose All',
                        libs: [
                            
                            ]
                    }
                   
                ],
                user:null,
                get_cookie:""
            }
        },
        mounted(){
            this.get_cookie = getCookie.getCookie('elecshop_login');
            if(this.get_cookie){
                fetch('http://localhost:8000/api/v1/users/user_login',{headers:{"Authorization" : "Bearer " + this.get_cookie,'Content-Type': 'application/json','Accept': 'application/json'}})
                    .then(res => res.json())
                    .then(res => {
                        if(res.message || res.code == 404){
                            this.$router.push('/sign-in')
                        }else{
                            this.user = res.data
                        }
                    })
                    .then(()=>{
                        this.user.status = 1;
                        fetch('http://localhost:8000/api/v1/role/index/'+0)
                            .then(res => res.json())
                            .then(res => {
                                this.optionsRoles[0].libs = res.data
                        });
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }else{
                this.$router.push('/sign-in')

            }
            
        },
        methods:{
            user_store:function(){
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
                    var form_data = new FormData();
                    form_data.append('name',this.user.name);
                    form_data.append('email',this.user.email);
                    form_data.append('roles',JSON.stringify(this.user.roles));
                    form_data.append('password',this.user.password);
                    form_data.append('passwordAgain',this.user.passwordAgain);
                    form_data.append('image',document.getElementById('imgInp').files[0]);
                    axios.post('http://localhost:8000/api/v1/users',form_data,{
                        headers:{
                            'Content-Type' : 'multipart/form-data',
                            "Authorization" : "Bearer " + this.get_cookie
                        }
                    }).then(res => {
                        this.user.name = "";
                        this.user.email = "";
                        this.user.roles = [];
                        this.user.password = "";
                        this.user.passwordAgain = "";
                        document.getElementById('imgInp').value = "";
                        Swal.fire(
                        'Added new!',
                        'New user has been added.',
                        'success'
                        )
                    })
                   
                }
                })
               
            },
            preview_image:function (event){
                var imgInp = document.getElementById('imgInp').files[0];
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(imgInp);
                output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
                }
            }
        }
    }
</script>
<style>

</style>
<template>
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Category manager</h5>
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
                                <h5>Edit category</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <form>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="category.name">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Desc</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter desc" v-model="category.desc"></textarea>
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/category">Thoát</router-link>

                                            </a>
                                            <button class="btn btn-primary" v-on:click="update_category()">Submit</button>
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
import axios from 'axios';
    export default {
        data(){
            return {
                category:{
                    name:"",
                    desc:""
                },
                get_cookie:""
            }
        },
        mounted(){
            // get token
            let name = "elecshop_login=";
            let decodedCookie = decodeURIComponent(document.cookie);
            let ca = decodedCookie.split(';');
            for(let i = 0; i <ca.length; i++) {
                let c = ca[i];
                while (c.charAt(0) == ' ') {
                c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                this.get_cookie = c.substring(name.length, c.length);
                }
            }
            fetch('http://localhost:8000/api/v1/users/user_login',{headers:{"Authorization" : "Bearer " + this.get_cookie}}).then(res => res.json()).then(res => {
                if(res.code == 404){
                    this.$router.push('/sign-in');
                }
            })
            fetch('http://localhost:8000/api/v1/category/' + this.$route.params.id)
                .then(res => res.json())
                .then(res => {
                    this.category.name = res.data.name,
                    this.category.desc = res.data.desc
                })
                
        },
        methods:{
            update_category:function(){
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
                    axios.put('http://localhost:8000/api/v1/category/'+this.$route.params.id,{name:this.category.name,desc:this.category.desc},{headers:{"Authorization" : "Bearer " + this.get_cookie}})
                    .then(res => {
                         Swal.fire(
                        'Updated!',
                        'New category has been updated.',
                        'success'
                        )
                    })
                }
                })
            }
        }
    }
</script>
<style>
</style>
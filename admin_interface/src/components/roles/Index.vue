<template>
    <div class="pcoded-inner-content">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Role manager</h5>
                                    </div>
                                    <ul class="breadcrumb">
                                        <router-link
                                        tag="li"
                                        class="breadcrumb-item"
                                        to="/">
                                        <a>
                                            <i class="feather icon-home"></i>
                                        </a>
                                        </router-link>
                                        <li class="breadcrumb-item"><a >Role list</a></li>
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
                                <!-- [ basic-table ] start -->
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5></h5>
                                            <span class="d-block m-t-5">List of role</span>
                                        </div>
                                        <div class="col-6">
                                            <a>
                                            <router-link 
                                            tag="button"
                                            class="btn btn-success btn-sm"
                                            to="/roles/create">
                                                Create new <i class="fas fa-plus"></i>
                                            </router-link>
                                            </a>
                                        </div>
                                        <div class="card-block table-border-style">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Id</th>
                                                            <th>Name</th>
                                                            <th>Desc</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(role_item,key) in roles" v-bind:key="key">
                                                            <td class="col-2" > {{ role_item.id }} </td>
                                                            <td>{{ role_item.name }}</td>
                                                            <td class="d-inline-block text-truncate" style="max-width: 200px;">{{ role_item.desc }}</td>
                                                            <td>
                                                                <p class="text-success mb-1" v-if="role_item.status === '1'">Open</p>
                                                                <p class="text-warning mb-1" v-else>Lock</p>
                                                            </td>
                                                            <td class="col-2">
                                                                <a>
                                                                    <router-link
                                                                        tag="button"
                                                                        class="btn btn-info"
                                                                        :to="'/roles/edit/' + role_item.id">
                                                                        Edit <i class="fas fa-edit"></i>
                                                                    </router-link>
                                                                </a>
                                                                <button class="btn btn-danger" v-on:click="delete_role(role_item.id)">
                                                                    Delete <i class="fas fa-trash-alt"></i>
                                                                </button> 
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                        <nav aria-label="Page navigation example">                                                 
                                                            <ul class="pagination">
                                                                <li v-bind:class="{'page-item':true,'disabled':paginate.prev == null}"><a class="page-link" v-on:click="load_data_role(paginate.prev)">Previous</a></li>
                                                                <li v-bind:class="{'page-item':true,'active':link.active}" v-for="(link,key) in paginate.links" v-bind:key="key"><a class="page-link" v-on:click="load_data_role(link.url)">{{ link.label }}</a></li>
                                                                <li v-bind:class="{'page-item':true,'disabled':paginate.next == null}"><a class="page-link" v-on:click="load_data_role(paginate.next)">Next</a></li>
                                                            </ul>
                                                         </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- [ basic-table ] end -->
                            </div>
                            <!-- [ Main Content ] end -->
                        </div>
                    </div>
                </div>
</template>
<script>
import axios from "axios"
    export default {
        data(){
            return {
                roles: [],
                role:{
                    id:"",
                    name:"",
                    desc:"",
                    status:""
                },
                paginate:{},
                role_record_number:6,
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

            // fetch data role
            fetch('http://localhost:8000/api/v1/role/index/' +this.role_record_number).then(res => res.json()).then(res => {
                this.roles = res.data;
                var links = res.meta.links;
                links = links.filter(function(item){
                    return item.label != "&laquo; Previous" && item.label != "Next &raquo;";
                })
                this.paginate = {
                    first:res.links.first,
                    last:res.links.last,
                    next:res.links.next,
                    prev:res.links.prev,
                    links:links,
                    current_page:res.meta.current_page,
                    from:res.meta.from,
                    last_page:res.meta.last_page
                }
            })
        },
        methods:{
            load_data_role:function(url){
                if(url != ''){
                    var link = url;
                }else{
                    var link = 'http://localhost:8000/api/v1/role/index/'+this.role_record_number;
                }
                    fetch(link).then(res => res.json()).then(res => {
                    this.roles = res.data;
                    var links = res.meta.links;
                    links = links.filter(function(item,key){
                        return item.label != "&laquo; Previous" && item.label != "Next &raquo;";
                    })
                    this.paginate = {
                        first:res.links.first,
                        last:res.links.last,
                        prev:res.links.prev,
                        next:res.links.next,
                        links:links,
                        current_page:res.meta.current_page,
                        from:res.meta.from,
                        last_page:res.meta.last_page
                    }
                })
            },
            delete_role:function(id){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('http://localhost:8000/api/v1/role/'+id,{headers:{"Authorization" : "Bearer " + this.get_cookie}})
                    .then(res => {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        );
                        this.load_data_role('');
                    })
                   
                }
                })
            }
        }
    }
</script>
<style>

</style>
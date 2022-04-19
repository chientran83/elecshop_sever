<template>
    <div class="pcoded-inner-content" v-if="user">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Slider manager</h5>
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
                                        <li class="breadcrumb-item"><a >Slider list</a></li>
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
                                            <span class="d-block m-t-5">List of slider</span>
                                        </div>
                                        <div class="col-6">
                                            <a>
                                            <router-link 
                                            tag="button"
                                            class="btn btn-success btn-sm"
                                            to="/slider/create">
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
                                                            <th>Image</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(slider,key) in sliders" v-bind:key="key">
                                                            <td class="col-2" > {{ slider.id }} </td>
                                                            <td>{{ slider.name }}</td>
                                                            <td class="d-inline-block text-truncate" style="max-width: 200px;">{{ slider.desc }}</td>
                                                             <td><img v-bind:src="$hostname+'' + slider.image_path" style="width:40px; height:40px;" alt=""></td>
                                                            <td>{{ slider.status }}</td>
                                                            <td class="col-2">
                                                                <a>
                                                                    <router-link
                                                                        tag="button"
                                                                        class="btn btn-info"
                                                                        :to="'/slider/edit/' + slider.id">
                                                                        Edit <i class="fas fa-edit"></i>
                                                                    </router-link>
                                                                </a>
                                                                <button class="btn btn-danger" v-on:click="delete_slider(slider.id)">
                                                                    Delete <i class="fas fa-trash-alt"></i>
                                                                </button> 
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                        <nav aria-label="Page navigation example">                                                 
                                                            <ul class="pagination">
                                                                <li v-bind:class="{'page-item':true,'disabled':paginate.prev == null}"><a class="page-link" v-on:click="load_data_slider(paginate.prev)">Previous</a></li>
                                                                <li v-bind:class="{'page-item':true,'active':link.active}" v-for="(link,key) in paginate.links" v-bind:key="key"><a class="page-link" v-on:click="load_data_slider(link.url)">{{ link.label }}</a></li>
                                                                <li v-bind:class="{'page-item':true,'disabled':paginate.next == null}"><a class="page-link" v-on:click="load_data_slider(paginate.next)">Next</a></li>
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
    import getCookie from '../component/getCookie'
    export default {
        data(){
            return {
                sliders: [],
                slider:{
                    id:"",
                    name:"",
                    desc:""
                },
                paginate:{},
                slider_record_number:6,
                user:null,
                get_cookie:""
            }
        },
        mounted(){
            this.get_cookie = getCookie.getCookie('elecshop_login');
            if(this.get_cookie){
                fetch(this.$hostname+'/api/v1/users/user_login',{headers:{"Authorization" : "Bearer " + this.get_cookie,'Content-Type': 'application/json','Accept': 'application/json'}})
                    .then(res => res.json())
                    .then(res => {
                        if(res.message || res.code == 404){
                            this.$router.push('/sign-in')
                        }else{
                            this.user = res.data
                        }
                    })
                    .then(()=>{
                        // fetch data slider
                        fetch(this.$hostname+'/api/v1/slider/index/'+this.slider_record_number).then(res => res.json()).then(res => {
                            this.sliders = res.data;
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
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }else{
                this.$router.push('/sign-in')

            }
             

          
            
        },
        methods:{
            load_data_slider:function(url){
                if(url != ''){
                    var link = url;
                }else{
                    var link = this.$hostname+'/api/v1/slider/index/'+this.slider_record_number;
                }
                    fetch(link).then(res => res.json()).then(res => {
                    this.slider = res.data;
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
            delete_slider:function(id){
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
                    axios.delete(this.$hostname+'/api/v1/slider/'+id,{headers:{"Authorization" : "Bearer " + this.get_cookie}})
                    .then(res => {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        );
                        this.load_data_slider('');
                    })
                   
                }
                })
            }
        }
    }
</script>
<style>

</style>
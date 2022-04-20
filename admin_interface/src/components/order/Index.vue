<template>
    <div class="pcoded-inner-content" v-if="user">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Order manager</h5>
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
                                        <li class="breadcrumb-item"><a >Order list</a></li>
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
                                <div class="col-xl-12 col-md-12">
                                        <div class="card Recent-Users">
                                            <div class="card-header">
                                                <h5>Order</h5>
                                            </div>
                                            <div class="card-block px-0 py-3">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Image</th>
                                                                <th>Name</th>
                                                                <th>Price</th>
                                                                <th>Date</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr class="unread">
                                                                <td>
                                                                    <h6 class="mb-1">1</h6>
                                                                </td>
                                                                <td><img class="rounded-circle" style="width:40px;" src="datta-able-bootstrap-dashboard-master/template/assets/images/user/avatar-1.jpg" alt="activity-user"></td>
                                                                <td>
                                                                    <h6 class="mb-1">Isabella Christensen</h6>
                                                                    <p class="m-0">Lorem Ipsum is simply…</p>
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-1">500.000 đ</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="text-muted"><i class="fas fa-circle text-c-green f-10 m-r-15"></i>11 MAY 12:56</h6>
                                                                </td>
                                                                <td><a href="#!" class="label theme-bg2 text-white f-12">Reject</a><a href="#!" class="label theme-bg text-white f-12">Approve</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
    import {getApi} from '../component/getApi'
    export default {
        data(){
            return {
                categories: [],
                order:{
                    id:"",
                    name:"",
                    desc:""
                },
                record_number:6,
                paginate:{},
                user:null,
                get_cookie:""
            }
        },
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
            .then(()=>{
                // fetch data order
                getApi(this.$hostname+'/api/v1/order/index/',this.record_number,"")
                    .then(res => {
                        this.categories = res.data;
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
             
        },
        methods:{
            load_data_order:function(url){
                if(url != ''){
                    var link = url;
                }else{
                    var link = this.$hostname+'/api/v1/order/index/' + this.record_number;
                }
                getApi(link,"","")
                  .then(res => {
                    this.categories = res.data;
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
            delete_order:function(id){
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
                    axios.delete(this.$hostname+'/api/v1/order/'+id,{headers:{"Authorization" : "Bearer " + this.get_cookie}})
                    .then(res => {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        );
                        this.load_data_order('');
                    })
                   
                }
                })
            }
        }
    }
</script>
<style>

</style>
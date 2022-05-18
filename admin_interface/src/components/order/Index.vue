<template>
    <div class="pcoded-inner-content" v-if="userLogin">
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
                                            <div class="col-6">
                                                
                                                   <!--  <input type="file" ref="importExcel">
                                                    <button type="button" class="btn btn-outline-warning" v-on:click="importExcel()" >Import excel</button> -->

                                                    <a :href="$hostname+'/api/v1/order/export/excel?sort=' + filter"><button type="button" class="btn btn-outline-secondary" v-on:click="exportExcel()">exportExcel</button></a>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">Filter</label>
                                                    <select class="form-control" id="exampleFormControlSelect1" v-on:change="filterOrder" v-model="filter">
                                                        <option value="all">All order</option>
                                                        <option value="waitAccept">Wait accept</option>
                                                        <option value="productSent">Product sent</option>
                                                        <option value="success">Success delivery</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="card-block px-0 py-3">
                                                <div class="table-responsive">
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th>Id</th>
                                                                <th>Image</th>
                                                                <th>Name</th>
                                                                <th>Product</th>
                                                                <th>Quantity</th>
                                                                <th>Price</th>
                                                                <th>Date</th>
                                                                <th>Method payment</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            <tr class="unread" v-for="(orderItem,key) in orders" v-bind:key="key">
                                                                <td>
                                                                    <h6 class="mb-1">{{orderItem.id}}</h6>
                                                                </td>
                                                                <td v-if="orderItem.deliveryInformation.user != null">
                                                                    <img class="rounded-circle" style="width:40px; height:40px;" :src="$hostname + orderItem.deliveryInformation.user.image_path" alt="activity-user">
                                                                </td>
                                                                <td v-else>
                                                                    <img class="rounded-circle" style="width:40px; height:40px;" src="@/assets/default.jpg" alt="activity-user">
                                                                </td>
                                                                <td>
                                                                    <div v-if="orderItem.deliveryInformation.user != null">
                                                                        <h6 class="mb-1">{{orderItem.deliveryInformation.user.name}}</h6>
                                                                        <p class="m-0">{{orderItem.deliveryInformation.user.phoneNumber}}</p>
                                                                    </div>
                                                                    <div v-else>
                                                                        <h6 class="mb-1">{{orderItem.deliveryInformation.name}}</h6>
                                                                        <p class="m-0">{{orderItem.deliveryInformation.phone}}</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-1">{{orderItem.product.name}}</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-1">{{orderItem.quantity}}</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="mb-1">{{orderItem.price_total}} $</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="text-muted">{{orderItem.date}}</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="text-muted">{{orderItem.method_payment}}</h6>
                                                                </td>
                                                                <td>
                                                                    <h6 class="text-muted" v-if="orderItem.status == 0">
                                                                        <i class="fas fa-circle text-c-yellow f-10 m-r-15"></i>Wait confirm
                                                                    </h6>
                                                                    <h6 class="text-muted" v-if="orderItem.status == 1">
                                                                        <i class="fas fa-circle text-c-purple f-10 m-r-15"></i>Wait get product
                                                                    </h6>
                                                                    <h6 class="text-muted" v-if="orderItem.status == 2">
                                                                        <i class="fas fa-circle text-c-blue f-10 m-r-15"></i>Product has been sent
                                                                    </h6>
                                                                    <h6 class="text-muted" v-if="orderItem.status == 3">
                                                                        <i class="fas fa-circle text-c-green f-10 m-r-15"></i>Success delivery
                                                                    </h6>
                                                                    <h6 class="text-muted" v-if="orderItem.status == 4">
                                                                        <i class="fas fa-circle text-c-red f-10 m-r-15"></i>Order been cancel
                                                                    </h6>
                                                                </td>
                                                                <td>
                                                                    <a class="label theme-bg2 text-white f-12" data-toggle="modal" :data-target="'#exampleModalCenter' + orderItem.id" style="cursor:pointer;">View product detail</a>
                                                                    <a v-if="orderItem.status != 0 && orderItem.status != 4 && orderItem.status != 3" class="label theme-bg text-white f-12" style="cursor:pointer;" v-on:click="changeStatusOrder(orderItem.id)">Change status</a>
                                                                    <a v-if="orderItem.status == 0" class="label theme-bg text-white f-12" style="cursor:pointer;" v-on:click="acceptOrder(orderItem.id)">Approve</a>
                                                                    <a v-if="orderItem.status == 0 || orderItem.status == 4" class="label text-white f-12" style="background: rgb(238,174,202);background: linear-gradient(40deg, rgba(238,174,202,1) 0%, rgba(148,187,233,1) 100%); cursor:pointer;" v-on:click="rejectOrder(orderItem.id)">Reject</a>
                                                                </td>

                                                                <!-- Modal -->
                                                                <div class="modal fade" :id="'exampleModalCenter'+ orderItem.id" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLongTitle">View product detail</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <span class="title-red">Name product: </span><h1>{{orderItem.product.name}}</h1>
                                                                        <p><span class="title-red">Quantity: </span> {{orderItem.quantity}}</p>
                                                                        <p><span class="title-red">Product Image: </span> <img :src="$hostname + orderItem.product.image_path" style="width:100px;"></p>
                                                                        <p v-if="orderItem.color"><span class="title-red">Name color: </span> {{orderItem.color.name}} - <span class="title-red">Price flus: </span> {{orderItem.color.price}}</p>
                                                                        <p v-if="orderItem.tag"><span class="title-red">Name tag: </span> {{orderItem.tag.name}} - <span class="title-red">Price flus: </span> {{orderItem.tag.price}}</p>
                                                                        <p v-if="orderItem.memory"><span class="title-red">Name memory: </span> {{orderItem.memory.name}} - <span class="title-red">Price flus: </span> {{orderItem.memory.price}}</p>
                                            
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                                </div>
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
    import {getApi} from '../component/getApi'
    export default {
        props:['userLogin'],
        data(){
            return {
                orders: [],
                order:{
                    id:"",
                    name:"",
                    desc:""
                },
                record_number:0,
                paginate:{},
                filter:""
            }
        },
        mounted(){
            this.filter = 'all';
            this.load_data_order('',this.filter);
        },
        methods:{
            load_data_order:function(url,sort){
                if(url != ''){
                    var link = url;
                }else{
                    var link = 'api/v1/order/indexForAdmin/' + this.record_number;
                }
                getApi(link,"?sort="+sort)
                // getApi(link,"")
                  .then(res => {
                    this.orders = res.data;
                })
            },
            rejectOrder:function(id){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(this.$hostname+'/api/v1/order/rejectOrder/'+id,{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then(res => {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        );
                        this.load_data_order('',this.filter);
                    })
                   
                }
                })
            },
            acceptOrder:function(id){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, accept it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(this.$hostname+'/api/v1/order/acceptOrder',{'id' : id},{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then(res => {
                        Swal.fire(
                        'Accept!',
                        'Your file has accept order.',
                        'success'
                        );
                       this.load_data_order('',this.filter);;
                    })
                   
                }
                })
            },
            changeStatusOrder:function(id){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change status!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.post(this.$hostname+'/api/v1/order/changeStatusOrder',{'id' : id},{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then(res => {
                        Swal.fire(
                        'Change!',
                        'Your file has change status order.',
                        'success'
                        );
                        this.load_data_order('',this.filter);
                    })
                   
                }
                })
            },
            filterOrder:function(){
                this.load_data_order('',this.filter);
            },
            exportExcel:function(){
                axios.get(this.$hostname + '/api/v1/order/export/excel?sort='+this.filter,{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then(res => {
                        console.log('oke')
                    })
                    .catch(function(error){ console.log(error);})
            },
            
            importExcel:function(){
                // console.log(this.$refs.importExcel.files[0]);
                var formData = new FormData();
                formData.append('file',this.$refs.importExcel.files[0]);
                axios.post(this.$hostname + '/api/v1/order/import/excel',formData,{headers:{ "Authorization" : "Bearer " + this.userLogin.token,'Content-Type': 'multipart/form-data'}})
                    .then(res => {
                        console.log(res)
                    })
                    .catch(function(error){ console.log(error);})
            }
        }
    }
</script>
<style>
    .title-red {
        color: red;
    }
</style>
<template>
    <div class="pcoded-inner-content" v-if="userLogin">
                    <!-- [ breadcrumb ] start -->
                    <div class="page-header">
                        <div class="page-block">
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <div class="page-header-title">
                                        <h5 class="m-b-10">Coupon manager</h5>
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
                                        <li class="breadcrumb-item"><a >Coupon list</a></li>
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
                                            <span class="d-block m-t-5">List of coupon</span>
                                        </div>
                                        <div class="col-6">
                                            <a>
                                            <router-link 
                                            tag="button"
                                            class="btn btn-success btn-sm"
                                            to="/coupon/create">
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
                                                            <th>Code</th>
                                                            <th>Expire</th>
                                                            <th>Type</th>
                                                            <th>Value</th>
                                                            <th>quantity</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(coupon,key) in coupons" v-bind:key="key">
                                                            <td class="col-2" > {{ coupon.id }} </td>
                                                            <td>{{ coupon.code }}</td>
                                                            <td>{{ coupon.expire }}</td>
                                                            <td>{{ coupon.type }}</td>
                                                            <td v-if="coupon.value == 'percent'">{{ coupon.value }} %</td>
                                                            <td v-else>{{ coupon.value }} $</td>
                                                            <td>{{ coupon.quantity }}</td>
                                                            <td class="col-2">
                                                                <a>
                                                                    <router-link
                                                                        tag="button"
                                                                        class="btn btn-info"
                                                                        :to="'/coupon/edit/' + coupon.id">
                                                                        Edit <i class="fas fa-edit"></i>
                                                                    </router-link>
                                                                </a>
                                                                <button class="btn btn-danger" v-on:click="delete_coupon(coupon.id)">
                                                                    Delete <i class="fas fa-trash-alt"></i>
                                                                </button> 
                                                                
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                    <nav aria-label="Page navigation example">                                        
                                                        <ul class="pagination">
                                                            <li v-bind:class="{'page-item':true,'disabled':paginate.prev == null}"><a class="page-link" v-on:click="load_data_coupon(paginate.prev)">Previous</a></li>
                                                            <li v-bind:class="{'page-item':true,'active':link.active}" v-for="(link,key) in paginate.links" v-bind:key="key"><a class="page-link" v-on:click="load_data_coupon(link.url)">{{ link.label }}</a></li>
                                                            <li v-bind:class="{'page-item':true,'disabled':paginate.next == null}"><a class="page-link" v-on:click="load_data_coupon(paginate.next)">Next</a></li>
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
import {getApi} from '../component/getApi'
    export default {
        props:['userLogin'],
        data(){
            return {
                coupons: [],
                coupon:{
                    id:"",
                    name:"",
                    desc:""
                },
                record_number:6,
                paginate:{}
            }
        },
        mounted(){
            
            getApi('api/v1/coupon/index/',this.record_number,this.userLogin.token)
                .then(res => {
                    this.coupons = res.data;
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
            .catch(err => {
                console.log(err)
            })
           
        },
        methods:{
            load_data_coupon:function(url){
                if(url != ''){
                    var link = url;
                }else{
                    var link = this.$hostname+'/api/v1/coupon/index/' + this.record_number;
                }
                 getApi(link,"")
                    .then(res => {
                        this.coupons = res.data;
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
            delete_coupon:function(id){
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
                    axios.delete(this.$hostname+'/api/v1/coupon/'+id,{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then(res => {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        );

                        this.load_data_coupon('');
                    })
                   
                }
                })
            }
        }
    }
</script>
<style>

</style>
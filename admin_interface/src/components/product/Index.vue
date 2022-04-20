<template>
     <div class="pcoded-inner-content" v-if="user">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Product manager</h5>
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
                            <li class="breadcrumb-item"><a >Product list</a></li>
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
                                <span class="d-block m-t-5">List of product</span>
                            </div>
                            <div class="col-6">
                                <a>
                                <router-link 
                                tag="button"
                                class="btn btn-success btn-sm"
                                to="/product/create">
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
                                                <th>Current Price</th>
                                                <th>previous Price</th>
                                                <th>Origin Price</th>
                                                <th>Image</th>
                                                <th>isOnSale</th>
                                                <th>Quantity</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(product,key) in products" v-bind:key="key">
                                                <td class="col-2" > {{ product.id }} </td>
                                                <td>{{product.name}}</td>
                                                <td>{{product.current_price}}</td>
                                                <td>{{product.previous_price}}</td>
                                                <td>{{product.origin_price}}</td>
                                                <td><img v-bind:src="$hostname+'' + product.image_path" style="width:40px; height:40px;" alt=""></td>
                                                <td>{{ product.isOnSale }}</td>
                                                <td>{{product.quantity}}</td>
                                                <td class="col-2">
                                                    <a>
                                                        <router-link
                                                            tag="button"
                                                            class="btn btn-info"
                                                            :to="'product/edit/'+product.id">
                                                            Edit <i class="fas fa-edit"></i>
                                                        </router-link>
                                                    </a>
                                                    <button class="btn btn-danger" v-on:click="delete_product(product.id)">
                                                        Delete <i class="fas fa-trash-alt"></i>
                                                    </button> 
                                                    
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                        <nav aria-label="Page navigation example">                                                
                                            <ul class="pagination">
                                                <li v-bind:class="{'page-item':true,'disabled':paginate.prev == null}"><a class="page-link" v-on:click="load_data_product(paginate.prev)">Previous</a></li>
                                                <li v-bind:class="{'page-item':true}" v-for="(page,key) in paginate.link_page" v-bind:key="key"><a class="page-link" v-on:click="load_data_product(page.url)" >{{page.label}}</a></li>
                                                <li v-bind:class="{'page-item':true,'disabled':paginate.next == null}"><a class="page-link" v-on:click="load_data_product(paginate.next)">Next</a></li>
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
import axios from 'axios';
    import getCookie from '../component/getCookie'
    import {getApi} from '../component/getApi'
export default {
    data(){
        return {
            products:[],
            product: {
                id:"",
                name:"",
                current_price: "",
                previous_price: "",
                origin_price:"",
                image_path:"",
                ram:"",
                isOnSale:"",
                desc:"",
                quantity:"",
                user_id:""
            },
            paginate:{},
            user:null,
            product_record_number:6,
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
                getApi(this.$hostname+'/api/v1/product/index/',this.product_record_number,"")
                    .then(res => {
                        this.products = res.data;
                        var link_page = res.meta.links.filter(function(index){
                            return index.label != "&laquo; Previous" && index.label != "Next &raquo;";
                        })
                        this.paginate = {
                            first:res.links.first,
                            last:res.links.last,
                            prev:res.links.prev,
                            next:res.links.next,
                            link_page:link_page,
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
            load_data_product:function(url){
                if(url == ''){
                    var link = this.$hostname+'/api/v1/product/index/' + this.product_record_number;
                }else{
                    var link = url
                }
                getApi(link,"","")
                    .then(res => {
                        this.products = res.data;
                        var link_page = res.meta.links.filter(function(index){
                            return index.label != "&laquo; Previous" && index.label != "Next &raquo;";
                        })
                        this.paginate = {
                            first:res.links.first,
                            last:res.links.last,
                            prev:res.links.prev,
                            next:res.links.next,
                            link_page:link_page,
                            current_page:res.meta.current_page,
                            from:res.meta.from,
                            last_page:res.meta.last_page
                        }
                    })
            },
            delete_product:function(id){
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
                    axios.delete(this.$hostname+'/api/v1/product/'+id,{headers:{"Authorization" : "Bearer " + this.get_cookie}})
                    .then(res => {
                        Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                        );
                        this.load_data_product('');
                    })
                   
                }
                })
            }
        }
}
</script>
<style>
</style>
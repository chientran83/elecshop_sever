<template>
    <div class="pcoded-inner-content" v-if="userLogin">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">coupon manager</h5>
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
                                <h5>Edit coupon</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div>
                                            <div class="form-group">
                                                <label>Code</label>
                                                <input type="text" class="form-control" placeholder="Enter code" v-model="coupon.code">
                                            </div>
                                             <div class="form-group">
                                                <label for="exampleFormControlSelect1">Type</label>
                                                <select class="form-control" id="exampleFormControlSelect1" v-model="coupon.type">
                                                    <option value="percent">Percent</option>
                                                    <option value="number">Number</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Value</label>
                                                <input type="number" class="form-control" placeholder="Enter value" v-model="coupon.value">
                                            </div>

                                            <div class="form-group">
                                                <label>Expire</label>
                                                <br>
                                               <input type="text" id="datepicker" class="datepicker" autocomplete="off">
                                            </div>
                                             <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" placeholder="Enter quantity" v-model="coupon.quantity">
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/coupon">Thoát</router-link>

                                            </a>
                                            <button class="btn btn-primary" v-on:click="update_coupon()">Submit</button>
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
import axios from 'axios';
import {getApi} from '../component/getApi'
    export default {
        props:['userLogin'],
        data(){
            return {
                coupon:{
                    code:"",
                    type:"percent",
                    value:"",
                    quantity:0
                }
            }
        },
        mounted(){
            $( "#datepicker" ).datepicker();
            $( "#datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
            getApi('api/v1/coupon/',this.$route.params.id)
                .then(res => {
                    this.coupon.code = res.data.code,
                    this.coupon.type = res.data.type;
                    this.coupon.value = res.data.value;
                    this.coupon.quantity = res.data.quantity;
                    $("#datepicker" ).val(res.data.expire);
            })
        
            .catch(err => {
                console.log(err)
            })
            
                
        },
        methods:{
            update_coupon:function(){
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
                    axios.put(this.$hostname+'/api/v1/coupon/'+this.$route.params.id,{
                        code:this.coupon.code,
                        type:this.coupon.type,
                        value:this.coupon.value,
                        quantity:this.coupon.quantity,
                        expire: $("#datepicker" ).val()
                        },{headers:{"Authorization" : "Bearer " + this.userLogin.token}})
                    .then(res => {
                         Swal.fire(
                        'Updated!',
                        'New coupon has been updated.',
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
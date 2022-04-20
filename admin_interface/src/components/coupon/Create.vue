<template>
    <div class="pcoded-inner-content" v-if="user">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Coupon manager</h5>
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
                                            <button class="btn btn-primary" v-on:click="coupon_store()">Submit</button>
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
    import getCookie from '../component/getCookie'
    export default {
        data(){
            return {
                coupon:{
                    code:"",
                    type:"percent",
                    value:"",
                    quantity:0
                },
                user:null,
                get_cookie:""
            }
        },
        mounted(){
            this.get_cookie = getCookie.getCookie('elecshop_login');
            if(this.get_cookie){
                  getApi(this.$hostname+'/api/v1/coupon/',this.$route.params.id,"")
                    .then(res => {
                        if(res.message || res.code == 404){
                            this.$router.push('/sign-in')
                        }else{
                            this.user = res.data
                        }
                    })
                    .then(()=>{
                        $( "#datepicker" ).datepicker();
                        $( "#datepicker" ).datepicker("option", "dateFormat",'yy-mm-dd');
                    })
                    .catch(err => {
                        console.log(err)
                    })
            }else{
                this.$router.push('/sign-in')

            }

        },
        methods:{
            coupon_store:function(){
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
                    form_data.append('expire', $("#datepicker" ).val());
                    form_data.append('code',this.coupon.code);
                    form_data.append('type',this.coupon.type);
                    form_data.append('value',this.coupon.value);
                    form_data.append('quantity',this.coupon.quantity);
                    axios.post(this.$hostname+'/api/v1/coupon',form_data,{headers:{"Authorization" : "Bearer " + this.get_cookie}}).then(res => {
                        this.coupon.code = "";
                        this.coupon.value = 0;
                        this.coupon.quantity = 0;
                        Swal.fire(
                        'Added new!',
                        'New coupon has been added.',
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
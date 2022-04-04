<template>
    <div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">slider manager</h5>
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
                                <h5>Edit slider</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-10">
                                         <form>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="slider.name">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Desc</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter desc" v-model="slider.desc"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Status</label>
                                                <select class="form-control" id="exampleFormControlSelect1" v-model="slider.status">
                                                    <option value="0">Hidden</option>
                                                    <option value="1">Display</option>
                                                </select>
                                            </div>
                                             <div class="form-group">
                                                <label>Image</label>
                                                <input type="file" class="form-control" id="imgInp" v-on:change="preview_image()">
                                                <img :src="'http://localhost:8000' + slider.image_path" alt="default.jpg" id="output" class="img-thumbnail" style="width:250px;height:250px;">
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/slider">Thoát</router-link>

                                            </a>
                                            <button class="btn btn-primary" v-on:click="update_slider()">Submit</button>
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
                slider:{
                    name:"",
                    desc:"",
                    status:"",
                    image_path:""
                }
            }
        },
        mounted(){
            fetch('http://localhost:8000/api/v1/slider/' + this.$route.params.id)
                .then(res => res.json())
                .then(res => {
                    this.slider.name = res.data.name,
                    this.slider.desc = res.data.desc
                    this.slider.status = res.data.status
                    this.slider.image_path = res.data.image_path
                })
        },
        methods:{
            update_slider:function(){
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
                    form_data.append('name',this.slider.name);
                    form_data.append('desc',this.slider.desc);
                    form_data.append('status',this.slider.status);
                    form_data.append('image',document.getElementById('imgInp').files[0]);
                    form_data.append('_method',"PUT");
                    axios.post('http://localhost:8000/api/v1/slider/'+this.$route.params.id,form_data,{
                        headers:{
                            'Content-Type' : 'multipart/form-data'
                        }
                    })
                    .then(res => {
                         Swal.fire(
                        'Updated!',
                        'New slider has been updated.',
                        'success'
                        )
                    })
                   
                }
                })
            }
            ,
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
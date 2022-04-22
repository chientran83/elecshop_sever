<template>
    <div class="pcoded-inner-content" v-if="userLogin">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Role manager</h5>
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
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="role.name">
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Desc</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Enter desc" v-model="role.desc"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Status</label>
                                                <select class="form-control" id="exampleFormControlSelect1" v-model="role.status">
                                                    <option value="1">Open</option>
                                                    <option value="0">Lock</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Select permission</label>
                                                <div class="card">
                                                    <div class="card-header" style="background-color:rgb(206 204 204);">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" v-model="allSelected" id="exampleCheck1" v-on:change="selectAll()">
                                                            <label class="form-check-label" for="exampleCheck1">Choose all permission</label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card" v-for="(resource,key) in resources" v-bind:key="key">
                                                    <div class="card-header" style="background-color:rgb(119 119 119 / 11%);">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" v-model="resource.checked" v-on:change="selectAllResource(resource)">
                                                            <label class="form-check-label" for="exampleCheck1">{{resource.alias}}</label>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="form-check col" v-for="(permission,key) in resource.permissionsDefaults" v-bind:key="key">
                                                                <input type="checkbox" class="form-check-input" v-model="selected" v-bind:value="permission.id">
                                                                <label class="form-check-label" for="exampleCheck1">{{ permission.allow }}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/roles">Thoát</router-link>

                                            </a>
                                            <button class="btn btn-primary" v-on:click="role_store()">Submit</button>
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
    import {getApi} from '../component/getApi'
    export default {
        props:['userLogin'],
        data(){
            return {
                role:{
                    name:"",
                    desc:"",
                    status:1
                },
                resources:[],
                selected:[],
                allSelected:false
            }
        },
        mounted(){
            getApi(this.$hostname+'/api/v1/resource/index',0)
                .then(res => {
                    res.data.forEach(item => {
                    this.resources.push({
                            id:item.id,
                            alias:item.alias,
                            permissions:item.permissions,
                            permissionsDefaults:item.permissionsDefaults,
                            checked:false
                    }) 
                    })
                })
            
                .catch(err => {
                    console.log(err)
                })
        },
        methods:{
            role_store:function(){
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
                    form_data.append('name',this.role.name);
                    form_data.append('desc',this.role.desc);
                    form_data.append('status',this.role.status);
                    form_data.append('permissions',JSON.stringify(this.selected));
                    axios.post(this.$hostname+'/api/v1/role',form_data,{headers:{"Authorization" : "Bearer " + this.userLogin.token}}).then(res => {
                        this.role.name = "";
                        this.role.desc = "";
                        this.role.status = "";
                        Swal.fire(
                        'Added new!',
                        'New role has been added.',
                        'success'
                        )
                    })
                   
                }
                })
               
            },
            selectAll:function(){
                if(this.allSelected){
                    this.selected=[];
                    this.resources.forEach(itemResource => {
                        itemResource.permissionsDefaults.forEach(itemPermission => {
                            this.selected.push(itemPermission.id)
                        })
                    })
                }else{
                    this.selected=[];
                }
            },
            selectAllResource:function(resource){
                if(resource.checked){
                    resource.permissionsDefaults.forEach(itemPermission => {
                        if(!this.selected.includes(itemPermission.id)){
                            this.selected.push(itemPermission.id);
                        }
                    })
                }else{
                    this.selected = this.selected.filter(itemSelected => {
                        var result = true;
                        resource.permissionsDefaults.forEach((itemPermission) => {
                           if(itemPermission.id == itemSelected){
                               result = false;
                           }
                        })
                        return result;
                    })
                }
            }
        }
    }
</script>
<style>

</style>
<template>
    <div class="pcoded-inner-content" v-if="userLogin">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Resource manager</h5>
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
                                                <label>Resource name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="resource.alias">
                                            </div>
                                            <div class="form-group">
                                                <label class="typo__label">Permission</label>
                                                <multiselect v-model="resource.permissions" tag-placeholder="Add this as new tag" placeholder="Choose permissions" label="name" track-by="code" :options="permissionOptions" :multiple="true" :taggable="true" @tag="addPermission"></multiselect>
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/permission">Thoát</router-link>

                                            </a>
                                            <button class="btn btn-primary" v-on:click="resource_store()">Submit</button>
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
    import Multiselect from 'vue-multiselect'
    export default {
        components: {
            Multiselect
        },
        props:['userLogin'],
        data(){
            return {
                resource:{
                    alias:"",
                    permissions:[]
                },
                permissionOptions: [
                    { name: 'add', code: 'add' },
                    { name: 'edit', code: 'edit' },
                    { name: 'delete', code: 'delete' },
                    { name: 'index', code: 'index' },
                    { name: 'show', code: 'show' },
                ]
            }
        },
        mounted(){
            
        },
        methods:{
            resource_store:function(){
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
                    form_data.append('alias',this.resource.alias);
                    form_data.append('permissions',JSON.stringify(this.resource.permissions));
                    axios.post(this.$hostname+'/api/v1/resource',form_data,{headers:{"Authorization" : "Bearer " + this.userLogin.token}}).then(res => {
                        this.resource.alias = "";
                        this.resource.permissions = [];
                        Swal.fire(
                            'Added new!',
                            'New resource has been added.',
                            'success'
                        )
                    })
                   
                }
                })
            },
            addPermission (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.permissionOptions.push(tag)
                this.resource.permissions.push(tag)
            }
        }
    }
</script>
<style>

</style>
<template>
<div class="pcoded-inner-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">product manager</h5>
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
                                    <div class="col-md-12">
                                        <form>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" placeholder="Enter name" v-model="product.name">
                                            </div>
                                             <div class="form-group">
                                                <label>OriginPrice</label>
                                                <input type="number" class="form-control" placeholder="Enter name" v-model="product.origin_price">
                                            </div>
                                             <div class="form-group">
                                                <label>Current_price</label>
                                                <input type="number" class="form-control" placeholder="Enter name" v-model="product.current_price">
                                            </div>
                                             <div class="form-group">
                                                <label>PreviousPrice</label>
                                                <input type="number" class="form-control" placeholder="Enter name" v-model="product.previous_price">
                                            </div>
                                             <div class="form-group">
                                                <label>Quantity</label>
                                                <input type="number" class="form-control" placeholder="Enter name" v-model="product.quantity">
                                            </div>
                                             <div class="form-group">
                                                <label>isOnsale</label>
                                                <select class="form-control" id="exampleFormControlSelect1" v-model="product.isOnsale">
                                                    <option value="0">False</option>
                                                    <option value="1" selected>True</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                            <label for="exampleFormControlTextarea1">Desc</label>
                                            <textarea class="form-control" id="editor1" rows="3" placeholder="Enter desc" v-model="product.desc"></textarea>
                                            </div>
                                             <div class="form-group">
                                                <label>Ram</label>
                                                <input type="number" class="form-control" placeholder="Enter name" v-model="product.ram">
                                            </div>
                                             <div class="form-group">
                                                <label>Tag</label>
                                                <div>
                                                    <label class="typo__label">Tagging</label>
                                                    <multiselect v-model="value" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="options" :multiple="true" :taggable="true" @tag="addTag"></multiselect>
                                                    <pre class="language-json"><code>{{ value  }}</code></pre>
                                                </div>
                                            </div>
                                            
                                             <div class="form-group">
                                                <label>Memory</label>
                                                <select class="form-control js-example-basic-single-color" multiple="multiple" id="memory" v-on:change="get_value_input_multiple('memory')">
                                                </select>
                                            </div>
                                             <div class="form-group">
                                                <label>Colors</label>
                                                <select class="form-control js-example-basic-single-color" multiple="multiple" id="colors" v-on:change="get_value_input_multiple('colors')">
                                                </select>
                                            </div>
                                                
                                             <div class="form-group">
                                                <label>categoryID</label>
                                                <select class="form-control js-example-basic-single-category" v-model="product.category_id">
                                                    <option v-for="(category,key) in categories" v-bind:key="key">{{category.name}}</option>
                                                </select>
                                            </div>
                                             <div class="form-group">
                                                <label>MainImage</label>
                                                <input type="file" class="form-control" id="imgInp" v-on:change="preview_image()">
                                                <img src="@/assets/default.jpg" alt="default.jpg" id="blah" class="img-thumbnail" style="width:250px;height:250px;">
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/product">Thoát</router-link>
                                            </a>
                                            <button class="btn btn-primary" v-on:click="product_store()">Submit</button>
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
        <h1>{{ product.tags  }}</h1>
        <h1>{{ product.colors  }}</h1>
        <h1>{{ product.memory  }}</h1>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
    export default {
         components:{
            Multiselect
        },
        data(){
            return {
                product:{
                    name:"",
                    origin_price:"",
                    previous_price:"",
                    current_price: "",
                    ram:"",
                    isOnsale:"",
                    desc:"",
                    quantity:"",
                    user_id:"",
                    tags:['a','b'],
                    colors:[],
                    memory:[],
                    category_id:""
                },
                categories:[],
                 value: [
                    { name: 'Javascript', code: 'js' }
                ],
                options: [
                    { name: 'Vue.js', code: 'vu' },
                    { name: 'Javascript', code: 'js' },
                    { name: 'Open Source', code: 'os' }
                ]
            }
        },
        mounted(){
            CKEDITOR.replace( 'editor1' );
            fetch('http://localhost:8000/api/v1/category').then(res => res.json()).then(res => {
                this.categories = res.data
            })
            
            /* $(document).change('#tags',function(){
                value_tags = $("#tags").val();
                console.log(this.product.tags)
                
            }) */


            /* var colors = document.getElementById("colors");
            colors.change = function(){
                this.get_value_input_multiple("colors");
            }
            var memory = document.getElementById("memory");
            memory.change = function(){
                this.get_value_input_multiple("memory");
            } */
        },
        
        methods:{
            addTag (newTag) {
                const tag = {
                    name: newTag,
                    code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.options.push(tag)
                this.value.push(tag)
            },
            product_store:function(){
                var FormData = new FormData();
                /* FormData.append('name',this.product.name);
                FormData.append('origin_price',this.product.origin_price);
                FormData.append('previous_price',this.product.previous_price);
                FormData.append('current_price',this.product.current_price);
                FormData.append('image',document.getElementById('imgInp').files[0]);
                FormData.append('ram',this.product.ram);
                FormData.append('isOnsale',this.product.isOnsale);
                FormData.append('desc',this.product.desc);
                FormData.append('quantity',this.product.quantity);
                FormData.append('user_id',1);
                FormData.append('tags',this.product.tags);
                FormData.append('colors',this.product.colors);
                FormData.append('memory',this.product.memory);
                FormData.append('category_id',this.product.category_id);
                console.log(FormData) */
            },
            preview_image:function(){
                const [file] = imgInp.files
                if (file) {
                    blah.src = URL.createObjectURL(file)
                }
            }
        }
    }
</script>
<style>
</style>
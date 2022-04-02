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
                                <h5>Update <i class="fas fa-edit"></i></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form v-on:submit.prevent="product_store()">
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
                                                <select class="form-control isOnsale" id="exampleFormControlSelect1" v-on:change="set_isOnsale($event)">
                                                    <option value="0" :selected="product.isOnsale == 0">False</option>
                                                    <option value="1" :selected="product.isOnsale == 1">True</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Desc</label>
                                                <ckeditor v-model="product.desc"></ckeditor>
                                                </div>
                                             <div class="form-group">
                                                <label>Ram</label>
                                                <input type="number" class="form-control" placeholder="Enter name" v-model="product.ram">
                                            </div>
                                             <div class="form-group">
                                                <label class="typo__label">Tags</label>
                                                <multiselect v-model="product.tags" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="optionsTags" :multiple="true" :taggable="true" @tag="addTags"></multiselect>                                     
                                            </div>
                                             <div class="form-group" v-if="product.tags != ''">
                                                <label class="typo__label ">Enter price for each tag</label>
                                                <div class="input-group mb-3" v-for="(tag,key) in product.tags" v-bind:key="key">
                                                    <div class="input-group-prepend bg-warning">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">{{tag.name}}</span>
                                                    </div>
                                                    <input type="number" v-model="product.tags[key].pivot.price" v-bind:id="'priceTags' + key" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" v-on:keyup="priceTag(tag,key)" placeholder="Enter price" >
                                                </div>                                               
                                            </div>
                                             <div class="form-group">
                                                <label class="typo__label">Memory</label>
                                                <multiselect v-model="product.memory" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="optionsMemory" :multiple="true" :taggable="true" @tag="addMemory"></multiselect>
                                            </div>
                                              <div class="form-group" v-if="product.memory != ''">
                                                <label class="typo__label">Enter price for each memory</label>
                                                <div class="input-group mb-3" v-for="(memory,key) in product.memory" v-bind:key="key">
                                                    <div class="input-group-prepend bg-success">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">{{memory.name}}</span>
                                                    </div>
                                                    <input type="number" v-model="product.memory[key].pivot.price" v-bind:id="'priceMemory' + key" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" v-on:keyup="priceMemory(memory,key)" placeholder="Enter price">
                                                </div>                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="typo__label">Colors</label>
                                                <multiselect v-model="product.colors" tag-placeholder="Add this as new tag" placeholder="Search or add a tag" label="name" track-by="code" :options="optionsColors" :multiple="true" :taggable="true" @tag="addColors" ></multiselect>                                                
                                            </div> 
                                              <div class="form-group" v-if="product.colors != ''">
                                                <label class="typo__label">Enter price for each color</label>
                                                <div class="input-group mb-3" v-for="(color,key) in product.colors" v-bind:key="key">
                                                    <div class="input-group-prepend bg-primary">
                                                        <span class="input-group-text" id="inputGroup-sizing-default">{{color.name}}</span>
                                                    </div>
                                                    <input type="number" v-model="product.colors[key].price" v-bind:id="'priceColors' + key" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" v-on:keyup="priceColor(color,key)" placeholder="Enter price">
                                                    <input type="text" v-model="product.colors[key].code" v-bind:id="'codeColors' + key" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" v-on:keyup="priceColor(color,key)" placeholder="Enter code">
                                                    <div class="form-control">
                                                        <img :src="'http://localhost:8000'+product.colors[key].image.image_path" alt="default.jpg" :id="'image_preview_colors' + key" class="col-3" style="height:100%;">
                                                        <input type="file" class="col-8" v-bind:id="'imageColors' + key"  v-on:change="priceColor(color,key); preview_image_color(color,key);">
                                                    </div>
                                                </div>                                           
                                            </div>
                                             <div class="form-group">
                                                <label class="typo__label">Category</label>
                                                <multiselect v-model="product.category_id" :options="categories" placeholder="Select one" label="name" track-by="name">
                                                </multiselect>
                                            </div>
                                             <div class="form-group">
                                               <label class="typo__label">Select accessories</label>
                                               <multiselect v-model="product.accessories" :options="optionsAccessories" :multiple="true" group-values="libs" group-label="language" :group-select="true" placeholder="Select accessories" track-by="name" label="name"><span slot="noResult">Oops! No elements found. Consider changing the search query.</span></multiselect>
                                            </div>
                                             <div class="form-group">
                                                
                                            </div>
                                             <div class="form-group">
                                                <label>MainImage</label>
                                                <input type="file" class="form-control" id="imgInp" v-on:change="preview_image()">
                                                <img v-bind:src="'http://localhost:8000' + product.image_path" alt="default.jpg" id="blah" class="img-thumbnail" style="width:250px;height:250px;">
                                            </div>
                                            <a>
                                            <router-link
                                            tag="button"
                                            class="btn btn-secondary"
                                            to="/product">Thoát</router-link>
                                            </a>
                                            <button class="btn btn-primary" type="submit">Submit</button>
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
import Vue from 'vue';
import CKEditor from 'ckeditor4-vue';
import axios from 'axios';
import Multiselect from 'vue-multiselect'

Vue.use( CKEditor );
    export default {
        components: {
            Multiselect
        },
        data(){
            return {
                optionsTags: [
                    
                ],
                optionsMemory: [
                    
                ],
                optionsColors: [
                    
                ],
                optionsCategory: [
                    
                ],
                optionsAccessories: [{
                    language: 'Choose all',
                    libs: []
                }],
                product_id: "",
                product:{
                    id:"",
                    name:"",
                    origin_price:"",
                    previous_price:"",
                    current_price: "",
                    ram:"",
                    isOnsale:"",
                    desc:"",
                    quantity:"",
                    user_id:"",
                    tags:[],
                    colors:[],
                    memory:[],
                    accessories:[],
                    category_id:"",
                    image_path:""
                },
                categories:[],
            }
        },
        mounted(){
            this.product_id = this.$route.params.id
            fetch('http://localhost:8000/api/v1/category').then(res => res.json()).then(res => {
                this.categories = res.data
            })
            fetch('http://localhost:8000/api/v1/product/'+this.product_id).then(res => res.json()).then(res => {
                 fetch('http://localhost:8000/api/v1/category/'+res.data.category_id).then(res => res.json()).then(res => {
                    this.product.category_id = {
                        "id": res.data.id,
                        "name": res.data.name
                    };
                })
                this.product.tags = res.data.tags;
                this.product.colors=res.data.colors;
                this.product.memory=res.data.memory;
                this.product.accessories=res.data.accessories;
                this.product.id=res.data.id;
                this.product.name=res.data.name;
                this.product.origin_price=res.data.origin_price;
                this.product.previous_price=res.data.previous_price;
                this.product.current_price= res.data.current_price;
                this.product.ram=res.data.ram;
                this.product.isOnsale=res.data.isOnSale;
                this.product.desc=res.data.desc;
                this.product.quantity=res.data.quantity;
                this.product.image_path=res.data.image_path;
            })
            fetch('http://localhost:8000/api/v1/product').then(res => res.json()).then(res => {
                var product_id = this.product.id;
                var accessories = res.data.filter(function(index,key){
                    return index.id != product_id
                })
                this.optionsAccessories[0].libs = accessories;
            })
        },
        
        methods:{
            // add price when keyup
            priceTag:function(tag,key){
                var price = document.getElementById('priceTags' + key).value
                var obj = {
                    name: tag.name,
                    price: price
                }
                this.product.tags[key] = obj;
            },
            priceColor:function(color,key){
                var price = 0;
                var code = 0;
                price = document.getElementById('priceColors' + key).value
                code = document.getElementById('codeColors' + key).value
                var obj = {
                    name: color.name,
                    price: price,
                    code:code
                }
                this.product.colors[key] = obj;
            },
            priceMemory:function(memory,key){
                var price = document.getElementById('priceMemory' + key).value
                var obj = {
                    name: memory.name,
                    price: price
                }
                this.product.memory[key] = obj;
            },
            priceTag:function(tag,key){
                var price = document.getElementById('priceTags' + key).value
                var obj = {
                    name: tag.name,
                    price: price
                }
                this.product.tags[key] = obj;
            },
            // add tags,memory,color
            addTags (newTag) {
            const tag = {
                name: newTag,
                price:0
            }
            this.optionsTags.push(tag)
            this.product.tags.push(tag)
            },
            addMemory (newMemory) {
            const tag = {
                name: newMemory,
                price:0
            }
            this.optionsMemory.push(tag)
            this.product.memory.push(tag)
            },
            addColors (newColors) {
            const tag = {
                name: newColors,
                price:0,
                code:'null'
            }
            this.optionsColors.push(tag)
            this.product.colors.push(tag)
            },
            // store product
            product_store:function(){
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
                        console.log(this.product.isOnsale)
                        var formData = new FormData();
                        formData.append('name',this.product.name);
                        formData.append('origin_price',this.product.origin_price);
                        formData.append('previous_price',this.product.previous_price);
                        formData.append('current_price',this.product.current_price);
                        formData.append('image',document.getElementById('imgInp').files[0]);
                        formData.append('ram',this.product.ram);
                        formData.append('isOnsale',this.product.isOnsale);
                        formData.append('desc',this.product.desc);
                        formData.append('quantity',this.product.quantity);
                        formData.append('tags', JSON.stringify(this.product.tags));
                        formData.append('colors',JSON.stringify(this.product.colors));
                        formData.append('memory',JSON.stringify(this.product.memory));
                        formData.append('accessories',JSON.stringify(this.product.accessories));
                        formData.append('category_id',JSON.stringify(this.product.category_id));
                        /* axios.post('http://localhost:8000/api/v1/product',formData,{
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }})
                            .then(res => {
                                Swal.fire(
                                    'Added new!',
                                    'New category has been added.',
                                    'success'
                                )
                                this.product.tags="";
                                this.product.colors="";
                                this.product.memory="";
                                this.product.category_id="";
                                this.product.name="";
                                this.product.origin_price="";
                                this.product.previous_price="";
                                this.product.current_price= "";
                                this.product.ram="";
                                this.product.isOnsale="";
                                this.product.desc="";
                                this.product.quantity="";
                            }) */
                    }
                })
            },
            set_isOnsale:function(event){
               this.product.isOnsale = event.target.value;
            },
            preview_image:function(){
                const [file] = imgInp.files
                if (file) {
                    blah.src = URL.createObjectURL(file)
                }
            },
            preview_image_color:function(color,key){
                var image_preview_colors = 'image_preview_colors' + key;
                var imageColors = document.getElementById('imageColors' + key).files[0]
                var image_preview_colors = document.getElementById('image_preview_colors' + key);
                image_preview_colors.src = URL.createObjectURL(imageColors);
                image_preview_colors.onload = function() {
                URL.revokeObjectURL(image_preview_colors.src) // free memory
                }
            }
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<!-- New step!
     Add Multiselect CSS. Can be added as a static asset or inside a component. -->

<style>
  
</style>
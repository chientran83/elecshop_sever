import Dashboard from './components/Dashboard'
import Category from './components/category/Category'
import Category_index from './components/category/Index'
import Category_create from './components/category/Create'
import Category_edit from './components/category/Edit'
import Product from './components/product/Product'
import Product_index from './components/product/Index'
import Product_create from './components/product/Create'
import Product_edit from './components/product/Edit'

export const routes = [
    { path:'/',name:'dashboard',component:Dashboard},
    { path:'/category',name:'Category',component:Category, children:[
        { path:'',name:'Category_index',component:Category_index},
        { path:'create',name:'Category_create',component:Category_create},
        { path:'edit/:id',name:'Category_edit',component:Category_edit}
    ]},
    {path:'/product',name:'Product',component:Product, children:[
        {path:'',name:'Product_index',component:Product_index},
        {path:'create',name:'Product_create',component:Product_create},
        {path:'edit/:id',name:'Product_edit',component:Product_edit}
    ]}
]
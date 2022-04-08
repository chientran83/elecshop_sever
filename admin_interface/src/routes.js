import Dashboard from './components/Dashboard'
import Category from './components/category/Category'
import Category_index from './components/category/Index'
import Category_create from './components/category/Create'
import Category_edit from './components/category/Edit'
import Product from './components/product/Product'
import Product_index from './components/product/Index'
import Product_create from './components/product/Create'
import Product_edit from './components/product/Edit'
import Slider from './components/slider/Slider'
import Slider_index from './components/slider/Index'
import Slider_create from './components/slider/Create'
import Slider_edit from './components/slider/Edit'
import User from './components/user/User'
import User_index from './components/user/Index'
import User_create from './components/user/Create'
import User_edit from './components/user/Edit'
import Roles from './components/roles/Roles'
import Roles_index from './components/roles/Index'
import Roles_create from './components/roles/Create'
import Roles_edit from './components/roles/Edit'
import Permission from './components/permission/Permission'
import Permission_index from './components/permission/Index'
import Permission_create from './components/permission/Create'
import Permission_edit from './components/permission/Edit'

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
    ]},
    {path:'/slider',name:'slider',component:Slider, children:[
        {path:'',name:'slider_index',component:Slider_index},
        {path:'create',name:'slider_create',component:Slider_create},
        {path:'edit/:id',name:'slider_edit',component:Slider_edit}
    ]},
    {path:'/user',name:'user',component:User, children:[
        {path:'',name:'user_index',component:User_index},
        {path:'create',name:'user_create',component:User_create},
        {path:'edit/:id',name:'user_edit',component:User_edit}
    ]},
    {path:'/roles',name:'roles',component:Roles, children:[
        {path:'',name:'roles_index',component:Roles_index},
        {path:'create',name:'roles_create',component:Roles_create},
        {path:'edit/:id',name:'roles_edit',component:Roles_edit}
    ]},
    {path:'/permission',name:'permission',component:Permission, children:[
        {path:'',name:'permission_index',component:Permission_index},
        {path:'create',name:'permission_create',component:Permission_create},
        {path:'edit/:id',name:'permission_edit',component:Permission_edit}
    ]}
]
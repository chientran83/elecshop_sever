import Header from './components/partial/Header'
import Sidebar from './components/partial/Sidebar'
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
import Order from './components/order/Order'
import Order_index from './components/order/Index'
import Order_edit from './components/order/Edit'
import Coupon from './components/coupon/Coupon'
import Coupon_index from './components/coupon/Index'
import Coupon_create from './components/coupon/Create'
import Coupon_edit from './components/coupon/Edit'
import SignIn from './components/login/SignIn'

export const routes = [
    { path:'/',name:'dashboard',components:{
        default:Dashboard,
        'header': Header,
        'sideBar':Sidebar
    }},
    { path:'/sign-in',name:'dashboard',component:SignIn},

    { path:'/category',name:'Category',components:{
        default:Category,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        { path:'',name:'Category_index',component:Category_index},
        { path:'create',name:'Category_create',component:Category_create},
        { path:'edit/:id',name:'Category_edit',component:Category_edit}
    ]},

    {path:'/product',name:'Product',components:{
        default:Product,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        {path:'',name:'Product_index',component:Product_index},
        {path:'create',name:'Product_create',component:Product_create},
        {path:'edit/:id',name:'Product_edit',component:Product_edit}
    ]},

    {path:'/slider',name:'slider',components:{
        default:Slider,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        {path:'',name:'slider_index',component:Slider_index},
        {path:'create',name:'slider_create',component:Slider_create},
        {path:'edit/:id',name:'slider_edit',component:Slider_edit}
    ]},

    {path:'/user',name:'user',components:{
        default:User,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        {path:'',name:'user_index',component:User_index},
        {path:'create',name:'user_create',component:User_create},
        {path:'edit/:id',name:'user_edit',component:User_edit}
    ]},

    {path:'/roles',name:'roles',components:{
        default:Roles,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        {path:'',name:'roles_index',component:Roles_index},
        {path:'create',name:'roles_create',component:Roles_create},
        {path:'edit/:id',name:'roles_edit',component:Roles_edit}
    ]},

    {path:'/permission',name:'permission',components:{
        default:Permission,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        {path:'',name:'permission_index',component:Permission_index},
        {path:'create',name:'permission_create',component:Permission_create},
        {path:'edit/:id',name:'permission_edit',component:Permission_edit}
    ]},

    {path:'/coupon',name:'coupon',components:{
        default:Coupon,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        {path:'',name:'coupon_index',component:Coupon_index},
        {path:'create',name:'coupon_create',component:Coupon_create},
        {path:'edit/:id',name:'coupon_edit',component:Coupon_edit}
    ]},

    {path:'/order',name:'order',components:{
        default:Order,
        'header': Header,
        'sideBar':Sidebar
    }, children:[
        {path:'',name:'order_index',component:Order_index},
        {path:'edit/:id',name:'order_edit',component:Order_edit}
    ]},
]
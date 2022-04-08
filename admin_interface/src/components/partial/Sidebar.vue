<template>
<div>
<!-- [ Header ] end -->
            <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
<!-- [ navigation menu ] start -->
    <nav class="pcoded-navbar">
        <div class="navbar-wrapper">
            <div class="navbar-brand header-logo">
                <a href="index.html" class="b-brand">
                    <div class="b-bg">
                        <i class="feather icon-trending-up"></i>
                    </div>
                    <span class="b-title">Elecshop</span>
                </a>
                <a class="mobile-menu" id="mobile-collapse" href="javascript:" v-on:click="reponsive_content()"><span></span></a>
            </div>
            <div class="navbar-content scroll-div">
                <ul class="nav pcoded-inner-navbar">
                    <router-link
                    tag="li"
                    class="nav-item"
                    to="/"
                    active-class="active"
                    exact>
                        <a class="nav-link "><span class="pcoded-micon"><i class="feather icon-home"></i></span><span class="pcoded-mtext">Dashboard</span></a>
                    </router-link>
                    <li class="nav-item pcoded-menu-caption">
                        <label>Manage</label>
                    </li>
                    <router-link
                        tag="li"
                        class="nav-item"
                        to="/category"
                        active-class="active"
                        >
                            <a class="nav-link"><span class="pcoded-micon">
                                <i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Categories</span>
                            </a>
                    </router-link>
                    <router-link
                        tag="li"
                        class="nav-item"
                        to="/product"
                        active-class="active"
                        >
                            <a class="nav-link"><span class="pcoded-micon">
                                <i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Product</span>
                            </a>
                    </router-link>
                    <router-link
                        tag="li"
                        class="nav-item"
                        to="/slider"
                        active-class="active"
                        >
                            <a class="nav-link"><span class="pcoded-micon">
                                <i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Slider</span>
                            </a>
                    </router-link>
                    <router-link
                        tag="li"
                        class="nav-item"
                        to="/user"
                        active-class="active"
                        >
                            <a class="nav-link"><span class="pcoded-micon">
                                <i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">User</span>
                            </a>
                    </router-link>
                    <router-link
                        tag="li"
                        class="nav-item"
                        to="/roles"
                        active-class="active"
                        >
                            <a class="nav-link"><span class="pcoded-micon">
                                <i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Roles</span>
                            </a>
                    </router-link>
                    <router-link
                        tag="li"
                        class="nav-item"
                        to="/permission"
                        active-class="active"
                        >
                            <a class="nav-link"><span class="pcoded-micon">
                                <i class="feather icon-sidebar"></i></span><span class="pcoded-mtext">Permission</span>
                            </a>
                    </router-link>
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ navigation menu ] end -->
</div>
</template>
<script>
    export default {
        

    }
</script>
<style>
</style>
<template>
    <!-- <Navbar></Navbar> -->
    <router-view></router-view>
    <!-- <Footer></Footer> -->
</template>

<script>
    import Footer from './components/Shared/Footer.vue';
    import Navbar from './components/Shared/Navbar.vue';
    export default{
        components:{
            Footer,
            Navbar
        }
    }
</script>
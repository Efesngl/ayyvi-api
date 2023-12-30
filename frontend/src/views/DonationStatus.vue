<template>
    <Navbar></Navbar>
    <div class="container-fluid h-auto min-vh-100">
        <div class="row" v-if="this.$route.params.status=='basarili'">
            <div class="col-12 d-flex justify-content-start align-items-center flex-column">
                <img src="/assets/img/svg/undraw_super_thank_you_re_f8bo.svg" class="w-50 h-50" alt="">
                <h3>Bağışın için çok teşekkür ederiz projemiz sizin sayenizde devam ediyor. <i class="bi bi-hearts text-danger"></i></h3>
                <RouterLink :to="{name:'HomePage'}" class="btn btn-danger">Ana sayfaya geri dön</RouterLink>
            </div>
        </div>
        <div class="row" v-else>
            <div class="col-12 d-flex justify-content-start align-items-center flex-column">
                <img src="/assets/img/svg/undraw_feeling_blue_-4-b7q.svg" class="w-50 h-50" alt="">
                <h3>Maalesef bağış işlemin başarısız oldu. Ama daha sonra tekrardan deneyebilirsin <i class="bi bi-hearts text-danger"></i>.</h3>
                <RouterLink :to="{name:'HomePage'}" class="btn btn-danger">Ana sayfaya geri dön</RouterLink>
            </div>
        </div>
    </div>
    <Footer></Footer>
</template>
<script>
    import { RouterLink } from 'vue-router';
import Footer from '../components/Shared/Footer.vue';
    import Navbar from '../components/Shared/Navbar.vue';   
    export default{
        components:{
    Navbar,
    Footer,
    RouterLink
}
    }
</script>
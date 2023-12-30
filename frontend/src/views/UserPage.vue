<template>
  <Navbar></Navbar>
  <div class="container-fluid h-auto">
    <div class="row" id="sections">
      <div class="col-12">
        <ul class="nav nav-tabs justify-content-center">
          <li class="nav-item">
            <RouterLink to="/hesabim/hesapdetaylari" class="nav-link browse-link" active-class="active">
              Hesap detayları
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/hesabim/baslattigimkampanyalar" class="nav-link browse-link" active-class="active">
              Başlattığım kampanyalar
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/hesabim/katildigimkampanyalar" class="nav-link browse-link" active-class="active">
              Katıldığım kampanyalar
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink to="/hesabim/yaptigimbagislar" class="nav-link browse-link" active-class="active">
              Yaptığım bağışlar
            </RouterLink>
          </li>
        </ul>
      </div>
    </div>
    <div class="container-fluid flex-column d-flex justify-content-center align-items-center pt-5 h-auto" id="user-page-content-container">
      <RouterView></RouterView>
    </div>
  </div>
  <Footer></Footer>
</template>
<script>
import Navbar from "../components/Shared/Navbar.vue";
import Footer from "../components/Shared/Footer.vue";
import { RouterLink } from "vue-router";
export default {
  components: {
    Navbar,
    Footer,
    RouterLink,
  },
  data() {
    return {};
  },
};
</script>

<style>
#user-page-content-container::-webkit-scrollbar{
  width: 5px;
}
#user-page-content-container::-webkit-scrollbar-track{
  background:var(--bs-red);
}
.user-link {
  color: var(--bs-black);
  text-decoration: none;
  font-size: 1.3rem;
  transition: 0.2s;
}
.user-link:hover{
  color: var(--bs-red);
}
.user-link.active{
  color: var(--bs-red);
}
</style>

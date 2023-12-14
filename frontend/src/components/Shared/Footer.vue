<template>
  <footer id="footer" class="mt-5 d-inline-block w-100">
    <div class="container-fluid text-white p-3 pt-5">
      <div class="row text-center">
        <div class="col-4 d-none d-md-block">
          <div class="row">
            <div class="col-12 d-flex flex-column justify-content-around align-items-center">
              <img src="/assets/img/logo/png/lw.png" class="w-50 h-50" style="object-fit: cover" alt="" />
              <RouterLink to="/kampanyabaslat" class="btn btn-danger border" id="start-petition-button-footer">Bir kampanya başlat</RouterLink>
            </div>
          </div>
        </div>
        <div class="col-6 col-md-4 d-flex flex-column justify-content-evenly">
          <RouterLink to="/" class="fs-3 text-white text-decoration-none footer-link">Ana Sayfa</RouterLink>
          <RouterLink to="/gozat" class="fs-3 text-white text-decoration-none footer-link">Kampanyalara göz at</RouterLink>
          <RouterLink to="/bagis" class="fs-3 text-white text-decoration-none footer-link">Bağış yap</RouterLink>
        </div>
        <div class="col-6 col-md-4 d-flex flex-column justify-content-evenly">
          <a href="/" class="footer-link text-white"><i class="bi bi-instagram fs-4"></i></a>
          <a href="/" class="footer-link text-white"><i class="bi bi-threads fs-4"></i></a>
          <a href="/" class="footer-link text-white"><i class="bi bi-twitter-x fs-4"></i></a>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-12 text-white text-center">@<span id="cp-date">{{ date }}</span> AYYVİ bütün hakları sakldıır !</div>
    </div>
  </footer>
</template>

<script>
export default {
  computed:{
    date(){
      return new Date().getFullYear()
    }
  }
};
</script>
<style>
#footer {
  border-top: 1px solid black;
  background-color: var(--dark-red);
}
.footer-link{
  transition: 0.2s;
}
.footer-link:hover{
  color: var(--bs-black) !important;
}
#start-petition-button-footer{
  transition: 0.2s;
}
#start-petition-button-footer:hover{
  background: var(--bs-white);
  color: var(--bs-black);
}
</style>

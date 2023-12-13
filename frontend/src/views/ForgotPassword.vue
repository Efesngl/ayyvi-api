<template>
  <div class="container-fluid vw-100 vh-100 d-flex align-items-center justify-content-center" style="background-color: var(--bs-gray-200);">
    <div class="row">
      <div class="col-12 d-flex justify-content-center align-content-center">
        <div class="card mb-3" style="max-width: 50rem">
          <div class="row g-0">
            <div class="col-md-6 d-none d-md-block p-5">
              <img src="/img/svg/undraw_sign_in_re_o58h (1).svg" class="h-100 w-100" alt="..." />
            </div>
            <div
              class="col-md-6 col-12 text-white"
              style="
                border-top-right-radius: var(--bs-border-radius);
                border-bottom-right-radius: var(--bs-border-radius);
                background-color: var(--bs-red);
              "
            >
              <div class="card-body p-5">
                <div class="row">
                  <div class="col-12">
                    <RouterLink to="/login" class="text-white text-decoration-none form-link"
                      ><i class="bi bi-arrow-left me-1"></i>Giriş ekranına geri dön</RouterLink
                    >
                  </div>
                </div>
                <div class="text-center">
                  <RouterLink to="/"><img src="/img/logo/png/lw.png" class="w-25 h-25" style="object-fit: contain" alt="" /></RouterLink>
                </div>
                <h5 class="card-title text-center">Hesabınızın şifresini sıfırlayın</h5>
                <label for="email">Eposta</label>
                <div class="row" v-if="errors.isEmailEmpty">
                  <div class="col-12">
                    <span>Lütfen eposta giriniz !</span>
                  </div>
                </div>
                <input type="text" v-model="email" name="email" class="form-control" id="email" />
                <button class="btn btn-danger border w-100 mt-2" id="login-button" @click="resetPassword">Sıfırla</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { RouterLink } from "vue-router";
export default {
  data() {
    return {
      email: null,
      errors: {
        isEmailEmpty: false,
        isPasswordEmpty: false,
      },
    };
  },
  methods: {
    isEmailEmpty() {
      if (this.email == null || this.email == "") {
        this.errors.isEmailEmpty = true;
      }
    },
    checkErrors() {
      this.errors = {
        isEmailEmpty: false,
      };
      this.isEmailEmpty();
      if (this.errors.isEmailEmpty == true) {
        return false;
      }
      return true;
    },
    resetPassword() {
      if (this.checkErrors()) {
        this.$swal.fire({
          icon: "success",
          title: "Sıfırlama bağlantısı gönderildi",
          text: "Eğer girdiğiniz eposta ile bir hesap uyuşuyorsa sıfırlama bağlantısı girilen eposta adresine gönderildi",
        });
      } else {
        alert("error var");
      }
    },
    showPassword(e) {
      let btn = document.querySelector("#show-password");
      let passInput = document.querySelector("#password");
      if (!btn.classList.contains("show")) {
        btn.classList.add("show");
        btn.children[0].classList.replace("bi-eye-slash-fill", "bi-eye-fill"), passInput.setAttribute("type", "text");
      } else {
        btn.classList.remove("show");
        btn.children[0].classList.replace("bi-eye-fill", "bi-eye-slash-fill");
        passInput.setAttribute("type", "password");
      }
    },
  },
  components: { RouterLink },
};
</script>

<style>
/* #login-body{
      background-image: url("../assets/img/bg-2.svg");
      background-repeat: no-repeat;
      background-size: cover;
  } */
.form-link {
  transition: 0.2s;
}
.form-link:hover {
  opacity: 0.5;
}
#login-button:hover {
  color: var(--bs-black) !important;
  --bs-btn-hover-bg: var(--bs-white);
}
#login-form-container {
  height: 75vh;
  background-color: white;
}
</style>

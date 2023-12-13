<template>
  <div class="vw-100 vh-100 d-flex justify-content-center align-items-center container-fluid" style="background-color: var(--bs-gray-200)">
    <div class="row rounded">
      <div class="col-12 d-flex justify-content-center align-content-center">
        <div class="card mb-3" style="max-width: 50rem">
          <div class="row g-0">
            <div class="d-none d-md-block col-md-6 p-5">
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
                <div class="text-center">
                  <RouterLink to="/"><img src="/img/logo/png/lw.png" class="w-25 h-25" style="object-fit: contain" alt="" /></RouterLink>
                </div>
                <h5 class="card-title text-center">Hesabınıza giriş yapın</h5>
                <label for="email">Eposta</label>
                <div class="row" v-if="errors.isEmailEmpty">
                  <div class="col-12">
                    <span>Lütfen eposta giriniz !</span>
                  </div>
                </div>
                <input type="text" v-model="user.email" name="email" class="form-control" id="email" />
                <label for="password">Şifre</label>
                <div class="row" v-if="errors.isPasswordEmpty">
                  <div class="col-12">
                    <span>Lütfen şifre giriniz !</span>
                  </div>
                </div>
                <div class="input-group mb-3">
                  <input :type="input.inputType" v-model="user.password" name="password" class="form-control" id="password" />
                  <button class="btn btn-light border" :class="{'active':input.isPassShowing}" @click="showPassword">
                    <i class="bi bi-eye-slash" v-if="!input.isPassShowing"></i>
                    <i class="bi bi-eye" v-else></i>
                  </button>
                </div>
                <div class="row mt-2">
                  <div class="col-6">
                    <input type="checkbox" class="form-check-input me-2" name="remember" id="remember" />
                    <label for="remember" class="form-check-label">Beni Hatırla</label>
                  </div>
                  <div class="col-6 text-end">
                    <RouterLink to="/forgotpassword" class="text-white text-decoration-none form-link">Şifremi unuttum</RouterLink>
                  </div>
                </div>
                <button class="btn btn-danger border w-100 mt-2" id="login-button" @click="login">Giriş Yap</button>
                <div class="row mt-2">
                  <div class="col-12 text-center">
                    <RouterLink to="/register" class="text-white text-decoration-none form-link"
                      >Hesabınız yok mu? Hemen bir hesap oluşturun</RouterLink
                    >
                  </div>
                </div>
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
import { useUserStore } from "../stores/UserStore";
export default {
  data() {
    return {
      userStore: useUserStore(),
      user: {
        email: null,
        password: null,
      },
      errors: {
        isEmailEmpty: false,
        isPasswordEmpty: false,
      },
      input:{
        isPassShowing:false,
        inputType:"password"
      }
    };
  },
  methods: {
    isEmailEmpty() {
      if (this.user.email == null || this.user.email == "") {
        this.errors.isEmailEmpty = true;
      }
    },
    isPasswordEmpty() {
      if (this.user.password == null || this.user.password == "") {
        this.errors.isPasswordEmpty = true;
      }
    },
    checkErrors() {
      this.errors = {
        isEmailEmpty: false,
        isPasswordEmpty: false,
      };
      this.isEmailEmpty();
      this.isPasswordEmpty();
      if (this.errors.isEmailEmpty == true || this.errors.isPasswordEmpty == true) {
        return false;
      }
      return true;
    },
    async login() {
      // await this.$sanctum.get("/sanctum/csrf-cookie")
      let s = this.$swal.mixin({
        toast: true,
        position: "top-end",
        iconColor: "white",
        color: "white",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      });
      if (this.checkErrors()) {
        await this.$axios.post("login",{
          user:this.user
        }).then((res) => {
          console.log(res.data);
          if (res.data.length > 0) {
            this.userStore.$patch({
              firstname: res.data[0].firstname,
              lastname: res.data[0].lastname,
              email:res.data[0].email,
              ID: res.data[0].ID,
            });
            s.fire({
              background: "var(--bs-teal)",
              icon: "success",
              title: "Giriş işlemi başarılı yönlendiriliyorsunuz...",
            }).then(() => {
              this.$router.replace({ name: "HomePage" });
            });
          } else {
            s.fire({
              icon: "error",
              background: "var(--bs-red)",
              title: "Kullanıcı adı veya şifre hatalı !",
            });
          }
        });
      } else {
        alert("error var");
      }
    },
    showPassword(e) {
      this.input.isPassShowing=!this.input.isPassShowing
      if(this.input.isPassShowing){
        this.input.inputType="text"
      }
      else{
        this.input.inputType="password"

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
/* #login-form-container {
  height: 75vh;
  background-color: white;
} */
</style>

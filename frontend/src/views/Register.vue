<template>
  <div class="container-fluid vw-100 vh-100 d-flex align-items-center justify-content-center" style="background-color: var(--bs-gray-200)">
    <div class="row">
      <div class="col-12 d-flex justify-content-center align-content-center">
        <div class="card mb-3" style="max-width: 50rem">
          <div class="row g-0">
            <div class="col-md-6 d-none d-md-block p-5">
              <img src="/assets/img/svg/undraw_sign_up_n6im (1).svg" class="h-100 w-100" alt="..." />
            </div>
            <div
              class="col-md-6 col-12 text-white"
              style="background: var(--bs-red); border-top-right-radius: var(--bs-border-radius); border-bottom-right-radius: var(--bs-border-radius)"
            >
              <div class="card-body p-5">
                <div class="text-center">
                  <RouterLink to="/"><img src="/assets/img/logo/png/lw.png" class="w-25 h-25" style="object-fit: contain" alt="" /></RouterLink>
                </div>
                <h5 class="card-title text-center">Hemen yeni bir hesap oluşturun</h5>
                <label for="firstname">Ad</label>
                <input type="text" v-model="user.firstname" name="firstname" class="form-control" id="firstname" />
                <p v-if="errors.isFirstnameEmpty">Bu alanı doldurmak zorunludur !</p>
                <label for="lastname">Soyad</label>
                <input type="text" name="lastname" v-model="user.lastname" class="form-control" id="lastname" />
                <p v-if="errors.isLastnameEmpty">Bu alanı doldurmak zorunludur !</p>
                <label for="email">Eposta</label>
                <input type="text" name="email" v-model="user.email" class="form-control" id="email" @keydown.space.prevent />
                <p v-if="errors.isEmailEmpty">Bu alanı doldurmak zorunludur !</p>
                <label for="password">Şifre</label>
                <div class="input-group">
                  <input :type="input.inputType" @keydown.space.prevent v-model="user.password" name="password" class="form-control" id="password" />
                  <button class="btn btn-light border" :class="{ active: input.isPassShowing }" @click="showPassword">
                    <i class="bi bi-eye-slash" v-if="!input.isPassShowing"></i>
                    <i class="bi bi-eye" v-else></i>
                  </button>
                </div>
                <p v-if="errors.isPasswordEmpty">Bu alanı doldurmak zorunludur !</p>
                <div class="row mt-3">
                  <div class="col-12">
                    <input
                      type="checkbox"
                      class="form-check-input me-2"
                      v-model="isReadAndAccepted"
                      name="terms-and-privacy"
                      id="terms-and-privacy"
                    />
                    <label for="terms-and-privacy" class="form-check-label">Şartları Okudum ve kabul ediyorun</label>
                    <p v-if="errors.isRnAChecked">Bu alanı doldurmak zorunludur !</p>
                  </div>
                </div>
                <button class="btn btn-danger border w-100 mt-2" id="register-button" @click="register">Üye ol</button>
                <div class="row mt-2">
                  <div class="col-12 text-center">
                    <RouterLink :to="{name:'Login'}" class="text-white text-decoration-none form-link"
                      >Zaten bir hesabınız var mı? Hemen giriş yapın</RouterLink
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
import { useUserStore } from "../stores/UserStore";
export default {
  data() {
    return {
      userStore: useUserStore(),
      input: {
        isPassShowing: false,
        inputType: "password",
      },
      user: {
        firstname: "",
        lastname: "",
        email: "",
        password: "",
      },
      isReadAndAccepted: false,
      errors: {
        isFirstnameEmpty: false,
        isLastnameEmpty: false,
        isEmailEmpty: false,
        isPasswordEmpty: false,
        isRnAChecked: false,
      },
    };
  },
  methods: {
    showPassword(e) {
      this.input.isPassShowing = !this.input.isPassShowing;
      if (this.input.isPassShowing) {
        this.input.inputType = "text";
      } else {
        this.input.inputType = "password";
      }
    },
    isFirstnameEmpty() {
      if (this.user.firstname == "") {
        this.errors.isFirstnameEmpty = true;
        return false;
      }
      return true;
    },
    isLastnameEmpty() {
      if (this.user.lastname == "") {
        this.errors.isLastnameEmpty = true;
        return false;
      }
      return true;
    },
    isEmailEmpty() {
      if (this.user.email == "") {
        this.errors.isEmailEmpty = true;
        return false;
      }
      return true;
    },
    isPasswordEmpty() {
      if (this.user.password == "") {
        this.errors.isPasswordEmpty = true;
        return false;
      }
      return true;
    },
    isRnAChecked() {
      if (!this.isReadAndAccepted) {
        this.errors.isRnAChecked = true;
        return false;
      }
      return true;
    },
    checkErrors() {
      this.errors = {
        isFirstnameEmpty: false,
        isLastnameEmpty: false,
        isEmailEmpty: false,
        isPasswordEmpty: false,
        isRnAChecked: false,
      };
      this.isEmailEmpty();
      this.isFirstnameEmpty();
      this.isLastnameEmpty();
      this.isPasswordEmpty();
      this.isRnAChecked();
      for (const e in this.errors) {
        if (this.errors[e]) return false;
      }
      return true;
      // return true
    },
    register() {
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
        this.$axios({
          method: "post",
          url: "/register",
          data: {
            user: this.user,
          },
        }).then((res) => {
          console.log(res.data.user);
          this.userStore.$patch({
            firstname: res.data.user.firstname,
            lastname: res.data.user.lastname,
            ID: res.data.user.ID,
          });
          s.fire({
            background: "var(--bs-teal)",
            icon: "success",
            title: "Kayıt olma işlemi başarılı ana sayfaya yönlendiriliyorsunuz...",
          }).then(() => {
            this.$router.replace({ name: "HomePage" });
          });
        });
      }
    },
  },
};
</script>
<style>
#register-button:hover {
  color: var(--bs-black) !important;
  --bs-btn-hover-bg: var(--bs-white);
}
p{
  margin: 0;
}
</style>

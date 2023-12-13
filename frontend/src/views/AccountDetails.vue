<template>
    <div class="container h-100 w-100 p-0 d-flex justify-content-center align-items-center">
        <div class="row h-100">
            <div class="col-12 h-100 p-0">
                <div class="card h-100 mb-3" style="max-width: 50rem">
                    <div class="row g-0">
                        <div class="d-none d-md-block col-md-6 p-5">
                            <img src="/assets/img/svg/undraw_update_re_swkp.svg" class="h-100 w-100" alt="..." />
                        </div>
                        <div class="col-md-6 col-12 text-white rounded" style="background-color: var(--bs-red)">
                            <div class="card-body p-5">
                                <h5 class="card-title text-center">Hesap detayları</h5>
                                <label for="firstname">Ad</label>
                                <div class="row" v-if="errors.isFirstnameEmpty">
                                    <div class="col-12">
                                        <span>Lütfen ad giriniz !</span>
                                    </div>
                                </div>
                                <input type="text" v-model="user.firstname" name="firstname" class="form-control" id="firstname" />
                                <label for="lastname">Soyad</label>
                                <div class="row" v-if="errors.isLastnameEmpty">
                                    <div class="col-12">
                                        <span>Lütfen soyad giriniz !</span>
                                    </div>
                                </div>
                                <input type="text" v-model="user.lastname" name="lastname" class="form-control" id="lastname" />

                                <label for="email">Eposta</label>
                                <div class="row" v-if="errors.isEmailEmpty">
                                    <div class="col-12">
                                        <span>Lütfen eposta giriniz !</span>
                                    </div>
                                </div>
                                <input type="text" v-model="user.email" name="email" class="form-control" id="email" />
                                <label for="password">Şifre</label>
                                <div class="input-group mb-3">
                                    <input :type="input.inputType" v-model="user.password" name="password" class="form-control" id="password" />
                                    <button class="btn btn-light border" :class="{ active: input.isPassShowing }" @click="showPassword">
                                        <i class="bi bi-eye-slash" v-if="!input.isPassShowing"></i>
                                        <i class="bi bi-eye" v-else></i>
                                    </button>
                                </div>
                                <button class="btn btn-danger border w-100 mt-2" id="login-button" @click="updateUserDetail">Kaydet</button>
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
                firstname: null,
                lastname: null,
                email: null,
                password: null,
            },
            errors: {
                isFirstnameEmpty: false,
                isLastnameEmpty: false,
                isEmailEmpty: false,
            },
            input: {
                isPassShowing: false,
                inputType: "password",
            },
        };
    },
    beforeMount() {
        this.user.firstname = this.userStore.firstname;
        this.user.lastname = this.userStore.lastname;
        this.user.email = this.userStore.email;
    },
    methods: {
        isFirstnameEmpty() {
            if (this.user.firstname == null || this.user.firstname == "") {
                this.errors.isFirstnameEmpty = true;
            }
        },
        isLastnameEmpty() {
            if (this.user.lastname == null || this.user.lastname == "") {
                this.errors.isLastnameEmpty = true;
            }
        },
        isEmailEmpty() {
            if (this.user.email == null || this.user.email == "") {
                this.errors.isEmailEmpty = true;
            }
        },
        checkErrors() {
            this.errors = {
                isFirstnameEmpty: false,
                isLastnameEmpty: false,
                isEmailEmpty: false,
                isPasswordEmpty: false,
            };
            this.isFirstnameEmpty();
            this.isLastnameEmpty();
            this.isEmailEmpty();
            for (const e in this.errors) {
                if (this.errors[e]) return false;
            }
            return true;
        },
        updateUserDetail() {
            if (!this.checkErrors()) return false;
            this.$axios
                .post("user/updateuserdetail", {
                    user: this.user,
                    userID: this.userStore.ID,
                })
                .then((res) => {
                    if (res.status == 200) {
                        this.userStore.$patch({
                            firstname: this.user.firstname,
                            lastname: this.user.lastname,
                            email: this.user.email,
                        });
                        this.$swal.fire({
                            toast: true,
                            position: "top-end",
                            iconColor: "white",
                            color: "white",
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true,
                            background: "var(--bs-teal)",
                            icon: "success",
                            title: "Kullanıcı bilgileri başarıyla güncellendi",
                        });
                    }
                });
        },
        showPassword(e) {
            this.input.isPassShowing = !this.input.isPassShowing;
            if (this.input.isPassShowing) {
                this.input.inputType = "text";
            } else {
                this.input.inputType = "password";
            }
        },
    },
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

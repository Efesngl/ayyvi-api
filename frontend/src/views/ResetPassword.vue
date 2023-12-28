<template>
    <div class="container-fluid vw-100 vh-100 d-flex align-items-center justify-content-center" style="background-color: var(--bs-gray-200)">
        <div class="row">
            <div class="col-12 d-flex justify-content-center align-content-center">
                <div class="card mb-3" style="max-width: 50rem">
                    <div class="row g-0">
                        <div class="col-md-6 d-none d-md-block p-5">
                            <img src="/assets/img/svg/undraw_forgot_password_re_hxwm.svg" class="h-100 w-100" alt="..." />
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
                                    <img src="/assets/img/logo/png/lw.png" class="w-25 h-25" style="object-fit: contain" alt="" />
                                </div>
                                <h5 class="card-title text-center">Hesabınızın şifresini sıfırlayın</h5>
                                <label for="email">Şifre giriniz</label>
                                <input
                                    v-model="passwords.pass1"
                                    type="password"
                                    name="password-1"
                                    class="form-control"
                                    id="password-1"
                                    @keyup="checkPass"
                                    @keydown.space.prevent
                                />
                                <label for="email">Tekrar şifre giriniz</label>
                                <input
                                    v-model="passwords.pass2"
                                    type="password"
                                    name="password-2"
                                    class="form-control"
                                    id="password-2"
                                    @keyup="checkPass"
                                    @keydown.space.prevent
                                />
                                <div class="row" v-if="!isPasswordsMatching">
                                    <div class="col-12">
                                        <p class="text-white">Şifreler eşleşmiyor !</p>
                                    </div>
                                </div>
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
            passwords: {
                pass1: "",
                pass2: "",
            },
            isPasswordsMatching: true,
        };
    },
    methods: {
        checkPass() {
            if (this.passwords.pass1 != this.passwords.pass2) this.isPasswordsMatching = false;
            else this.isPasswordsMatching = true;
        },
        resetPassword() {
            if (this.isPasswordsMatching) {
                this.$axios
                    .post("user/resetpassword", {
                        pass: this.passwords.pass1,
                        token: this.$route.params.token,
                    })
                    .then((res) => {
                        if (res.status == 200) {
                            this.$swal.fire({
                                icon: "success",
                                title: "Şifre başarıyla sıfırlandı! Giriş ekranına yönlendiriliyorsunuz...",
                                timer: 1500,
                                showConfirmButton:false,
                                timerProgressBar: true,
                            }).then(()=>{
                                this.$router.push({name:"Login"})
                            });
                        }
                    });
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

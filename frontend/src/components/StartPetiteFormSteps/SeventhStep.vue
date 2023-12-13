<template>
    <div class="mt-5 container w-75 h-100 d-flex flex-column justify-content-between" id="start-petite-form" v-if="userStore.isLogged">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="fs-1">Herşey hazır hadi kampanyanı yayınlayalım !</h2>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-6 text-center">
                <button class="btn btn-danger" @click="decStep">Önceki adım</button>
            </div>
            <div class="col-6 text-center">
                <button class="btn btn-danger" @click="startThePetition">Kampanyayı yayınla</button>
            </div>
        </div>
    </div>
    <div class="mt-5 container w-75 h-100 d-flex flex-column justify-content-between" id="start-petite-form" v-else>
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="fs-1">Kampanyanı yayınlamadan önce lütfen giriş yap !</h2>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-6 text-center">
                <button class="btn btn-danger h-100" @click="decStep">Önceki adım</button>
            </div>
            <div class="col-6 text-center">
                <RouterLink to="/login" class="btn btn-danger h-100">Giriş yap</RouterLink>
                <!-- <button class="btn btn-danger" @click="startThePetition">Giriş Yap</button> -->
            </div>
        </div>
    </div>
</template>

<script>
import { RouterLink, routerKey } from "vue-router";
import { useUserStore } from "../../stores/UserStore.js";
import { usePetiteInfo } from "../../stores/StartPetite";
export default {
    data() {
        return {
            userStore: useUserStore(),
            petiteStore: usePetiteInfo(),
        };
    },
    inject: ["decStep"],
    methods: {
        startThePetition() {
            this.$axios({
                method: "post",
                url: "/petites/newpetite",
                data: {
                    petite: this.petiteStore.petite,
                    user: this.userStore.ID,
                },
            }).then((res) => {
              if (res.data.petite!=undefined) {
                this.$swal.fire({
                  toast: true,
                  position: "top-end",
                  iconColor: "white",
                  color: "white",
                  showConfirmButton: false,
                  timer: 1500,
                  timerProgressBar: true,
                  background: "var(--bs-teal)",
                  icon: "success",
                  title: "Kampanyanız başarıyla yayınlandı yönlendiriliyorsunuz...",
                }).then(()=>{
                      this.petiteStore.$reset();
                      this.$router.push({name:"HomePage"})
                    })
                }
            });
        },
    },
};
</script>

<template>
    <div class="container" v-if="petites.length>0">
        <JoinedPetitesCard v-for="p in petites" :totalSigned="p.total_signed" :targetSign="p.targetSign">
            <template v-slot:browsePetiteCardImage>
                <img :src="p.petite_image" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
            </template>
            <template v-slot:browsePetiteCardHeader>
                <h5 class="card-title">{{ p.petite_header }}</h5>
            </template>
            <template v-slot:browsePetiteCardContent>
                <p class="card-text">
                    <span v-html="p.petite_content"></span>
                </p>
            </template>
            <template v-slot:browsePetiteCardButton>
                <div class="row mt-2">
                    <div class="col-12 text-center">
                        <RouterLink :to="{name:'PetiteDetailPage',params:{ID:p.ID}}" class="btn btn-danger">Kampanyaya git</RouterLink>
                    </div>
                </div>
            </template>
        </JoinedPetitesCard>
    </div>
    <div class="container" v-else>
        <div class="row">
            <div class="col-12 text-center">
                <h3 class="text-danger">Katıldığınız bir kampanya yoktur!</h3>
                <RouterLink to="/browse" class="btn btn-danger">Hemen katılmak için kampanyalara göz atın</RouterLink>
            </div>
        </div>
    </div>
</template>

<script>
import { RouterLink } from "vue-router";
import JoinedPetitesCard from "../components/JoinedPetitesCard.vue";
import { useUserStore } from "../stores/UserStore";
export default {
    components: {
        JoinedPetitesCard,
        RouterLink,
    },
    data(){
        return {
            userStore:useUserStore(),
            petites:[]
        }
    },
    created(){
        this.getJoinedPetites()
    },
    methods:{
        getJoinedPetites(){
            this.$axios.get(`user/getjoinedpetites?userID=${this.userStore.ID}`).then(res=>{
                this.petites=res.data.petites
            })
        }
    }
};
</script>

<template>
  <div class="container" v-if="petitions.length>0">
    <JoinedpetitionsCard v-for="p in petitions" :totalSigned="p.total_signed" :targetSign="p.target_sign">
        <template v-slot:browsepetitionCardImage>
          <img :src="this.apiURL+p.petition_image" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
        </template>
        <template v-slot:browsepetitionCardHeader>
          <h5 class="card-title">{{ p.petition_header }}</h5>
        </template>
        <template v-slot:browsepetitionCardContent>
          <p class="card-text">
            <span v-html="p.petition_content"></span>
          </p>
        </template>
        <template v-slot:browsepetitionCardButton>
          <div class="row mt-2">
            <div class="col-6 text-center">
              <RouterLink :to="{name:'EditPetition',params:{ID:p.ID}}" class="btn btn-danger">Kampanyayı düzenle</RouterLink>
            </div>
            <div class="col-6 text-center">
              <RouterLink :to="{name:'PetitionDetail',params:{ID:p.ID}}" class="btn btn-primary h-100">Kampanyaya git</RouterLink>
            </div>
          </div>
        </template>
    </JoinedpetitionsCard>
  </div>
  <div class="container" v-else>
    <div class="row">
      <div class="col-12 text-center">
        <h3 class="text-danger">Başlattığınız herhangi bir kampanya yoktur !</h3>
        <RouterLink to="/kampanyabaslat" class="btn btn-danger">Hemen bir kampanya başlatın</RouterLink>
      </div>
    </div>
  </div>
</template>

<script>
import { RouterLink } from "vue-router";
import JoinedpetitionsCard from "../components/JoinedpetitionsCard.vue";
import { useUserStore } from "../stores/UserStore";
export default {
  components: {
    JoinedpetitionsCard,
    RouterLink
},
  data(){
    return {
      userStore:useUserStore(),
      petitions:[]
    }
  },
  created(){
    this.getUserpetitions()
  },
  methods:{
    getUserpetitions(){
      this.$axios.get(`user/getuserpetitions?userID=${this.userStore.ID}`).then(res=>{
        this.petitions=res.data.petitions
      })
    }
  }
};
</script>

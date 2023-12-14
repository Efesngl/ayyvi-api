<template>
  <Navbar></Navbar>
  <!-- tabs -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 text-center mt-3">
        <h4>Katılmak için kampanyalara göz atın</h4>
      </div>
    </div>
    <div class="row" id="sections">
      <div class="col-12">
        <ul class="nav nav-tabs justify-content-center">
          <li class="nav-item">
            <button
              @click="changeActiveTab('newest')"
              class="nav-link browse-link"
              :class="{ active: activeTab == 'newest' }"
              aria-current="page"
              href="#"
            >
              En yeniler
            </button>
          </li>
          <li class="nav-item">
            <button @click="changeActiveTab('popular')" class="nav-link browse-link" :class="{ active: activeTab == 'popular' }" href="#">
              Öne çıkanlar
            </button>
          </li>
          <li class="nav-item">
            <button @click="changeActiveTab('succeded')" class="nav-link browse-link" :class="{ active: activeTab == 'succeded' }" href="#">
              Başarılı olanlar
            </button>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container h-auto" style="height: 70vh;" v-auto-animate>
    <!-- newest petitions -->
    <div class="container-fluid mt-5" v-if="activeTab == 'newest'">
      <BrowsepetitionCard v-for="petition in petitions" :petition="petition">
        <template v-slot:browsepetitionCardImage>
          <img :src="petition.petitionImage" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
        </template>
        <template v-slot:browsepetitionCardHeader>
          <h5 class="card-title">{{ petition.petitionHeader }}</h5>
        </template>
        <template v-slot:browsepetitionCardContent>
          <p class="card-text">{{ petition.petitionContent }}</p>
        </template>
        <template v-slot:browsepetitionCardButton>
          <div class="row mt-2">
            <div class="col-12 text-center">
              <RouterLink :to="{ name: 'PetitionDetail', params: { ID: petition.ID } }" class="btn btn-danger text-decoration-none"
                >Kampanyaya git</RouterLink
              >
            </div>
          </div>
        </template>
      </BrowsepetitionCard>
    </div>
    <div class="container-fluid mt-5" v-if="activeTab == 'popular'">
      <BrowsepetitionCard v-for="petition in popularpetitions" :petition="petition">
        <template v-slot:browsepetitionCardImage>
          <img :src="petition.petitionImage" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
        </template>
        <template v-slot:browsepetitionCardHeader>
          <h5 class="card-title">{{ petition.petitionHeader }}</h5>
        </template>
        <template v-slot:browsepetitionCardContent>
          <p class="card-text">{{ petition.petitionContent }}</p>
        </template>
        <template v-slot:browsepetitionCardButton>
          <div class="row mt-2">
            <div class="col-12 text-center">
              <RouterLink :to="{ name: 'PetitionDetail', params: { ID: petition.ID } }" class="btn btn-danger text-decoration-none"
                >Kampanyaya git</RouterLink
              >
            </div>
          </div>
        </template>
      </BrowsepetitionCard>
    </div>
    <div class="container-fluid mt-5" v-if="activeTab == 'succeded'">
      <BrowsepetitionCard v-for="petition in succededpetitions" :petition="petition">
        <template v-slot:browsepetitionCardImage>
          <img :src="petition.petitionImage" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
        </template>
        <template v-slot:browsepetitionCardHeader>
          <h5 class="card-title">{{ petition.petitionHeader }}</h5>
        </template>
        <template v-slot:browsepetitionCardContent>
          <p class="card-text">{{ petition.petitionContent }}</p>
        </template>
        <template v-slot:browsepetitionCardButton>
          <div class="row mt-2">
            <div class="col-12 text-center">
              <RouterLink :to="{ name: 'PetitionDetail', params: { ID: petition.ID } }" class="btn btn-danger text-decoration-none"
                >Kampanyaya git</RouterLink
              >
            </div>
          </div>
        </template>
      </BrowsepetitionCard>
    </div>
    <div class="row">
      <div class="col-12 text-center">
        <button class="btn btn-danger" @click="loadMorepetition">Daha fazla kampanya göster</button>
      </div>
    </div>
  </div>
  <Footer></Footer>
</template>

<script>
import Navbar from "../components/Shared/Navbar.vue";
import Footer from "../components/Shared/Footer.vue";
import BrowsepetitionCard from "../components/BrowsepetitionCard.vue";
export default {
  components: {
    Navbar,
    BrowsepetitionCard,
    Footer,
  },
  data() {
    return {
      activeTab: "newest",
      petitions: [],
      popularpetitions:[],
      succededpetitions:[],
      offset:0
    };
  },
  async beforeMount(){
    await this.getpetitions()
    await this.getPopularpetitions()
    await this.getSuccededpetitions()
  },
  methods: {
    changeActiveTab(tab) {
      if(this.activeTab!=tab) this.activeTab = tab;
    },
    loadMorepetition() {
      this.offset+=5
    },
    getpetitions(){
      this.$axios({
        method:"get",
        url:`/petitions/browsepetitions/newest`
      }).then((res) => {
        this.petitions=res.data.petitions
      })
    },
    getPopularpetitions(){
      this.$axios({
        method:"get",
        url:`/petitions/browsepetitions/popular`
      }).then((res) => {
        this.popularpetitions=res.data
      })
    },
    getSuccededpetitions(){
      this.$axios({
        method:"get",
        url:`/petitions/browsepetitions/succeded`
      }).then((res) => {
          this.succededpetitions=res.data
      })
    }
  },
};
</script>

<style>
#sections .active {
  color: var(--dark-red) !important;
}
#sections .browse-link {
  color: black;
}
</style>

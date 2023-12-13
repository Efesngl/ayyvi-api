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
    <!-- newest petites -->
    <div class="container-fluid mt-5" v-if="activeTab == 'newest'">
      <BrowsePetiteCard v-for="petite in petites" :petite="petite">
        <template v-slot:browsePetiteCardImage>
          <img :src="petite.petiteImage" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
        </template>
        <template v-slot:browsePetiteCardHeader>
          <h5 class="card-title">{{ petite.petiteHeader }}</h5>
        </template>
        <template v-slot:browsePetiteCardContent>
          <p class="card-text">{{ petite.petiteContent }}</p>
        </template>
        <template v-slot:browsePetiteCardButton>
          <div class="row mt-2">
            <div class="col-12 text-center">
              <RouterLink :to="{ name: 'PetiteDetailPage', params: { ID: petite.ID } }" class="btn btn-danger text-decoration-none"
                >Kampanyaya git</RouterLink
              >
            </div>
          </div>
        </template>
      </BrowsePetiteCard>
    </div>
    <div class="container-fluid mt-5" v-if="activeTab == 'popular'">
      <BrowsePetiteCard v-for="petite in popularPetites" :petite="petite">
        <template v-slot:browsePetiteCardImage>
          <img :src="petite.petiteImage" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
        </template>
        <template v-slot:browsePetiteCardHeader>
          <h5 class="card-title">{{ petite.petiteHeader }}</h5>
        </template>
        <template v-slot:browsePetiteCardContent>
          <p class="card-text">{{ petite.petiteContent }}</p>
        </template>
        <template v-slot:browsePetiteCardButton>
          <div class="row mt-2">
            <div class="col-12 text-center">
              <RouterLink :to="{ name: 'PetiteDetailPage', params: { ID: petite.ID } }" class="btn btn-danger text-decoration-none"
                >Kampanyaya git</RouterLink
              >
            </div>
          </div>
        </template>
      </BrowsePetiteCard>
    </div>
    <div class="container-fluid mt-5" v-if="activeTab == 'succeded'">
      <BrowsePetiteCard v-for="petite in succededPetites" :petite="petite">
        <template v-slot:browsePetiteCardImage>
          <img :src="petite.petiteImage" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
        </template>
        <template v-slot:browsePetiteCardHeader>
          <h5 class="card-title">{{ petite.petiteHeader }}</h5>
        </template>
        <template v-slot:browsePetiteCardContent>
          <p class="card-text">{{ petite.petiteContent }}</p>
        </template>
        <template v-slot:browsePetiteCardButton>
          <div class="row mt-2">
            <div class="col-12 text-center">
              <RouterLink :to="{ name: 'PetiteDetailPage', params: { ID: petite.ID } }" class="btn btn-danger text-decoration-none"
                >Kampanyaya git</RouterLink
              >
            </div>
          </div>
        </template>
      </BrowsePetiteCard>
    </div>
    <div class="row">
      <div class="col-12 text-center">
        <button class="btn btn-danger" @click="loadMorePetite">Daha fazla kampanya göster</button>
      </div>
    </div>
  </div>
  <Footer></Footer>
</template>

<script>
import Navbar from "../components/Shared/Navbar.vue";
import Footer from "../components/Shared/Footer.vue";
import BrowsePetiteCard from "../components/BrowsePetiteCard.vue";
export default {
  components: {
    Navbar,
    BrowsePetiteCard,
    Footer,
  },
  data() {
    return {
      activeTab: "newest",
      petites: [],
      popularPetites:[],
      succededPetites:[],
      offset:0
    };
  },
  async beforeMount(){
    await this.getPetites()
    await this.getPopularPetites()
    await this.getSuccededPetites()
  },
  methods: {
    changeActiveTab(tab) {
      if(this.activeTab!=tab) this.activeTab = tab;
    },
    loadMorePetite() {
      this.offset+=5
    },
    getPetites(){
      this.$axios({
        method:"get",
        url:`/petites/browsepetites/newest`
      }).then((res) => {
        this.petites=res.data.petites
      })
    },
    getPopularPetites(){
      this.$axios({
        method:"get",
        url:`/petites/browsepetites/popular`
      }).then((res) => {
        this.popularPetites=res.data
      })
    },
    getSuccededPetites(){
      this.$axios({
        method:"get",
        url:`/petites/browsepetites/succeded`
      }).then((res) => {
          this.succededPetites=res.data
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

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
            <RouterLink
              :to="{name:'BrowseNewestPetitions'}"
              class="nav-link browse-link"
              activeClass="active"
            >
              En yeniler
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink
              :to="{name:'BrowsePopularPetitions'}"
              class="nav-link browse-link"
              activeClass="active"
            >
              En popüler
            </RouterLink>
          </li>
          <li class="nav-item">
            <RouterLink
              :to="{name:'BrowseSuccededPetitions'}"
              class="nav-link browse-link"
              activeClass="active"
            >
              Başarılı
            </RouterLink>
          </li>
        </ul>
      </div>
    </div>
  </div>
  <RouterView></RouterView>
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

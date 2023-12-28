<template>
    <div class="container h-auto min-vh-100" style="height: 70vh" v-auto-animate>
        <div class="container-fluid mt-5">
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
        <div class="row">
            <div class="col-12 text-center">
                <button class="btn btn-danger" @click="loadMorepetition">Daha fazla kampanya göster</button>
            </div>
        </div>
    </div>
</template>

<script>
import BrowsepetitionCard from "../components/BrowsepetitionCard.vue";
export default {
    components: {
        BrowsepetitionCard,
    },
    data() {
        return {
            petitions: [],
        };
    },
    beforeMount(){
        this.getPetitions()
    },
    methods: {
        getPetitions() {
            this.$axios({
                method: "get",
                url: `/petitions/browsepetitions/newest`,
            }).then((res) => {
                this.petitions = res.data.petitions;
            });
        },
        loadMorepetition() {},
    },
};
</script>

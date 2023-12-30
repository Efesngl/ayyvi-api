<template>
    <BrowsepetitionCard v-for="petition in petitions" :petition="petition">
        <template v-slot:browsepetitionCardImage>
            <img :src="this.apiURL+petition.petitionImage" class="w-100 h-100 rounded-start" style="object-fit: fill" alt="..." />
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
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-danger w-50" @click="getPetitions((this.offset += 5))">Daha fazla kampanya göster</button>
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
            offset: 0,
            wasLastRequestEmpty: false,
        };
    },
    beforeMount() {
        this.getPetitions(0);
    },
    methods: {
        getPetitions(offset) {
            if (!this.wasLastRequestEmpty) {
                this.$axios({
                    method: "get",
                    url: `/petitions/browsepetitions/newest?offset=${offset}`,
                }).then((res) => {
                    if (offset == 0) {
                        this.petitions = res.data;
                    } else {
                        if (res.data.lenght > 0) {
                            this.petitions.push(res.data);
                        } else {
                            this.wasLastRequestEmpty = true;
                        }
                    }
                });
            }
        },
    },
};
</script>

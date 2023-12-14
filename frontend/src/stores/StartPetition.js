import { defineStore } from "pinia";

export const useStartPetition = defineStore("startPetition", {
    state: () => ({
        petition: {
            petitionTopic: null,
            petitionHeader: null,
            petitionLocation: null,
            petitionType: null,
            petitionContent: null,
            petitionImage: {
                size: 0,
                extension: null,
                name: null,
                url: null,
            },
            targetSign:10
        },
        formStep: 1,
    }),
    persist: true,
    getters: {},
    actions: {},
});

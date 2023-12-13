import { defineStore } from "pinia";

export const usePetiteInfo = defineStore("petiteInfo", {
    state: () => ({
        petite: {
            petiteTopic: null,
            petiteHeader: null,
            petiteLocation: null,
            petiteType: null,
            petiteContent: null,
            petiteImage: {
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

<template>
    <Navbar></Navbar>
    <div class="container min-vh-100">
        <div class="row mt-3">
            <div class="col-12 text-center">
                <h2>{{ petiteInfo.petiteHeader }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-8" id="petiteContent">
                <div class="row">
                    <div class="col-12">
                        <img :src="petiteInfo.petiteImage" class="w-100 h-100" style="object-fit: fill" alt="" />
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-12 fs-5">
                        <span v-html="petiteInfo.petiteContent"></span>
                    </div>
                </div>
            </div>
            <!-- sign petite desktop -->
            <div class="col-4 d-none d-md-block">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img :src="petiteInfo.userPP" class="petite-creator-logo" alt="" />
                        </div>
                        <div class="col-10 fs-5 d-flex align-items-center">
                            <span>{{ petiteInfo.creator }}</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small
                                ><span>Oluşturulma tarihi : {{ petiteInfo.createdAt }}</span></small
                            >
                        </div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-danger" :style="{ width: SignProgress + '%' }"></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <small> {{ petiteInfo.totalSigned }} kişi bu kampanyaya katıldı</small>
                        </div>
                        <div class="col-6 text-end">
                            <small>Toplam hedef {{ petiteInfo.targetSign }} imza</small>
                        </div>
                    </div>
                    <div v-if="user.isLogged">
                        <div v-if="!petiteInfo.doesBelongToUser">
                            <div class="row mt-5" v-if="!isSigned">
                                <div class="col-12">
                                    <h6>Kampanyaya katılma nedeni (zorunlu değil)</h6>
                                    <small v-if="signReason.isReasonEmpty" class="text-danger"
                                        >Katılım nedeninizin görünmesini istiyorsanız bu alanı doldurmak zorunludur*</small
                                    >
                                    <textarea
                                        name="reason"
                                        v-model="signReason.reason"
                                        id="reason"
                                        style="resize: vertical"
                                        class="form-control w-100"
                                        maxlength="100"
                                    ></textarea>
                                    <div class="row">
                                        <div class="col text-end">{{ signReasonReaminingWord }} kelime</div>
                                    </div>
                                    <input
                                        type="checkbox"
                                        v-model="signReason.willShown"
                                        name="will_show"
                                        id="will_show"
                                        class="form-check-input me-1"
                                    />
                                    <label for="will_show" class="form-check-label">Kampanyaya katılma sebebimi bu kampanyada göster</label>
                                </div>
                            </div>
                            <div class="row mt-2" v-if="!petiteInfo.isSucceded">
                                <div class="col-12" v-auto-animate>
                                    <button class="btn btn-danger w-100" @click="signPetite" v-if="!isSigned">Kampanyaya katıl</button>
                                    <button class="btn btn-outline-danger w-100" @click="unSignPetite" v-else>
                                        Kampanyaya katılındı <i class="bi bi-check2-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div v-else>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <button class="btn btn-danger text-white w-100">Kampanyayı düzenle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="row">
                            <div class="col-12 text-center fs-3 text-danger">İmza atmak için giriş yapmalısınız !</div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 text-center" v-if="petiteInfo.isSucceded">
                            <span class="text-danger rounded fs-3">Bu kampanya başarıya ulaştı <i class="bi bi-balloon-heart-fill"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- petite sign mobile -->
        <div class="row d-block d-md-none">
            <div class="col-12">
                <div class="container">
                    <div class="row">
                        <div class="col-2">
                            <img :src="petiteInfo.userPP" class="petite-creator-logo" alt="" />
                        </div>
                        <div class="col-10 fs-5 d-flex align-items-center">
                            <span>{{ petiteInfo.creator }}</span>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <small
                                ><span>Oluşturulma tarihi : {{ petiteInfo.createdAt }}</span></small
                            >
                        </div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar bg-danger" :style="{ width: SignProgress + '%' }"></div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <small> {{ petiteInfo.totalSigned }} kişi bu kampanyaya katıldı</small>
                        </div>
                        <div class="col-6 text-end">
                            <small>Toplam hedef {{ petiteInfo.targetSign }} imza</small>
                        </div>
                    </div>
                    <div v-if="user.isLogged">
                        <div class="row mt-5" v-if="!isSigned">
                            <div class="col-12">
                                <h6>Kampanyaya katılma nedeni (zorunlu değil)</h6>
                                <small v-if="signReason.isReasonEmpty" class="text-danger"
                                        >Katılım nedeninizin görünmesini istiyorsanız bu alanı doldurmak zorunludur*</small
                                    >
                                <textarea
                                    name="reason"
                                    v-model="signReason.reason"
                                    id="reason"
                                    style="resize: vertical"
                                    class="form-control w-100"
                                    maxlength="100"
                                ></textarea>
                                <div class="row">
                                    <div class="col text-end">{{ signReasonReaminingWord }} kelime</div>
                                </div>
                                <input type="checkbox" v-model="signReason.willShown" name="will_show" id="will_show" class="form-check-input me-1" />
                                <label for="will_show" class="form-check-label">Kampanyaya katılma sebebimi bu kampanyada göster</label>
                            </div>
                        </div>
                        <div class="row mt-2" v-if="!petiteInfo.isSucceded">
                            <div class="col-12" v-auto-animate>
                                <button class="btn btn-danger w-100" @click="signPetite" v-if="!isSigned">Kampanyaya katıl</button>
                                <button class="btn btn-outline-danger w-100" @click="unSignPetite" v-else>
                                    Kampanyaya katılındı <i class="bi bi-check2-circle"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="row">
                            <div class="col-12 text-center fs-3 text-danger">Kampanyayı imzalamak için giriş yapmalısınız !</div>
                        </div>
                    </div>
                    <div class="row" v-if="petiteInfo.isSucceded">
                        <div class="col-12 text-center">
                            <span class="text-danger rounded fs-3">Bu kampanya başarıya ulaştı <i class="bi bi-balloon-heart-fill"></i></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div id="comments" v-if="signReasons.length > 0">
            <div class="row mt-3">
                <div class="col-12">
                    <h2>Katılma nedenleri</h2>
                </div>
            </div>
            <PetiteCommentsCard v-for="signReason in signReasons" :comment="signReason"></PetiteCommentsCard>
            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-danger w-50" @click="seeMoreComment">Daha fazla neden göster</button>
                </div>
            </div>
        </div>
        <div id="comments" v-else>
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <h2>Bu kampanya için gösterilebilecek bir katılma nedeni yoktur</h2>
                </div>
            </div>
        </div>
    </div>
    <Footer></Footer>
</template>

<script>
import Navbar from "../components/Shared/Navbar.vue";
import Footer from "../components/Shared/Footer.vue";
import PetiteCommentsCard from "../components/PetiteCommentsCard.vue";
import { useUserStore } from "../stores/UserStore";
export default {
    components: {
        Navbar,
        Footer,
        PetiteCommentsCard,
    },
    data() {
        return {
            user: useUserStore(),
            petiteInfo: {},
            signReason: {
                reason: "",
                willShown: false,
                isReasonEmpty: false,
                reaminingWord: 100,
            },
            isSigned: true,
            signReasons: [],
        };
    },
    computed: {
        SignProgress() {
            return (this.petiteInfo.totalSigned / this.petiteInfo.targetSign) * 100;
        },
        signReasonReaminingWord() {
            return 100 - this.signReason.reason.length;
        },
    },
    async beforeMount() {
        await this.getPetiteDetail();
        await this.getPetiteSignReasons();
    },
    methods: {
        getPetiteDetail() {
            this.$axios({
                method: "get",
                url: `/petites/petitedetail/${this.$route.params.ID}?user=${useUserStore().ID}`,
            }).then((res) => {
                this.petiteInfo = res.data.petite[0];
                this.isSigned = res.data.petite[0]["isSigned"];
            });
        },
        getPetiteSignReasons() {
            let data = {
                petiteID: this.$route.params.ID,
            };
            if (this.user.isLogged) {
                data.userID = this.user.ID;
            }
            this.$axios({
                method: "post",
                url: "/petites/petitesignreasons",
                data: data,
            }).then((res) => {
                console.log(res.data);
                this.signReasons = res.data;
            });
        },
        seeMoreComment() {
            for (let i = 0; i < 5; i++) {
                this.comments.push({
                    user: {
                        firstname: "Efe",
                        lastname: "Şengül",
                        image: "/img/user_logos/1.jpg",
                    },
                    comment:
                        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque pellentesque pulvinar neque, eu congue ligula cursus et. Nullam tincidunt sit amet ante eu eleifend. Cras lorem mi, varius id lacus et, aliquet vestibulum massa. Nam quis dolor euismod, semper quam sed, iaculis risus. Nullam quam dui, finibus sed libero ac, tempus pulvinar ligula. Pellentesque vel euismod nisl. Aenean accumsan consectetur lacus sit amet porttitor. Vestibulum vulputate, quam in varius finibus, turpis orci interdum turpis, aliquam rhoncus lectus magna tincidunt mi. Nam eu tempor metus. Duis pharetra ipsum ac est aliquam feugiat sit amet vel purus. In consequat et ex vitae.",
                    commented_at: "19/11/2023",
                    likes: 1,
                    isLiked: true,
                });
            }
        },
        async signPetite() {
            this.signReason.isReasonEmpty = false;
            let data = {
                petiteID: this.$route.params.ID,
                userID: useUserStore().ID,
            };
            if (this.signReason.willShown == true && this.signReason.reason == "") {
                console.log("if");
                this.signReason.isReasonEmpty = true;
            } else if (this.signReason.willShown == true && this.signReason.reason != "") {
                console.log("else if");
                data.signReason = {
                    reason: this.signReason.reason,
                    willShowed: this.signReason.willShown,
                };
            }
            await this.$axios({
                method: "post",
                url: "/petites/sign",
                data: {
                    data: data,
                },
            }).then((res) => {
                if (res.status == 201) {
                    this.petiteInfo.totalSigned++;
                    this.isSigned = true;
                }
            });
        },
        async unSignPetite() {
            await this.$axios({
                method: "post",
                url: "/petites/unsign",
                data: {
                    data: {
                        petiteID: this.$route.params.ID,
                        userID: useUserStore().ID,
                    },
                },
            }).then((res) => {
                if (res.status == 200) {
                    this.petiteInfo.totalSigned--;
                    this.isSigned = false;
                }
            });
        },
    },
};
</script>
<style>
.petite-comment-user-logo {
    max-width: 2rem;
    max-height: 2rem;
    border-radius: 50%;
}
.petite-creator-logo {
    max-width: 3rem;
    max-height: 3rem;
    border-radius: 50%;
}
</style>

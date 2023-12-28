<template>
    <Navbar></Navbar>
    <div class="container h-auto">
        <h2 class="text-center">Kampanya düzenle</h2>
        <div class="row">
            <div class="col-12 col-md-6">
                <label for="petition-location">Kampanya kapsamı</label>
                <select class="form-select" name="petition-location">
                    <option selected>Kampanya kapsamı</option>
                    <option value="1">Yerel</option>
                    <option value="2">Ulusal</option>
                    <option value="3">Global</option>
                </select>
                <label for="petition-topic">Kampanya konusu</label>
                <p class="text-danger" v-if="!errors.isTopicSelected">Kampanya konusu seçmek zorunludur !</p>
                <select class="form-select" name="petition-topic" v-model="petitionInfo.petitionTopic">
                    <option :value="0" selected>Kampanya konusu</option>
                    <option :value="t.ID" :selected="petitionInfo.petitionTopic == t.ID" v-for="t in topics">{{ t.topic }}</option>
                </select>
                <label for="petition-header">Kampanya başlığı</label>
                <p class="text-danger" v-if="errors.isHeaderEmpty">Kampanya başlığı girmek zorunludur !</p>
                <input type="text" v-model="petitionInfo.petitionHeader" name="petition-header" id="" class="form-control" />
                <label for="petition-location">Hedef imza sayısı</label>
                <p class="text-danger" v-if="errors.isTargetSignEmpty">Hedef imza sayısı belirlemek zorunludur !</p>
                <input type="number" v-model="petitionInfo.targetSign" min="10" name="petition-image" id="" class="form-control" />
                <div class="progress mt-1" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar bg-danger" :style="{ width: progress + '%' }"></div>
                </div>
                <span>{{ petitionInfo.totalSigned }} kişi imzaladı</span>
            </div>
            <div class="col-6 d-none d-md-block">
                <label for="petition-location">Kampanya resmi</label>
                <ImageUpload :maxSize="5" ref="imageUploader" buttontxt="Görseli değiştir"></ImageUpload>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-6">
                <div class="form-check form-switch">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        role="switch"
                        :true-value="1"
                        :false-value="0"
                        id="flexSwitchCheckChecked"
                        v-model="petitionInfo.isSucceded"
                        :checked="petitionInfo.isSucceded == 1"
                    />
                    <label class="form-check-label" for="flexSwitchCheckChecked">Kampanya başarılı</label>
                </div>
            </div>
            <div class="col-6" v-if="petitionInfo.success">
                <p v-if="petitionInfo.isSuccessAllowed==0" class="text-primary">Kampanya başarı durumu inceleniyor !</p>
                <p v-if="petitionInfo.isSuccessAllowed==1" class="text-success">Kampanya başarısı onaylandı !</p>
                <p v-if="petitionInfo.isSuccessAllowed==2" class="text-danger">Kampanya başarısı onaylanmadı !</p>
            </div>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12">
                <label for="petition-location">Kampanya resmi</label>
                <ImageUpload :maxSize="5" ref="imageUploader" buttontxt="Görseli değiştir"></ImageUpload>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="petition-content">Kampanya içeriği</label>
                <p class="text-danger" v-if="errors.isContentEmpty">Kampanya içeriği girmek zorunludur !</p>
                <ckeditor :editor="editor" v-model="petitionInfo.petitionContent" tag-name="petite-content" :config="editorConfig"></ckeditor>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-6 text-center">
                <button class="btn btn-primary" @click="updatePetition">Kaydet</button>
            </div>
            <div class="col-6 text-center">
                <button class="btn btn-danger" @click="deletePetition">Kampanyayı sil</button>
            </div>
        </div>
    </div>
    <Footer></Footer>
</template>

<script>
import Navbar from "../components/Shared/Navbar.vue";
import Footer from "../components/Shared/Footer.vue";
import "@ckeditor/ckeditor5-build-classic/build/translations/tr.js";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import CKEditor from "@ckeditor/ckeditor5-vue";
import ImageUpload from "../components/ImageUpload.vue";
import { computed } from "vue";
export default {
    components: {
        ImageUpload,
        Navbar,
        Footer,
        ckeditor: CKEditor.component,
    },
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                toolbar: {
                    items: ["undo", "redo", "|", "heading", "|", "bold", "italic", "|", "bulletedList", "numberedList", "outdent", "indent"],
                },
                language: "tr",
            },
            petitionInfo: [],
            topics: [],
            errors: {
                isTopicSelected: true,
                isHeaderEmpty: false,
                isContentEmpty: false,
            },
            petition:[]
        };
    },
    async beforeMount() {
        await this.getPetitionInfo();
        await this.getTopics();
    },
    methods: {
        getTopics() {
            this.$axios.get("gettopics").then((res) => {
                this.topics = res.data.topics;
            });
        },
        getPetitionInfo() {
            this.$axios.get(`petitions/petitiondetail/${this.$route.params.ID}?type=edit`).then((res) => {
                this.petitionInfo = res.data.petition[0];
            });
        },
        isTopicSelected() {
            if (this.petitionInfo.petitionTopic == 0) {
                this.errors.isTopicSelected = false;
            }
        },
        isHeaderEmpty() {
            if (!/([^\s])/.test(this.petitionInfo.petitionHeader)) {
                this.errors.isHeaderEmpty = true;
            }
        },
        isContentEmpty() {
            if (!/([^\s])/.test(this.petitionInfo.petitionContent)) {
                this.errors.isContentEmpty = true;
            }
        },
        checkErrors() {
            this.errors = {
                isTopicSelected: true,
                isHeaderEmpty: false,
                isContentEmpty: false,
            };
            this.isContentEmpty();
            this.isHeaderEmpty();
            this.isTopicSelected();
            for (let e in this.errors) {
                console.log(`${e} : ${this.errors[e]}`);
                if (e == "isTopicSelected") {
                    if (this.errors[e] == false) {
                        console.log(e + " hata var");
                        return false;
                    }
                } else {
                    if (this.errors[e] == true) {
                        console.log(e + " hata var");
                        return false;
                    }
                }
            }
            return true;
        },
        updatePetition() {
            if (this.checkErrors()) {
                this.$axios({
                    method: "post",
                    url: "petitions/updatepetition",
                    data: {
                        petition: this.petitionInfo,
                    },
                }).then((res) => {
                    let s = this.$swal.mixin({
                        toast: true,
                        position: "top-end",
                        iconColor: "white",
                        color: "white",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                    });
                    if (res.status == 200) {
                        s.fire({
                            background: "var(--bs-teal)",
                            icon: "success",
                            title: "Güncelleme işlemi başarılı !",
                        });
                    } else {
                        s.fire({
                            background: "var(--bs-danger)",
                            icon: "error",
                            title: res.data.error,
                        });
                    }
                });
                // this.$axios.post("petitions/updatepetition",{"petition":this.petitionInfo}).then(res=>{
                //     console.log(res.data);
                // })
            }
        },
        deletePetition() {
            this.$swal
                .fire({
                    text: "Bu kampanyayı silmek üzeresiniz !",
                    title: "Dikkat bu işlem geri alınamaz !",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "İptal",
                    confirmButtonText: "Kampanyayı sil",
                    confirmButtonColor: "var(--bs-danger)",
                    cancelButtonColor: "var(--bs-primary)",
                })
                .then((res) => {
                    if (res.isConfirmed) {
                        this.$axios.post("petitions/deletepetition", { ID: this.petitionInfo.ID }).then((res) => {
                            if (res.status == 200) {
                                this.$swal.fire({
                                    title: "Kampanya başarıyla silindi.",
                                    icon: "success",
                                    confirmButtonText: "Tamam",
                                    confirmButtonColor: "var(--bs-teal)",
                                }).then(res=>{
                                    this.$router.push({name:"MyPetitions"})
                                })
                            }else{
                                this.$swal.fire({
                                    title: "Kampanya silme işleminde bir hata oluştu !",
                                    text:"Lütfen daha sonra tekrardan deneyiniz.",
                                    icon: "error",
                                    confirmButtonText: "Tamam",
                                    confirmButtonColor: "var(--bs-teal)",
                                })
                            }
                        });
                    }
                });
        },
    },
    provide() {
        return {
            petitionEditInfo: computed(() => this.petitionInfo),
        };
    },
    computed: {
        progress() {
            return (this.petitionInfo.totalSigned / this.petitionInfo.targetSign) * 100;
        },
    },
};
</script>
<style>
.ck-editor__editable_inline {
    height: 25rem;
}
</style>

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
                <select class="form-select" name="petition-location">
                    <option selected>Kampanya konusu</option>
                    <option :value="t.ID" :selected="petitionInfo.petitionTopic == t.ID" v-for="t in topics">{{ t.topic }}</option>
                </select>
                <label for="petition-header">Kampanya başlığı</label>
                <input type="text" v-model="petitionInfo.petitionHeader" name="petition-header" id="" class="form-control" />
                <label for="petition-location">Hedef imza sayısı</label>
                <input type="number" v-model="petitionInfo.targetSign" min="10" name="petition-image" id="" class="form-control" />
                <div class="progress mt-1" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-danger" :style="{'width': progress+'%'}"></div>
                </div>
                <span>500 kişi imzaladı</span>
            </div>
            <div class="col-6 d-none d-md-block">
                <label for="petition-location">Kampanya resmi</label>
                <ImageUpload :maxSize="5" ref="imageUploader"></ImageUpload>
            </div>
        </div>
        <div class="row d-block d-md-none">
            <div class="col-12">
                <label for="petition-location">Kampanya resmi</label>
                <ImageUpload :maxSize="5" ref="imageUploader"></ImageUpload>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label for="petition-content">Kampanya içeriği</label>
                <ckeditor :editor="editor" v-model="petitionInfo.petitionContent" tag-name="petite-content" :config="editorConfig"></ckeditor>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-center">
                <button class="btn btn-danger">Kaydet</button>
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
                    items: [
                        "undo",
                        "redo",
                        "|",
                        "heading",
                        "|",
                        "bold",
                        "italic",
                        "strikethrough",
                        "subscript",
                        "superscript",
                        "code",
                        "|",
                        "bulletedList",
                        "numberedList",
                        "todoList",
                        "outdent",
                        "indent",
                    ],
                },
                language: "tr",
            },
            petitionInfo: [],
            topics: [],
        };
    },
    computed:{
      progress(){
        return (500/this.petitionInfo.targetSign)*100
      }
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
    },
};
</script>
<style>
.ck-editor__editable_inline {
    height: 25rem;
}
</style>

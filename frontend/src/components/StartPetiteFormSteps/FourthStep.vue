<template>
  <div class="mt-5 container w-75 h-100 d-flex flex-column justify-content-between" id="start-petite-form">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="fs-1">Kampanyanın içeriğinden bahsedin</h2>
      </div>
    </div>
    <div class="row" v-if="isPetiteContentEmpty">
      <div class="col-12">
        <span class="text-danger">{{ errors[0] }}</span>
      </div>
    </div>
    <div class="row flex-fill mb-5">
      <div class="col-12 h-100">
        <ckeditor :editor="editor" v-model="petiteInfo.petite.petiteContent" :config="editorConfig"></ckeditor>
      </div>
    </div>
    <div class="row mt-3 justify-content-between">
      <div class="col-6">
        <button class="btn btn-danger" @click="decStep">Önceki adım</button>
      </div>
      <div class="col-6 text-end">
        <button class="btn btn-danger" @click="incStep">Sonraki adım</button>
      </div>
    </div>
  </div>
</template>

<script>
import '@ckeditor/ckeditor5-build-classic/build/translations/tr.js';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKEditor from "@ckeditor/ckeditor5-vue"
import { usePetiteInfo } from "../../stores/StartPetite";
export default {
  inject: ["formStep", "decStep"],
  components: {
    ckeditor:CKEditor.component
  },
  data() {
    return {
      petiteInfo:usePetiteInfo(),
      errors: [],
      editor:ClassicEditor,
      editorConfig:{
        toolbar:{
          items:[
          'undo', 'redo',
          '|', 'heading',
          '|', 'bold', 'italic', 'strikethrough', 'subscript', 'superscript', 'code',
          '|', 'bulletedList', 'numberedList', 'todoList', 'outdent', 'indent'
          ]
        },
        language:"tr"
      }
    };
  },
  methods: {
    isPetiteContentEmpty() {
      this.errors = [];
      if (this.petiteInfo.petite.petiteContent == null) {
        this.errors.push("Lütfen kampanya ile ilgili biraz bilgi girin !");
        return true;
      }
      return false;
    },
    incStep() {
      if (!this.isPetiteContentEmpty()) {
        this.$emit("incStepOk");
      }
    },
  },
};
</script>

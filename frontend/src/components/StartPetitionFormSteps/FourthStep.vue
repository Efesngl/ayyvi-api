<template>
  <div class="mt-5 container w-75 h-100 d-flex flex-column justify-content-between" id="start-petition-form">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="fs-1">Kampanyanın içeriğinden bahsedin</h2>
      </div>
    </div>
    <div class="row" v-if="ispetitionContentEmpty">
      <div class="col-12">
        <span class="text-danger">{{ errors[0] }}</span>
      </div>
    </div>
    <div class="row flex-fill mb-5">
      <div class="col-12 h-100">
        <ckeditor :editor="editor" v-model="petitionInfo.petition.petitionContent" :config="editorConfig"></ckeditor>
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
import { useStartPetition } from "../../stores/Startpetition";
export default {
  inject: ["formStep", "decStep"],
  components: {
    ckeditor:CKEditor.component
  },
  data() {
    return {
      petitionInfo:useStartPetition(),
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
    ispetitionContentEmpty() {
      this.errors = [];
      if (this.petitionInfo.petition.petitionContent == null) {
        this.errors.push("Lütfen kampanya ile ilgili biraz bilgi girin !");
        return true;
      }
      return false;
    },
    incStep() {
      if (!this.ispetitionContentEmpty()) {
        this.$emit("incStepOk");
      }
    },
  },
};
</script>
../../stores/StartPetition
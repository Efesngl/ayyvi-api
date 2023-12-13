<template >
    <div class="mt-5 container w-75 h-100 d-flex flex-column justify-content-between" id="start-petite-form">
        <div class="row">
          <div class="col-12 text-center">
            <h2 class="fs-1">Kampanya için bir görsel ekleyin</h2>
          </div>
        </div>
        <div class="row" v-if="errors.length>0">
          <div class="col-12 text-center">
            <span class="text-danger">
              {{ errors[0] }}
            </span>
          </div>
        </div>
        <div class="row">
          <div class="col-12 flex-fill h-100">
            <ImageUpload :maxSize=5 ref="imageUploader"></ImageUpload>
          </div>
        </div>
        <div class="row justify-content-between" >
          <div class="col-6" >
            <button class="btn btn-danger" @click="decStep">Önceki adım</button>
          </div>
          <div class="col-6 text-end">
            <button class="btn btn-danger" @click="incStep">Sonraki adım</button>
          </div>
        </div>
    </div>
  </template>

<script>
import { usePetiteInfo } from '../../stores/StartPetite';
import ImageUpload from '../ImageUpload.vue';
  export default{
    components:{
      ImageUpload
    },
    data(){
      return {
        petiteInfo:usePetiteInfo(),
        errors:[]
      }
    },
    inject:["decStep"],
    methods:{
      checkErrors(){
        this.errors=[]
        if(!this.$refs.imageUploader.checkErrors()){
          this.errors.push("Lütfen kampanya için bir resim yükleyiniz")
          return false
        }
        return true
      },
      incStep(){
        if(this.checkErrors()){
          this.$emit("incStepOk")
        }
      }
    }
  }
</script>
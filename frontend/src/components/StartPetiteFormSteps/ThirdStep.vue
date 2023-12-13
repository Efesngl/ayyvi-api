<template>
  <div class="container w-75" id="start-petite-form">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="fs-1">Kampanya başlığını yaz</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <label for="petite-header"><small>Kampanya başlığı</small></label>
        <div class="row" v-if="errors.length>0">
          <div class="col-12">
            <span class="text-danger">{{ errors[0] }}</span>
          </div>
        </div>
        <input type="text" v-model="petiteInfo.petite.petiteHeader" class="form-control" name="petite-header" id="petite-header" />
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
import { usePetiteInfo } from '../../stores/StartPetite'

  export default{
    inject:["formStep","decStep"],
    data(){
      return {
        petiteInfo:usePetiteInfo(),
        errors:[]
      }
    },
    methods:{
      isPetiteHeaderEmpty(){
        this.errors=[]
        if(this.petiteInfo.petite.petiteHeader==null || this.petiteInfo.petite.petiteHeader==""){
          this.errors.push("Lütfen kampanya başlığı giriniz !")
          return true
        }
        return false
      },
      incStep(){
        if(!this.isPetiteHeaderEmpty()){
          this.$emit("incStepOk")
        }
      }
    }
  }
</script>
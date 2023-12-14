<template>
  <div class="container w-75" id="start-petition-form">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="fs-1">Kampanya başlığını yaz</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <label for="petition-header"><small>Kampanya başlığı</small></label>
        <div class="row" v-if="errors.length>0">
          <div class="col-12">
            <span class="text-danger">{{ errors[0] }}</span>
          </div>
        </div>
        <input type="text" v-model="petitionInfo.petition.petitionHeader" class="form-control" name="petition-header" id="petition-header" />
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
import { useStartPetition } from '../../stores/StartPetition'

  export default{
    inject:["decStep"],
    data(){
      return {
        petitionInfo:useStartPetition(),
        errors:[]
      }
    },
    methods:{
      ispetitionHeaderEmpty(){
        this.errors=[]
        if(this.petitionInfo.petition.petitionHeader==null || this.petitionInfo.petition.petitionHeader==""){
          this.errors.push("Lütfen kampanya başlığı giriniz !")
          return true
        }
        return false
      },
      incStep(){
        if(!this.ispetitionHeaderEmpty()){
          this.$emit("incStepOk")
        }
      }
    }
  }
</script>
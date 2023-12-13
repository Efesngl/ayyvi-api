<template>
  <div class="mt-5 container w-75 h-100 d-flex flex-column justify-content-between" id="start-petite-form">
    <div class="row">
      <div class="col-12 text-center">
        <h2 class="fs-1">Son olarak kampanyanın alması gereken hedef bir imza giriniz</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12 text-center">
        <p>Kampanyanızın herkese görünmesi için en az 10 kişi katılması gerekmektedir !</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <input type="number" min="10" class="form-control" name="target-sign" id="target-sign" v-model="targetSign" @keyup="checkNumber">
      </div>
    </div>
    <div class="row justify-content-between">
      <div class="col-6 text-center">
        <button class="btn btn-danger" @click="decStep">Önceki adım</button>
      </div>
      <div class="col-6 text-center">
        <button class="btn btn-danger" @click="incStep">Sonraki adım</button>
      </div>
    </div>
  </div>
</template>

<script>
import {RouterLink} from "vue-router"
import { usePetiteInfo } from "../../stores/StartPetite";
export default {
  data() {
    return {
      petiteStore:usePetiteInfo(),
      targetSign:10
    };
  },
  inject: ["decStep"],
  methods: {
    checkNumber(){
      if(this.targetSign<10){
        this.targetSign=10
      }
    },
    isNumberValid(){
      if(this.targetSign>=10) return true
      return false
    },
    incStep(){
      if(this.isNumberValid()){
        this.petiteStore.petite.targetSign=this.targetSign
        this.$emit("incStepOk")
      }
    }
  },
};
</script>

<template>
  <div class="container w-75" id="start-petite-form">
    <div class="row">
      <div class="col-12">
        <h2 class="fs-1">Lütfen kampanyanıza en uygun konu başlığını seçiniz</h2>
      </div>
    </div>
    <div class="row" v-if="errors.length>0">
      <div class="col-12">
        <span class="text-danger">{{ errors[0] }}</span>
      </div>
    </div>
    <div class="row mt-3 g-1 justify-content-between">
      <div class="col" v-for="(t, index) in topics">
        <input @click="setTopic(t.ID)" type="radio" class="btn-check" name="topics" :id="'topic' + index" autocomplete="off" :checked="petiteInfo.petite.petiteTopic==t.ID" />
        <label class="btn btn-outline-danger w-100 h-100" :for="'topic' + index">{{ t.topic }}</label>
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
import { usePetiteInfo } from '../../stores/StartPetite';
import { useUserStore } from '../../stores/UserStore';
export default {
  inject: ["formStep", "decStep"],
  data(){
    return{
      petiteInfo:usePetiteInfo(),
      useStore:useUserStore(),
      topics: [],
      errors:[]
    }
  },
  beforeMount(){
    this.getTopics()
  },
  methods: {
    setTopic(t) {
      this.petiteInfo.petite.petiteTopic = t;
    },
    isTopicSelected(){
      this.errors=[]
      if(this.petiteInfo.petite.petiteTopic==null){
        this.errors.push("Lütfen bir kampanya konusu seçiniz")
        return false
      }
      return true
    },
    getTopics(){
      this.$axios({
        method:"get",
        url:"/gettopics"
      }).then(res=>{
        this.topics=res.data.topics
      })
    },
    incStep(){
      if(this.isTopicSelected()){
        this.$emit("incStepOk")
      }
    }
  },
};
</script>

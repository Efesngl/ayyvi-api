<template>
  <div class="container w-75" id="start-petition-form">
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
        <input @click="setTopic(t.ID)" type="radio" class="btn-check" name="topics" :id="'topic' + index" autocomplete="off" :checked="petitionInfo.petition.petitionTopic==t.ID" />
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
import { useStartPetition } from '../../stores/StartPetition';
import { useUserStore } from '../../stores/UserStore';
export default {
  inject: ["decStep"],
  data(){
    return{
      petitionInfo:useStartPetition(),
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
      this.petitionInfo.petition.petitionTopic = t;
    },
    isTopicSelected(){
      this.errors=[]
      if(this.petitionInfo.petition.petitionTopic==null){
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
<template>
  <div class="row mb-2">
    <div class="col-12">
      <div class="card w-100">
        <div class="card-body">
          <div class="card-header">
            <div class="row gx-2">
              <div class="col-1" style="max-width: max-content">
                <img :src="comment.userPP" class="petite-comment-user-logo" alt="" />
              </div>
              <div class="col d-flex align-items-center">
                <span>{{ comment.signer }}</span>
              </div>
            </div>
          </div>
          <p class="card-text p-1 ps-3">{{ comment.reason }}</p>
          <div class="row p-1" v-if="user.isLogged">
            <div class="col-12">
              <span v-auto-animate>
                <i class="bi bi-heart-fill text-danger" @click="unlike(comment)" v-if="comment.isLiked"></i>
                <i class="bi bi-heart" @click="like(comment)" v-else></i>
                {{ comment.likes }}
              </span>
            </div>
          </div>
          <div class="row p-1" v-else>
            <div class="col-12">
              <span class="text-danger">
                Bu yorumu beğenmek için giriş yapmalısınız !
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '../stores/UserStore';
export default {
  props: {
    comment: Object,
  },
  data(){
    return {
      user:useUserStore()
    }
  },
  methods: {
    like(c) {
      let data={
        reasonID:this.comment.reason_id
      }
      if(this.user.isLogged){
        data.userID=this.user.ID
      }
      this.$axios({
        method:"post",
        url:"/petites/likesignreason",
        data:data
      }).then(res=>{
        c.isLiked = true;
        c.likes++;
      })
    },
    unlike(c) {
      let data={
        reasonID:this.comment.reason_id
      }
      if(this.user.isLogged){
        data.userID=this.user.ID
      }
      this.$axios({
        method:"post",
        url:"/petites/unlikesignreason",
        data:data
      }).then(res=>{
        c.isLiked = false;
        c.likes--;
      })
    },
  },
};
</script>

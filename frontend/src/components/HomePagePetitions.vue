<template>
  <div class="col">
    <RouterLink :to="{name:'PetitionDetail',params:{ID:petition.ID}}" class="text-decoration-none">
      <div class="card h-100 hp">
        <img :src="petition.petitionImage" class="card-img-top" alt="..." />
        <div class="card-body">
          <h5 class="card-title">{{ petition.petitionHeader }}</h5>
          <p class="card-text">
            {{ petition.petitionContent }}
          </p>
          <div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-danger" :style="{ 'width': progress+'%' }"></div>
          </div>
          <div class="row">
            <div class="col-12 fs-6">
              <small>{{ petition.targetSign }} imza hedefinden {{ petition.totalSigned }} imza</small>
            </div>
          </div>
          <button class="btn btn-danger mt-2">Kampanyaya git</button>
        </div>
        <div class="card-footer">
          <small>3 gün önce oluşturuldu</small>
        </div>
      </div>
    </RouterLink>
  </div>
</template>

<script>
export default {
  props: {
    petition:Object
  },
  computed:{
    progress(){
      return (this.petition.totalSigned/this.petition.targetSign)*100
    }
  }
};
</script>

<style>
.hp {
  transition: 0.2s;
}
.hp:hover {
  transform: scale(1.01);
}
</style>

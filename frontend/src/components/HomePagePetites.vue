<template>
  <div class="col">
    <RouterLink :to="{name:'PetiteDetailPage',params:{ID:petite.ID}}" class="text-decoration-none">
      <div class="card h-100 hp">
        <img :src="petite.petiteImage" class="card-img-top" alt="..." />
        <div class="card-body">
          <h5 class="card-title">{{ petite.petiteHeader }}</h5>
          <p class="card-text">
            {{ petite.petiteContent }}
          </p>
          <div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-danger" :style="{ 'width': progress+'%' }"></div>
          </div>
          <div class="row">
            <div class="col-12 fs-6">
              <small>{{ petite.targetSign }} imza hedefinden {{ petite.totalSigned }} imza</small>
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
    petite:Object
  },
  computed:{
    progress(){
      return (this.petite.totalSigned/this.petite.targetSign)*100
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

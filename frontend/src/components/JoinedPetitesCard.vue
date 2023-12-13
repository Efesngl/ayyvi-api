<template>
    <div class="row justify-content-center joined-petite-card">
      <div class="col-12 col-sm-8">
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-4">
              <slot name="browsePetiteCardImage"></slot>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <slot name="browsePetiteCardHeader"></slot>
                <slot name="browsePetiteCardContent"></slot>
                <p class="card-text"><small class="text-body-secondary">3 gün önce oluşturuldu</small></p>
                <div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-danger" :style="{ width: progress + '%' }"></div>
                </div>
                <div class="row mt-1">
                  <div class="col">
                    <span>{{ targetSign }}</span> imza hedefinden <span>{{ totalSigned }}</span> imzalandı
                  </div>
                </div>
                <slot name="browsePetiteCardButton"></slot>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
export default {
  props: {
    targetSign: Number,
    totalSigned: Number,
  },
  data() {
    return {
      progress: 0,
    };
  },
  beforeMount() {
    this.progress = (this.totalSigned / this.targetSign) * 100;
  },
};
</script>
<style>
.joined-petite-card {
  transition: 0.2s;
}

@media (any-pointer:none){
  .joined-petite-card:hover {
  transform: scale(1.1);
}
.joined-petite-card:hover .card-title {
  color: var(--bs-red);
}
}
</style>

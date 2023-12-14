<template>
  <div class="row justify-content-center">
    <div class="col-12 col-md-8">
      <div class="card mb-3">
        <div class="row g-0">
          <div class="col-md-4">
            <slot name="browsepetitionCardImage"></slot>
            
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <slot name="browsepetitionCardHeader"></slot>
              <slot name="browsepetitionCardContent"></slot>
              <p class="card-text"><small class="text-body-secondary">3 gün önce oluşturuldu</small></p>
              <div class="progress" role="progressbar" aria-label="Danger example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar bg-danger" :style="{width:progress+'%'}"></div>
              </div>
              <div class="row mt-1">
                <div class="col"><span>{{petition.targetSign}}</span> imza hedefinden <span>{{petition.totalSigned }}</span> imzalandı</div>
              </div>
              <slot name="browsepetitionCardButton"></slot>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default{
    props:{
      petition:Object
    },
    computed:{
      progress(){
        return (this.petition.totalSigned/this.petition.targetSign)*100
      }
    }
  }
</script>
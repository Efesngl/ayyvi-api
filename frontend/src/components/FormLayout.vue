<template>
  <div class="container min-vh-100 h-auto">
    <div class="row">
      <div class="col-12">
        <div class="progress" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 0.5rem;border-top-left-radius:0px;border-top-right-radius:0px;">
          <div class="progress-bar bg-danger" :style="{ width: formProgress + '%' }"></div>
        </div>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12 col-md-10 d-flex justify-content-center" v-auto-animate>
        <slot name="formContent"></slot>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  inject:["formProgress"]
};
</script>

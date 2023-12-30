<template>
    <RouterLink :to="'/kampanya/' + sp.ID" class="text-decoration-none">
        <div class="col sp">
            <div class="card position-relative">
                <span class="position-absolute translate-middle-y badge rounded-pill bg-danger">Başarılı</span>
                <img :src="this.apiURL+sp.petitionImage" class="card-img-top sp-image" alt="..." />
                <div class="card-body">
                    <h4 class="card-title">{{ sp.petitionHeader }}</h4>
                    <div class="card-text">{{ sp.petitionContent }}</div>
                    <div class="row mt-3">
                        <div class="col-3">
                            <img :src="sp.creatorImage" alt="" style="object-fit: cover" class="w-100 h-100 rounded-circle" />
                        </div>
                        <div class="col-9">
                            <small>{{ sp.creator }}</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <small>{{ sp.totalSigned }} katılımcı</small>
                </div>
            </div>
        </div>
    </RouterLink>
</template>
<script>
  export default{
    props:{
      sp:Object
    }
  }
</script>
<style>
#succeded-petitions .card {
    cursor: pointer;
}
#succeded-petitions .card-title {
    transition: 0.2s;
}
.sp {
    transition: 0.2s;
}
.sp:hover .card-title {
    color: #ff3838;
}
.sp:hover {
    transform: scale(1.01);
}
</style>

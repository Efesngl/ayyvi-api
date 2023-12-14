<template>
  <div class="container position-relative" :class="{'p-5':!isImageUploaded,'p-0':isImageUploaded}"  id="image-upload-container">
    <div v-if="!isImageUploaded">
      <div class="row">
        <div class="col-12 text-center">
          <i class="bi bi-image-fill"></i>
        </div>
      </div>
      <div class="row">
        <div class="col-12 text-center">
          <label for="petition-image" class="btn btn-outline-danger">Görsel ekle</label>
          <input @change="uploadFile" type="file" name="petition-image" class="form-control d-none" id="petition-image" accept=".png,.jpg,.jpeg" />
        </div>
      </div>
      <div class="row" v-if="errors.length > 0">
        <div class="col-12 text-center" v-for="(err, index) in errors">
          <span class="text-danger">{{ err }}</span>
        </div>
      </div>
    </div>
    <div v-else class="h-100">
      <div class="row position-absolute" id="reset-image-button">
        <div class="col">
          <button class="btn btn-danger" @click="resetUploadedImage"><i class="bi bi-x-lg fs-6"></i></button>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <img :src="imageInfo.url" id="image-preview" alt="" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { useStartPetition } from '../stores/Startpetition';

export default {
  props: {
    maxSize: {
      type: Number,
      default: 5,
      required: true,
    },
  },
  data() {
    return {
      isImageUploaded: false,
      errors: [],
      imageInfo: {
        size: 0,
        extension: null,
        name: null,
        url: null,
      },
      petitionInfo:usepetitionInfo()
    };
  },
  beforeMount(){
    if(this.petitionInfo.petition.petitionImage.url!=null){
      this.imageInfo=this.petitionInfo.petition.petitionImage
      this.isImageUploaded=true
    }
  },
  methods: {
    uploadFile(e) {
      if (this.isFileSizeValid(e.target.files[0])) {
        if (e.target.files && e.target.files[0]) {
          console.log(e.target.files[0]);
          // Get uploaded file
          const file = e.target.files[0];
          // Get file size
          (this.imageInfo.size = Math.round((file.size / 1024 / 1024) * 100) / 100),
            // Get file extension
            (this.imageInfo.extension = file.name.split(".").pop()),
            // Get file name
            (this.imageInfo.name = file.name.split(".").shift());
          // Check if file is an image
          this.isImageUploaded = true;
          this.petitionInfo.petition.petitionImage=this.imageInfo
          let reader = new FileReader();
          reader.addEventListener("load", () => {
            this.imageInfo.url = reader.result;
          });
          reader.readAsDataURL(file);
        }
      }
    },
    isFileSizeValid(fs) {
      this.errors = [];
      if (Math.round(fs.size / 1024 / 1024) > this.maxSize) {
        this.errors.push(`Dosya boyutu ${this.maxSize} MB dan küçük olmalıdır`);
        return false;
      }
      return true;
    },
    resetUploadedImage() {
      this.isImageUploaded = false;
      this.imageInfo = {
        size: 0,
        extension: null,
        name: null,
        url: null,
      };
      this.petitionInfo.petition.petitionImage=this.imageInfo
    },
    checkErrors(){
      if(!this.isImageUploaded) return false
      return true
    }
  },
};
</script>

<style>
#image-preview{
  width:100%;
  height: 15rem;
  border-radius: 1rem;
  object-fit: cover;
}
#reset-image-button {
  left: 100%;
  top: 1.5rem;
  transform: translateX(-100%);
}
.bi-image-fill {
  font-size: 4rem;
}
#image-upload-container {
  border: 1px dashed black;
  border-radius: 1rem;
  box-sizing: border-box;
}
</style>
../stores/StartPetition
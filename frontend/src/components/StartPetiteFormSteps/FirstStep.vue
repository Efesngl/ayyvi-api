<template>
  <div class="container-fluid w-75" id="start-petite-form">
    <div class="row">
      <div class="col-12">
        <h2 class="fs-1">Değişim için birlikte adım atalım</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <small class="fs-5">Bir kampanya türü seçin</small>
      </div>
    </div>
    <div class="row" v-if="errors.petiteNotSelected">
      <div class="col-12">
        <span class="text-danger">Lütfen bir kampanya türü seçiniz !</span>
      </div>
    </div>
    <div class="row gap-2 gap-md-0 mt-3">
      <div class="col-md-4 col-12" v-for="pt in petiteTypes">
        <div class="petite-type text-center" :class="{ 'selected-petite-type': pt.selected }" @click="selectPetiteType(pt)">
          <div class="row">
            <div class="col-12">
              <span v-html="pt.icon"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <span>{{ pt.type }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3" v-if="petiteInfo.petite.petiteType == 1">
      <div class="col-12">
        <label for="location"><small>Kampanyanın etkileyeceği yer</small></label>
        <div class="row" v-if="errors.petiteLocationNotSelected">
          <div class="col-12">
            <span class="text-danger"> Lütfen kampanyayın etkileyeceği alanı giriniz ! </span>
          </div>
        </div>
        <input type="text" class="form-control" name="location" v-model="petiteInfo.petite.petiteLocation" id="petiteLocation" />
      </div>
    </div>
    <div class="row mt-3 justify-content-center">
      <div class="col-6 text-center">
        <button class="btn btn-danger" @click="incStep">Sonraki adım</button>
      </div>
    </div>
  </div>
</template>

<script>
import { usePetiteInfo } from '../../stores/StartPetite';
export default {
  data() {
    return {
      petiteInfo:usePetiteInfo(),
      petiteTypes: [
        {
          typeID: 1,
          type: "Yerel",
          icon: '<i class="bi bi-house-heart-fill"></i>',
          selected: false,
        },
        {
          typeID: 2,
          type: "Ulusal",
          icon: '<i class="bi bi-flag-fill"></i>',
          selected: false,
        },
        {
          typeID: 3,
          type: "Global",
          icon: '<i class="bi bi-globe"></i>',
          selected: false,
        },
      ],
      errors: {
        petiteNotSelected: false,
        petiteLocationNotSelected: false,
      },
    };
  },
  beforeMount() {
    if (this.petiteInfo.petite.petiteType != null) {
      for (const pts of this.petiteTypes) {
        if (pts.typeID == this.petiteInfo.petite.petiteType) {
          pts.selected = true;
        }
      }
    }
  },
  methods: {
    selectPetiteType(pt) {
      if (!pt.selected) {
        this.petiteTypes.forEach((pt) => {
          pt.selected = false;
        });
        if (pt.tpyeID != 1 && this.petiteInfo.petite.petiteLocation != null) {
          this.petiteInfo.petite.petiteLocation = null;
        }
        this.petiteInfo.petite.petiteType = pt.typeID;
      } else {
        this.petiteInfo.petite.petiteType = null;
      }
      pt.selected = !pt.selected;
    },
    isPetiteTypeSelected() {
      if (this.petiteInfo.petite.petiteType == null) {
        this.errors.petiteNotSelected = true;
        return false;
      }
      return true;
    },
    isPetiteLocationSelected() {
      if (this.petiteInfo.petite.petiteLocation == null || this.petiteInfo.petite.petiteLocation == "") {
        this.errors.petiteLocationNotSelected = true;
        return false;
      }
      return true;
    },
    checkErrors() {
      this.errors = {
        petiteNotSelected: false,
        petiteLocationNotSelected: false,
      };
      if (!this.isPetiteTypeSelected()) {
        return false;
      }
      if (this.isPetiteTypeSelected() && this.petiteInfo.petite.petiteType == 1) {
        console.log("pt 1 seçili");
        if (!this.isPetiteLocationSelected()) {
          return false;
        }
      }
      return true;
    },
    incStep() {
      if (this.checkErrors()) {
        this.$emit("incStepOk");
      }
    },
  },
};
</script>

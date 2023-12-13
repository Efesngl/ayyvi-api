<template>
  <Navbar></Navbar>
  <!-- donate -->
  <div class="container-fluid" id="donate">
    <div class="row justify-content-center justify-content-md-end p-2 pt-md-5 pe-md-5">
      <div class="col-12 col-md-4 p-3 bg-white text-center" id="donate-form">
        <h3>Daha çok kampanya için destek olabilirsin</h3>
        <h4 style="color: var(--dark-red)">Aylık veya tek seferlik desktek olabilirsin</h4>
        <div class="row">
          <div class="col-12 p-3 text-start">
            <form action="#">
              <label for="donate-firstname">Adınız</label>
              <input type="text" class="form-control" id="donate-firstname" name="donate-firstname" />
              <label for="donate-lastname">Soyadınız</label>
              <input type="text" class="form-control" id="donate-lastname" name="donate-lastname" />
              <label for="donate-email">Epostanız</label>
              <input type="email" class="form-control" id="donate-email" name="donate-email" />
              <label for="donate-firstname">Telefon numaranız</label>
              <input type="text" class="form-control" id="donate-phone" name="donate-phone" />
              <div class="row">
                <div class="col-12 text-center mt-1">
                  <input class="form-check-input" type="checkbox" value="" name="is-monthly-payment" id="is-monthly-payment" />
                  <label class="form-check-label" for="is-monthly-payment">Aylık destek</label>
                </div>
              </div>
              <div class="row">
                <div class="col-12 mt-2 d-flex justify-content-evenly">
                  <input type="radio" class="btn-check" name="options-base" id="price1" autocomplete="off" />
                  <label class="btn btn-outline-danger" @click="hideCustomAmount" for="price1">75 Tl</label>
                  <input type="radio" class="btn-check" name="options-base" id="price2" autocomplete="off" />
                  <label class="btn btn-outline-danger" @click="hideCustomAmount" for="price2">100 TL</label>
                  <input type="radio" class="btn-check" name="options-base" id="price3" autocomplete="off" />
                  <label class="btn btn-outline-danger" @click="hideCustomAmount" for="price3">250 TL</label>
                  <input type="radio" class="btn-check" name="options-base" id="other-price-btn" autocomplete="off" />
                  <label class="btn btn-outline-danger" for="other-price-btn" @click="showCustomAmount">Diğer</label>
                </div>
              </div>
              <div class="row" v-if="isCustomAmountShowed">
                <div class="col-12">
                  <input type="text" class="form-control mt-2" name="other-price" id="other-price" placeholder="Örnek: 500" />
                </div>
              </div>
              <div class="row">
                <div class="col-12 mt-2">
                  <button class="btn btn-danger w-100">Bağış yap</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Footer></Footer>
</template>

<script>
import Navbar from "../components/Shared/Navbar.vue";
import Footer from "../components/Shared/Footer.vue";
export default {
  components: {
    Navbar,
    Footer,
  },
  data() {
    return {
      isCustomAmountShowed: false,
    };
  },
  methods: {
    showCustomAmount() {
      if (!this.isCustomAmountShowed) {
        this.isCustomAmountShowed = true;
      }
    },
    hideCustomAmount() {
      this.isCustomAmountShowed = false;
    },
  },
};
</script>

<style>
#donate {
  width: 100vw;
  height: 100vh;
}
@media (min-width: 768px) {
  #donate {
    background-image: url("/assets/img/donate.webp");
    background-position: center;
    background-repeat: no-repeat;
    background-size: contain;
  }
}
#donate-form {
  border: 1px solid rgba(0, 0, 0, 0.5);
  border-radius: 10px;
}
#is-monthly-payment {
  accent-color: var(--dark-red) !important;
}
</style>

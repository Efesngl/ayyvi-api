<template>
    <Navbar></Navbar>
    <!-- donate -->
    <div class="container-fluid" id="donate">
      <FirstStep v-if="formStep==1" @incStepOk="incStep"></FirstStep>
      <SecondStep v-if="formStep==2"></SecondStep>
    </div>
    <Footer></Footer>
</template>

<script>
import Navbar from "../components/Shared/Navbar.vue";
import Footer from "../components/Shared/Footer.vue";
import FirstStep from "../components/DonationForm/FirstStep.vue";
import SecondStep from "../components/DonationForm/SecondStep.vue";
import { computed } from "vue";
export default {
    components: {
        Navbar,
        Footer,
        FirstStep,
        SecondStep
    },
    provide(){
      return {
        formStep:computed(()=>this.formStep),
        donationInfo:computed(()=>this.donationInfo),
        decStep:this.decStep
      }
    },
    data() {
        return {
            donationInfo:{
              user:{
                firstname:"",
                lastname:"",
                email:"",
                phone:""
              },
              card:{
                cardHolder:"",
                cardNumber:"",
                cardExp:{
                  m:0,
                  y:0
                },
                cardCvv:""
              },
              amount:0
            },
            formStep: 1,
        };
    },
    methods: {
        incStep() {
            this.formStep++;
        },
        decStep(){
          this.formStep--
        }
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
</style>

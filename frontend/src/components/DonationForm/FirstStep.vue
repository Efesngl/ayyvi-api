<template>
    <div class="container-fluid">
        <div class="row justify-content-center justify-content-md-end p-2 pt-md-5 pe-md-5">
            <div class="col-12 col-md-4 p-3 bg-white text-center" id="donate-form">
                <h3 class="text-danger">Daha çok kampanya için destek olabilirsin</h3>
                <div class="row">
                    <div class="col-12 p-3 text-start">
                            <label for="donate-firstname">Adınız</label>
                            <p class="text-danger" v-if="errors.isFirstnameEmpty">Lütfen adınızı giriniz !</p>
                            <input type="text" class="form-control" v-model="donationInfo.user.firstname" id="donate-firstname" name="donate-firstname" />
                            <label for="donate-lastname">Soyadınız</label>
                            <p class="text-danger" v-if="errors.isLastnameEmpty">Lütfen soyadınızı giriniz !</p>
                            <input type="text" class="form-control" v-model="donationInfo.user.lastname" id="donate-lastname" name="donate-lastname" />
                            <label for="donate-email">Epostanız</label>
                            <p class="text-danger" v-if="errors.isEmailEmpty">Lütfen epostanızı giriniz !</p>
                            <input type="email" class="form-control" v-model="donationInfo.user.email" id="donate-email" name="donate-email" />
                            <label for="donate-firstname">Telefon numaranız</label>
                            <p class="text-danger" v-if="errors.isPhoneEmpty">Lütfen telefon numaranızı giriniz !</p>
                            <input type="text" class="form-control" v-model="donationInfo.user.phone" id="donate-phone" name="donate-phone" />

                            <div class="row">
                                <div class="col-12 mt-2">
                                    <button class="btn btn-danger w-100" @click="incStep">Sonraki adım</button>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default{
    inject:["formStep","donationInfo"],
    data(){
        return{
            errors:{
                isFirstnameEmpty:false,
                isLastnameEmpty:false,
                isEmailEmpty:false,
                isPhoneEmpty:false
            }
        }
    },
    methods:{
        isFirstnameEmpty(){
            if(!/([^\s])/.test(this.donationInfo.user.firstname)){
                this.errors.isFirstnameEmpty=true
            }
        },
        isLastnameEmpty(){
            if(!/([^\s])/.test(this.donationInfo.user.lastname)){
                this.errors.isLastnameEmpty=true
            }
        },
        isEmailEmpty(){
            if(!/([^\s])/.test(this.donationInfo.user.email)){
                this.errors.isEmailEmpty=true
            }
        },
        isPhoneEmpty(){
            if(!/([^\s])/.test(this.donationInfo.user.phone)){
                this.errors.isPhoneEmpty=true
            }
        },
        checkErrors(){
            this.errors={
                isFirstnameEmpty:false,
                isLastnameEmpty:false,
                isEmailEmpty:false,
                isPhoneEmpty:false
            }
            this.isFirstnameEmpty()
            this.isLastnameEmpty()
            this.isEmailEmpty()
            this.isPhoneEmpty()
            for (const e in this.errors) {
                if(this.errors[e]) return false
            }
            return true
        },
        incStep(){
            if(this.checkErrors()){
                this.$emit("incStepOk")
            }
        }
    }
}
</script>

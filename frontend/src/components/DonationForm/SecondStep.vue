<template>
    <div class="container-fluid">
        <div class="row justify-content-center justify-content-md-end p-2 pt-md-5 pe-md-5">
            <div class="col-12 col-md-4 p-3 bg-white text-center" id="donate-form">
                <h3>Lütfen kart bilgilerinizi giriniz</h3>
                <div class="row">
                    <div class="col-12 p-3 text-start">
                        <label for="card-holder">Kart sahibinin adı</label>
                        <p class="text-danger" v-if="errors.isCardHolderEmpty">Lütfen kart sahibinin adını giriniz !</p>
                        <input type="text" class="form-control" v-model="donationInfo.card.cardHolder" id="card-holder" name="card-holder" />
                        <label for="card-number">Kart numarası</label>
                        <p class="text-danger" v-if="errors.isCardNumberEmpty">Lütfen bu alanı doğru giriniz !</p>
                        <input
                            type="number"
                            max="9999999999999999"
                            min="0"
                            step="0"
                            class="form-control"
                            @keydown.space.prevent
                            v-model="donationInfo.card.cardNumber"
                            id="card-number"
                            name="card-number"
                        />
                        <p>Son geçerlilik tarihi</p>
                        <label for="card-expiration-month">Ay</label>
                        <p class="text-danger" v-if="errors.isCardExpMonthEmpty">Lütfen bu alanı doğru giriniz !</p>
                        <input
                            type="number"
                            max="12"
                            min="1"
                            class="form-control"
                            @keydown.space.prevent
                            v-model="donationInfo.card.cardExp.m"
                            id="card-expiration-month"
                            name="card-expiration-month"
                        />
                        <label for="card-expiration-year">Yıl</label>
                        <p class="text-danger" v-if="errors.isCardExpYearEmpty">Lütfen bu alanı doğru giriniz !</p>
                        <input
                            type="number"
                            class="form-control"
                            @keydown.space.prevent
                            v-model="donationInfo.card.cardExp.y"
                            id="card-expiration-year"
                            name="card-expiration-year"
                        />
                        <label for="card-cvv">CVV</label>
                        <p class="text-danger" v-if="errors.isCardCvvEmpty">Lütfen bu alanı doğru giriniz !</p>
                        <input
                            type="number"
                            class="form-control"
                            @keydown.space.prevent
                            v-model="donationInfo.card.cardCvv"
                            id="card-cvv"
                            name="card-cvv"
                        />
                        <p class="text-center">Bağış miktarı</p>
                        <p class="text-danger" v-if="errors.isAmountZeroOrEmpty">Bağış miktarı 0 olamaz !</p>
                        <div class="row">
                            <div class="col-12 mt-2 d-flex justify-content-evenly">
                                <input type="radio" class="btn-check" name="options-base" id="price1" autocomplete="off" />
                                <label class="btn btn-outline-danger" @click="hideCustomAmount(75)" for="price1">75 Tl</label>
                                <input type="radio" class="btn-check" name="options-base" id="price2" autocomplete="off" />
                                <label class="btn btn-outline-danger" @click="hideCustomAmount(100)" for="price2">100 TL</label>
                                <input type="radio" class="btn-check" name="options-base" id="price3" autocomplete="off" />
                                <label class="btn btn-outline-danger" @click="hideCustomAmount(250)" for="price3">250 TL</label>
                                <input type="radio" class="btn-check" name="options-base" id="other-price-btn" autocomplete="off" />
                                <label class="btn btn-outline-danger" for="other-price-btn" @click="showCustomAmount">Diğer</label>
                            </div>
                        </div>
                        <div class="row" v-if="isCustomAmountShowed">
                            <div class="col-12">
                                <input
                                    type="text"
                                    class="form-control mt-2"
                                    @keyup="customAmount"
                                    name="other-price"
                                    id="other-price"
                                    placeholder="Örnek: 500"
                                />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <button class="btn btn-danger w-100" @click="makeDonate">Bağış yap</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <button class="btn btn-primary w-100" @click="decStep">Önceki adım</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useUserStore } from '../../stores/UserStore';

export default {
    inject: ["formStep", "donationInfo", "decStep"],
    data() {
        return {
            isCustomAmountShowed: false,
            errors: {
                isCardHolderEmpty: false,
                isCardNumberEmpty: false,
                isCardExpMonthEmpty: false,
                isCardExpYearEmpty: false,
                isCardCvvEmpty: false,
                isAmountZeroOrEmpty: false,
            },
        };
    },
    methods: {
        showCustomAmount() {
            if (!this.isCustomAmountShowed) {
                this.isCustomAmountShowed = true;
            }
        },
        hideCustomAmount(amount) {
            this.donationInfo.amount = parseInt(amount);
            this.isCustomAmountShowed = false;
        },
        customAmount(e) {
            console.log(e.target.value);
            let amount = 0;
            if (e.target.value != NaN && e.target.value != "") {
                amount = e.target.value;
            }
            this.donationInfo.amount = parseInt(amount);
        },
        isCardHolderEmpty() {
            if (!/([^\s])/.test(this.donationInfo.card.cardHolder)) this.errors.isCardHolderEmpty = true;
        },
        isCardNumberEmpty() {
            if (
                !/([^\s])/.test(this.donationInfo.card.cardNumber) ||
                this.donationInfo.card.cardNumber.length < 16 ||
                this.donationInfo.card.cardNumber.length > 16
            )
                this.errors.isCardNumberEmpty = true;
        },
        isCardExpMonthEmpty() {
            if (!/([^\s])/.test(this.donationInfo.card.cardExp.m) || this.donationInfo.card.cardExp.m <= 0 || this.donationInfo.card.cardExp.m > 12)
                this.errors.isCardExpMonthEmpty = true;
        },
        isCardExpYearEmpty() {
            if (!/([^\s])/.test(this.donationInfo.card.cardExp.y) || this.donationInfo.card.cardExp.y <= 0 || this.donationInfo.card.cardExp.y > 45)
                this.errors.isCardExpYearEmpty = true;
        },
        isCardCvvEmpty() {
            if (!/([^\s])/.test(this.donationInfo.card.cardCvv)) this.errors.isCardCvvEmpty = true;
        },
        isAmountZeroOrEmpty() {
            if (!/([^\s])/.test(this.donationInfo.amount) || this.donationInfo.amount == 0) this.errors.isAmountZeroOrEmpty = true;
        },
        checkErrors() {
            this.errors = {
                isCardHolderEmpty: false,
                isCardNumberEmpty: false,
                isCardExpMonthEmpty: false,
                isCardExpYearEmpty: false,
                isCardCvvEmpty: false,
                isAmountZeroOrEmpty: false,
            };
            this.isCardHolderEmpty();
            this.isCardNumberEmpty();
            this.isCardExpMonthEmpty();
            this.isCardExpYearEmpty();
            this.isCardCvvEmpty();
            this.isAmountZeroOrEmpty();
            for (const e in this.errors) {
                if (this.errors[e]) return false;
            }
            return true;
        },
        makeDonate() {
            if (this.checkErrors()) {
                this.$axios.post("donate",{
                    donation:this.donationInfo,
                    user:useUserStore().ID
                }).then(res=>{
                    if(res.status==201) this.$router.push({name:"DonationStatus",params:{status:"basarili"}})
                    else this.$router.push({name:"DonationStatus",params:{status:"basarisiz"}})
                })
            }
        },
    },
};
</script>

<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type="number"] {
    -moz-appearance: textfield;
}
</style>

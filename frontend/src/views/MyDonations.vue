<template>
    <div class="container">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <td>Bağış tutarı</td>
                    <td class="text-end">Bağışın yapıldığı zaman</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="d in donations">
                    <td>{{ d.donationAmount }} TL</td>
                    <td class="text-end">{{ d.donatedAt }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { useUserStore } from '../stores/UserStore';

    export default{
        data(){
            return {
                donations:[]
            }
        },
        beforeMount(){
            this.getDonations()
        },
        methods:{
            getDonations(){
                this.$axios(`donate?user=${useUserStore().ID}`).then(res=>{
                    this.donations=res.data[0]
                })
            }
        }
    }
</script>
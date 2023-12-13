import {defineStore} from "pinia"

export const useUserStore=defineStore("userStore",{
    state:()=>({
        firstname:null,
        lastname:null,
        email:null,
        ID:null
    }),
    persist:true,
    getters:{
        isLogged:(state)=>{
            if(state.firstname!=null&&state.lastname!=null&&state.ID!=null){
                return true
            }
            return false
        }
    },
    actions:{}
})
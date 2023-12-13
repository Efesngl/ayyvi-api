import { createRouter, createWebHistory } from "vue-router";
import Home from "./views/Home.vue";
import BrowsePetite from "./views/BrowsePetite.vue";
import Donate from "./views/Donate.vue";
import Login from "./views/Login.vue";
import Register from "./views/Register.vue";
import StartPetite from "./views/StartPetite.vue";
import ForgotPassword from "./views/ForgotPassword.vue";
import UserPage from "./views/UserPage.vue";
import AccountDetails from "./views/AccountDetails.vue";
import MyPetites from "./views/MyPetites.vue";
import JoinedPetites from "./views/JoinedPetites.vue";
import PetiteDetail from "./views/PetiteDetail.vue";
import { useUserStore } from "./stores/UserStore";
const routes = [
    {
        path: "/",
        component: Home,
        name: "HomePage",
    },
    {
        path: "/browse",
        component: BrowsePetite,
        name: "BrowsePetites",
    },
    {
        path: "/kampanya/:ID",
        component: PetiteDetail,
        name: "PetiteDetailPage",
    },
    {
        path: "/donate",
        component: Donate,
        name: "Donate",
    },
    {
        path: "/login",
        component: Login,
        name: "Login",
    },
    {
        path: "/register",
        component: Register,
        name: "Register",
    },
    {
        path: "/forgotpassword",
        component: ForgotPassword,
        name: "ForgotPassword",
    },
    {
        path: "/kampanyabaslat",
        component: StartPetite,
        name: "StartPetite",
    },
    {
        path: "/hesabim",
        component: UserPage,
        name: "UserPage",
        children: [
            {
                path: "hesapdetaylari",
                component: AccountDetails,
                name:"AccountDetails"
            },
            {
                path: "katildigimkampanyalar",
                component: JoinedPetites,
                name:"JoinedPetites"
            },
            {
                path: "baslattigimkampanyalar",
                component: MyPetites,
                name:"MyPetites"
            },
        ],
    },
    {
        path:"/editpetite"
    }
    
];

const router = createRouter({
    routes,
    history: createWebHistory(),
    scrollBehavior(to, from, savedPosition) {
        return { top: 0, left: 0 };
    },
});
const authNeededRoutes = ["UserPage"];
router.beforeEach((to, from) => {
    const userStore = useUserStore();
    let isAuthNeeded=false
    authNeededRoutes.forEach(r=>{
        if ((to.name == r || to.matched[0].name==r) && userStore.isLogged == false) {
            isAuthNeeded=true
        }
    })
    if(isAuthNeeded) return {name:"Login"}
});

export default router;

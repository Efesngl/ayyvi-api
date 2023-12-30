<template>
    <!-- navbar -->
    <nav class="d-none d-md-block">
        <div id="navbar">
            <div id="site-links">
                <RouterLink to="/"><img src="/assets/img/logo/png/lb.png" id="logo" alt="" /></RouterLink>
                <ul>
                    <li>
                        <RouterLink class="nav-links" active-class="active-navbar" to="/"> Ana Sayfa</RouterLink>
                    </li>
                    <li>
                        <RouterLink class="nav-links" active-class="active-navbar" to="/kampanyabaslat"> Kampanya başlat</RouterLink>
                    </li>
                    <li><RouterLink class="nav-links" active-class="active-navbar" :to="{name:'BrowsePetitions'}"> Göz at</RouterLink></li>
                    <li><RouterLink class="nav-links" active-class="active-navbar" to="/bagis"> Bağışçı ol</RouterLink></li>
                </ul>
            </div>
            <div id="user-links" v-if="!userStore.isLogged">
                <div class="dropdown">
                    <i class="bi bi-person-circle" id="user-logo" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                        <li><RouterLink class="dropdown-item" to="/giris">Giriş yap</RouterLink></li>
                        <li><RouterLink class="dropdown-item" to="/kayit">Üye ol</RouterLink></li>
                    </ul>
                </div>
            </div>
            <div id="user-links" v-else>
                <div class="dropdown">
                    <i class="bi bi-person-circle" id="user-logo" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                        <li><RouterLink class="dropdown-item" to="/hesabim/hesapdetaylari">Hesabım</RouterLink></li>
                        <li><button class="dropdown-item" @click="logout">Çıkış Yap</button></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- offcanvas navbar -->
    <nav class="d-block d-md-none">
        <div id="navbar">
            <div id="site-links">
                <RouterLink to="/"><img src="/assets/img/logo/png/lb.png" id="logo" alt="" /></RouterLink>
            </div>
            <div class="user-links d-flex align-items-center">
                <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasmenu" aria-controls="offcanvasmenu">
                    <i class="bi bi-list fs-1"></i>
                </button>
                <div
                    ref="offCanvas"
                    class="offcanvas offcanvas-start bg-danger text-white"
                    tabindex="-1"
                    id="offcanvasmenu"
                    aria-labelledby="offcanvasmenu"
                >
                    <div class="offcanvas-header">
                        <h2 class="offcanvas-title" id="offcanvasExampleLabel">Menü</h2>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <hr />
                    <div class="offcanvas-body d-flex flex-column justify-content-between">
                        <div id="site-links-offcanvas" class="d-flex flex-column">
                            <RouterLink to="/" class="navbar-offcanvas-links text-decoration-none fs-1" active-class="active-navbar-offcanvas">Ana Sayfa</RouterLink>
                            <RouterLink to="/kampanyabaslat" class="navbar-offcanvas-links text-decoration-none fs-1" active-class="active-navbar-offcanvas">Kampanya başlat</RouterLink>
                            <RouterLink to="/gozat" class="navbar-offcanvas-links text-decoration-none fs-1" active-class="active-navbar-offcanvas">Kampanyalara göz at</RouterLink>
                            <RouterLink to="/bagis" class="navbar-offcanvas-links text-decoration-none fs-1" active-class="active-navbar-offcanvas">Bağış</RouterLink>
                        </div>
                        <div id="user-links-offcavnas">
                            <div class="row fs-1" v-if="!userStore.isLogged">
                                <div class="col-5"><RouterLink to="/giris" class="text-decoration-none text-white">Giriş yap</RouterLink></div>
                                <div class="col-2 text-center"><span>/</span></div>
                                <div class="col-5 text-end">
                                    <RouterLink to="/kayit" class="text-decoration-none text-white">Kayıt ol</RouterLink>
                                </div>
                            </div>

                            <div class="row fs-1" v-else>
                                <div class="col-8">
                                    <RouterLink to="/hesabim/hesapdetaylari" class="text-decoration-none text-white"
                                        ><i class="bi bi-person-circle"></i
                                        ><span> {{ userStore.firstname + " " + userStore.lastname }}</span></RouterLink
                                    >
                                </div>
                                <div class="col-4 text-end">
                                    <button class="btn btn-outline-danger text-white border" @click="logout">Çıkış yap</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
import { useUserStore } from "../../stores/UserStore";
export default {
    data() {
        return {
            userStore: useUserStore(),
        };
    },
    methods: {
        logout() {
            this.userStore.$reset();
            window.location.reload();
        },
    },
};
</script>

<style>
.active-navbar {
    color: var(--dark-red) !important;
}
.active-navbar-offcanvas{
  color: var(--bs-dark) !important;
}
.navbar-offcanvas-links{
  color: var(--bs-white);
}
#navbar {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
    padding: 0.5rem 0.5rem;
    display: flex;
    justify-content: space-between;
    width: 100%;
    height: 100%;
}
#site-links {
    width: 80%;
    display: flex;
    flex-direction: row;
    justify-content: flex-start;
}
#site-links ul {
    display: flex;
    align-items: center;
    margin: 0;
    list-style-type: none;
}
#site-links ul li {
    font-size: 1.3rem;
    padding-left: 2rem;
    display: inline-block;
}
.nav-links {
    color: black;
    text-decoration: none;
    transition: 0.2s;
}
.nav-links:hover {
    color: var(--dark-red);
}
#logo {
    width: 100px;
    height: 60px;
    object-fit: contain;
}
#user-links {
    width: 20%;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
#user-logo {
    font-size: 1.5rem;
    transition: 0.2s;
}
.dropdown-item {
    --bs-dropdown-link-hover-bg: var(--bs-red);
    --bs-dropdown-link-hover-color: var(--bs-white);
    --bs-dropdown-link-active-bg: var(--bs-red);
}
</style>

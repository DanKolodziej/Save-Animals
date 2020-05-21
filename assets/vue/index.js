import Vue from "vue";
import App from "./App";
import Index from "./components/Index";
import Adoption from "./components/Adoption";
import LostAnimals from "./components/LostAnimals";
import EndangeredSpecies from "./components/EndangeredSpecies";
import Blog from "./components/Blog";
import SignIn from "./components/SignIn";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    { path: '/', component: Index },
    { path: '/adopcja', component: Adoption },
    { path: '/zaginione-zwierzaki', component: LostAnimals },
    { path: '/zagrozone-gatunki', component: EndangeredSpecies },
    { path: '/blog', component: Blog },
    { path: '/zaloguj', component: SignIn }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

new Vue({
    components: { App },
    template: "<App/>",
    router
}).$mount("#app");
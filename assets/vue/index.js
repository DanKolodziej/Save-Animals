import Vue from "vue";
import App from "./App";
import Index from "./components/Index";
import SignIn from "./components/SignIn";
import Adoption from "./components/Adoption";
import EndangeredSpecies from "./components/EndangeredSpecies";
import Blog from "./components/Blog";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    { path: '/', component: Index },
    { path: '/zaloguj', component: SignIn },
    { path: '/adopcja', component: Adoption },
    { path: '/zagrozone-gatunki', component: EndangeredSpecies },
    { path: '/blog', component: Blog }
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
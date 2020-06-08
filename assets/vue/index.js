import Vue from "vue";
import App from "./App";
import Index from "./components/Index";
import Adoption from "./components/Adoption";
import LostAnimals from "./components/LostAnimals";
import EndangeredSpecies from "./components/EndangeredSpecies";
import Blog from "./components/Blog";
import UserAnimals from "./components/UserAnimals";
import SignIn from "./components/SignIn";
import VueRouter from "vue-router";
import { store } from "./store/security";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faChevronDown } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faChevronDown);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(VueRouter);

const routes = [
    { path: '/', component: Index },
    { path: '/adopcja', component: Adoption},
    { path: '/zaginione-zwierzaki', component: LostAnimals },
    { path: '/zagrozone-gatunki', component: EndangeredSpecies },
    { path: '/blog', component: Blog, meta: { requiresAuth: true }},
    { path: '/zwierzaki-uzytkownika', component: UserAnimals },
    { path: '/logowanie', component: SignIn, props: true }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (store.getters.isAuthenticated) {
            next();
        } else {
            next({
                path: "/logowanie",
                query: { redirect: to.fullPath }
            });
        }
    } else {
        next(); // make sure to always call next()!
    }
});

new Vue({
    components: { App },
    template: "<App/>",
    router,
    store
}).$mount("#app");
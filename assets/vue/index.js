import Vue from "vue";
import App from "./App";
import Index from "./components/Index";
import Animals from "./components/Animals";
import Animal from "./components/Animal";
import EndangeredSpecies from "./components/EndangeredSpecies";
import PostPage from './components/PostPage';
import UserAnimals from "./components/UserAnimals";
import SignIn from "./components/SignIn";
import SignUp from "./components/SignUp";
import VueRouter from "vue-router";
import { store } from "./store/security";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faChevronDown, faChevronLeft, faChevronRight, faPlus, faMinus, faFileImage, faLongArrowAltRight } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faChevronDown, faChevronLeft, faChevronRight, faPlus, faMinus, faFileImage, faLongArrowAltRight);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.use(VueRouter);

const routes = [
    { path: '/', component: Index },
    { path: '/adopcja', component: Animals, props: {category: 'adoption'}},
    { path: '/zaginione-zwierzaki', component: Animals, props: {category: 'lost'}},
    { path: '/zagrozone-gatunki', component: EndangeredSpecies },
    { path: '/zwierzak/:id', name: 'animal', component: Animal, props: true },
    { path: '/zagrozony-gatunek/:name', name: 'endangeredSpecies', component: PostPage, props: true },
    { path: '/zwierzaki-uzytkownika', component: UserAnimals, meta: { requiresAuth: true }},
    { path: '/zwierzaki-uzytkownika/:id', name: 'userAnimals', component: UserAnimals, props: true},
    { path: '/logowanie', component: SignIn, props: true},
    { path: '/rejestracja', component: SignUp, props: true}
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
        next();
    }
});

new Vue({
    components: { App },
    template: "<App/>",
    router,
    store
}).$mount("#app");
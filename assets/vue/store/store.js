import Vue from "vue";
import Vuex from "vuex";
import SecurityModule from "./security";
import EndangeredSpeciesModule from "./endangered-species"

Vue.use(Vuex);

export const store = new Vuex.Store({
    modules: {
        security: SecurityModule,
        endangeredSpecies: EndangeredSpeciesModule
    }
});
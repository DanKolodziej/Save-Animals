import Vuex from "vuex";
import Vue from "vue";

Vue.use(Vuex);

export default {
    state: {
        loadingEndangeredSpecies: false,
        extinct: [],
        toDisappear: [],
        extremelyEndangered: [],
        highlyEndangered: [],
        atEndangerRisk: [],
        closeToDanger: [],
        notEndangered: [],
    },
    getters: {
        isLoadingEndangeredSpecies(state) {
            return state.loadingEndangeredSpecies;
        },
        extinct(state) {
            return state.extinct;
        },
        toDisappear(state) {
            return state.toDisappear;
        },
        extremelyEndangered(state) {
            return state.extremelyEndangered;
        },
        highlyEndangered(state) {
            return state.highlyEndangered;
        },
        atEndangerRisk(state) {
            return state.atEndangerRisk;
        },
        closeToDanger(state) {
            return state.closeToDanger;
        },
        notEndangered(state) {
            return state.notEndangered;
        },
        endangeredSpeciesByName(state) {
            var endangeredSpecies = flattenEndangeredSpecies([
                state.extinct,
                state.toDisappear,
                state.extremelyEndangered,
                state.highlyEndangered,
                state.atEndangerRisk,
                state.closeToDanger,
                state.notEndangered
            ]);
            return name =>
                endangeredSpecies.filter(endangeredSpecies => {
                    return endangeredSpecies.name === name;
                });
        },
        threeRandomEndangeredSpecies(state) {
            var endangeredSpecies = flattenEndangeredSpecies([
                state.extinct,
                state.toDisappear,
                state.extremelyEndangered,
                state.highlyEndangered,
                state.atEndangerRisk,
                state.closeToDanger,
                state.notEndangered
            ]);

            var shuffled = endangeredSpecies.sort(() => 0.5 - Math.random());
            return shuffled.slice(0, 3).map(endangeredSpecies => {
                endangeredSpecies.imageLink = endangeredSpecies.imageLink.replace(/\d+px/g, '1000px');
                return endangeredSpecies;
            });
        }
    },
    mutations: {
        setLoadingEndangeredSpecies(state, isLoading) {
            state.loadingEndangeredSpecies = isLoading;
        },
        setEndangeredSpecies(state, payload) {
            state.extinct = payload.extinct;
            state.toDisappear = payload.toDisappear;
            state.extremelyEndangered = payload.extremelyEndangered;
            state.highlyEndangered = payload.highlyEndangered;
            state.atEndangerRisk = payload.atEndangerRisk;
            state.closeToDanger = payload.closeToDanger;
            state.notEndangered = payload.notEndangered;
        }
    }
};

function flattenEndangeredSpecies(endangeredSpecies) {
    return endangeredSpecies.flat();
}
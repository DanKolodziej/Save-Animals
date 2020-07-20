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
            var endangeredSpecies = [];
            endangeredSpecies = endangeredSpecies.concat(state.extinct);
            endangeredSpecies = endangeredSpecies.concat(state.toDisappear);
            endangeredSpecies = endangeredSpecies.concat(state.extremelyEndangered);
            endangeredSpecies = endangeredSpecies.concat(state.highlyEndangered);
            endangeredSpecies = endangeredSpecies.concat(state.atEndangerRisk);
            endangeredSpecies = endangeredSpecies.concat(state.closeToDanger);
            endangeredSpecies = endangeredSpecies.concat(state.notEndangered);
            return name =>
                endangeredSpecies.filter(endangeredSpecies => {
                    return endangeredSpecies.name === name;
                });
        },
        threeRandomEndangeredSpecies(state) {
            var endangeredSpecies = [];
            endangeredSpecies = endangeredSpecies.concat(state.extinct);
            endangeredSpecies = endangeredSpecies.concat(state.toDisappear);
            endangeredSpecies = endangeredSpecies.concat(state.extremelyEndangered);
            endangeredSpecies = endangeredSpecies.concat(state.highlyEndangered);
            endangeredSpecies = endangeredSpecies.concat(state.atEndangerRisk);
            endangeredSpecies = endangeredSpecies.concat(state.closeToDanger);
            endangeredSpecies = endangeredSpecies.concat(state.notEndangered);

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
        setExtinct(state, extinct) {
            state.extinct = extinct;
        },
        setToDisappear(state, toDisappear) {
            state.toDisappear = toDisappear;
        },
        setExtremelyEndangered(state, extremelyEndangered) {
            state.extremelyEndangered = extremelyEndangered;
        },
        setHighlyEndangered(state, highlyEndangered) {
            state.highlyEndangered = highlyEndangered;
        },
        setAtEndangerRisk(state, atEndangerRisk) {
            state.atEndangerRisk = atEndangerRisk;
        },
        setCloseToDanger(state, closeToDanger) {
            state.closeToDanger = closeToDanger;
        },
        setNotEndangered(state, notEndangered) {
            state.notEndangered = notEndangered;
        }
    }
};
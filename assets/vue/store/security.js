import axios from "axios";
import Vuex from "vuex";
import Vue from "vue";

const AUTHENTICATING = "AUTHENTICATING",
    AUTHENTICATING_SUCCESS = "AUTHENTICATING_SUCCESS",
    AUTHENTICATING_ERROR = "AUTHENTICATING_ERROR",
    PROVIDING_DATA_ON_REFRESH_SUCCESS = "PROVIDING_DATA_ON_REFRESH_SUCCESS";

Vue.use(Vuex);

export default {
    // namespaced: true,
    state: {
        isLoading: false,
        error: null,
        errorMessage: '',
        isAuthenticated: false,
        user: null
    },
    getters: {
        isLoading(state) {
            return state.isLoading;
        },
        hasError(state) {
            return state.error !== null;
        },
        error(state) {
            return state.error;
        },
        errorMessage(state) {
            return state.errorMessage;
        },
        isAuthenticated(state) {
            return state.isAuthenticated;
        },
        userId(state) {
            return state.user.id
        },
        userName(state) {
            return state.user.name
        },
        isAdministrator(state) {
            return state.user.roles.indexOf('ADMINISTRATOR') >= 0;
        },
        hasRole(state) {
            return role => {
                return state.user.roles.indexOf(role) !== -1;
            }
        }
    },
    mutations: {
        [AUTHENTICATING](state) {
            state.isLoading = true;
            state.error = null;
            state.isAuthenticated = false;
            state.user = null;
        },
        [AUTHENTICATING_SUCCESS](state, user) {
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = true;
            state.user = user;
        },
        [AUTHENTICATING_ERROR](state, error) {
            state.isLoading = false;
            state.error = error;
            state.isAuthenticated = false;
            state.user = null;
        },
        [PROVIDING_DATA_ON_REFRESH_SUCCESS](state, payload) {
            state.isLoading = false;
            state.error = null;
            state.isAuthenticated = payload.isAuthenticated;
            state.user = payload.user;
        },
        authenticationErrorMessage(state, errorMessage) {
            state.errorMessage = errorMessage;
        }
    },
    actions: {
        async login({commit}, payload) {
            commit(AUTHENTICATING);
            try {
                let response = await login(payload.email, payload.password);
                commit(AUTHENTICATING_SUCCESS, response.data);
                commit('authenticationErrorMessage', '');
                return response.data;
            } catch (error) {
                commit(AUTHENTICATING_ERROR, error);
                commit('authenticationErrorMessage', error.response.data['error']);
                return null;
            }
        },
        onRefresh({commit}, payload) {
            commit(PROVIDING_DATA_ON_REFRESH_SUCCESS, payload);
        }
    }
};

function login(email, password) {
    return axios.post("/login", {
        email: email,
        password: password
    });
}
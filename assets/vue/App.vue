<template>
    <div class="app-content">
        <slider></slider>
        <navigation-bar></navigation-bar>
        <router-view class="main-content" :key="$route.path"></router-view>
        <footer-bar></footer-bar>
    </div>
</template>

<script>
    import Slider from "./components/slider";
    import NavigationBar from './components/NavigationBar';
    import FooterBar from "./components/FooterBar";
    import axios from 'axios';

    export default {
        name: "App",
        components: {
            Slider,
            NavigationBar,
            FooterBar
        },
        methods: {
            getEndangeredSpecies: function() {
                this.$store.commit('setLoadingEndangeredSpecies', true);
                axios.get('/endangered-species-data')
                    .then(response => {
                        this.$store.commit('setExtinct', response.data['EX']);
                        this.$store.commit('setToDisappear', response.data['EXP']);
                        this.$store.commit('setExtremelyEndangered', response.data['CR']);
                        this.$store.commit('setHighlyEndangered', response.data['EN']);
                        this.$store.commit('setAtEndangerRisk', response.data['VU']);
                        this.$store.commit('setCloseToDanger', response.data['NT']);
                        this.$store.commit('setNotEndangered', response.data['LC']);
                        this.$store.commit('setLoadingEndangeredSpecies', false);
                    }).catch(response => {
                    this.$store.commit('setLoadingEndangeredSpecies', false);
                });
            }
        },
        created() {
            let isAuthenticated = JSON.parse(this.$parent.$el.attributes["data-is-authenticated"].value),
            user = JSON.parse(this.$parent.$el.attributes["data-user"].value);

            let payload = { isAuthenticated: isAuthenticated, user: user };
            this.$store.dispatch("onRefresh", payload);

            this.getEndangeredSpecies();
        }
    }
</script>

<style lang="scss">
    @font-face {
        font-family: "Roboto";
        src: url('./../fonts/Roboto-Regular.ttf');
    }

    @font-face {
        font-family: "Roboto";
        src: url('./../fonts/Roboto-Bold.ttf');
        font-weight: bold;
    }

    body {
        margin: 0;
        font-family: Roboto;

        .main-content {
            min-height: calc(100vh - 180px);
        }

        textarea {
            resize: none;
        }
    }
</style>
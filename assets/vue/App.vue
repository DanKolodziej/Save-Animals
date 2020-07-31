<template>
    <div class="app-content">
        <Slider/>
        <NavigationBar/>
        <RouterView class="main-content"
                    :key="$route.path"
        >
        </RouterView>
        <FooterBar/>
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
        created() {
            let isAuthenticated = JSON.parse(this.$parent.$el.attributes["data-is-authenticated"].value),
            user = JSON.parse(this.$parent.$el.attributes["data-user"].value);

            let payload = { isAuthenticated: isAuthenticated, user: user };
            this.$store.dispatch("onRefresh", payload);

            this.getEndangeredSpecies();
        },
        methods: {
            getEndangeredSpecies: function() {
                this.$store.commit('setLoadingEndangeredSpecies', true);
                axios.get('/endangered-species')
                    .then(response => {
                        this.$store.commit('setEndangeredSpecies', {
                            extinct: response.data.endangeredSpecies['EX'],
                            toDisappear: response.data.endangeredSpecies['EXP'],
                            extremelyEndangered: response.data.endangeredSpecies['CR'],
                            highlyEndangered: response.data.endangeredSpecies['EN'],
                            atEndangerRisk: response.data.endangeredSpecies['VU'],
                            closeToDanger: response.data.endangeredSpecies['NT'],
                            notEndangered: response.data.endangeredSpecies['LC']
                        });
                        this.$store.commit('setLoadingEndangeredSpecies', false);
                    }).catch(() => {
                    this.$store.commit('setLoadingEndangeredSpecies', false);
                });
            }
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
<template>
    <div class="app-content">
        <navigation-bar></navigation-bar>
        <router-view class="main-content"></router-view>
        <footer-bar></footer-bar>
    </div>
</template>

<script>
    import NavigationBar from './components/NavigationBar';
    import FooterBar from "./components/FooterBar";

    export default {
        name: "App",
        components: {
            NavigationBar,
            FooterBar
        },
        created() {
            let isAuthenticated = JSON.parse(this.$parent.$el.attributes["data-is-authenticated"].value),
            user = JSON.parse(this.$parent.$el.attributes["data-user"].value);

            let payload = { isAuthenticated: isAuthenticated, user: user };
            this.$store.dispatch("onRefresh", payload);
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
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
        background-color: #e9ffff;
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
<template>
    <div>
        <navigation-bar></navigation-bar>
        <router-view></router-view>
    </div>
</template>

<script>
    import NavigationBar from './components/NavigationBar';

    export default {
        name: "App",
        components: {
            NavigationBar
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
    }

    div {
        span {
            color: #C82829;
        }
    }
</style>
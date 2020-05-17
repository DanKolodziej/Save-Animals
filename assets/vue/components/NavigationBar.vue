<template>
    <nav class="navigation">
        <router-link to="/" :class="{active: isMainPageActive}">Strona główna</router-link>
        <router-link to="/adopcja" :class="{active: isAdoptionActive}">Adopcja zwierzaka</router-link>
        <router-link to="/zagrozone-gatunki" :class="{active: isEndangeredSpeciesActive}">Informacje o zagrożonych gatunkach</router-link>
        <router-link to="/blog" :class="{active: isBlogActive}">Blog</router-link>
        <router-link to="/zaloguj" :class="{active: isSignInActive}">Zaloguj się</router-link>
    </nav>
</template>

<script>
    export default {
        name: "NavigationBar",
        computed: {
            isMainPageActive: function () {
                return this.$route.path === '/';
            },
            isAdoptionActive: function () {
                return this.$route.path === '/adopcja';
            },
            isEndangeredSpeciesActive: function () {
                return this.$route.path === '/zagrozone-gatunki';
            },
            isBlogActive: function () {
                return this.$route.path === '/blog';
            },
            isSignInActive: function () {
                return this.$route.path === '/zaloguj';
            },
        }
    }
</script>

<style lang="scss" scoped>
    .navigation {
        display: flex;
        justify-content: flex-start;
        height: 80px;
        background-color: #00A8E8;
        a {
            text-decoration: none;
            color: #fff;
            /*font-family: Roboto;*/
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            display: block;
            height: 100%;
            line-height: 80px;
            padding: 0 25px;
            box-sizing: border-box;
            transition: 350ms ease-in-out, border-width 350ms ease-in-out;
            /*transition: border-width 250ms ease-in-out;*/
        }

        a:hover, a.active {
            background-color: #00D764;
            /*border-bottom: 4px solid #192BC2;*/
            box-shadow: inset 0px -5px 0px 0px #192BC2;
        }
    }
</style>
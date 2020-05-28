<template>
    <nav class="navigation">
        <div class="navigation__items">
            <router-link to="/" class="navigation__item" :class="{'navigation__item--active': isMainPageActive}">Strona główna</router-link>
            <router-link to="/adopcja" class="navigation__item" :class="{'navigation__item--active': isAdoptionActive}">Adopcja zwierzaka</router-link>
            <router-link to="/zaginione-zwierzaki" class="navigation__item" :class="{'navigation__item--active': isLostAnimalsActive}">Zaginione zwierzaki</router-link>
            <router-link to="/zagrozone-gatunki" class="navigation__item" :class="{'navigation__item--active': isEndangeredSpeciesActive}">Informacje o zagrożonych gatunkach</router-link>
            <router-link to="/blog" class="navigation__item" :class="{'navigation__item--active': isBlogActive}">Blog</router-link>
        </div>
        <div class="navigation__sign-in">
            <router-link to="/logowanie" class="navigation__item" :class="{'navigation__item--active': isSignInActive}">Zaloguj się</router-link>
        </div>
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
            isLostAnimalsActive: function () {
                return this.$route.path === '/zaginione-zwierzaki';
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
        justify-content: space-between;
        height: 90px;
        background-color: #00A8E8;

        &__items {
            display: flex;
        }

        &__item {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-size: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            height: 100%;
            /*line-height: 80px;*/
            padding: 0 25px;
            box-sizing: border-box;
            transition: 350ms ease-in-out;

            &:hover, &--active {
                background-color: #00BB00;
                box-shadow: inset 0px -5px 0px 0px #192BC2;
            }
        }
    }
</style>
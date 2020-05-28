<template>
    <nav class="navigation">
        <div class="navigation__hamburger-icon" @click="toggleMobileMenu">
            <div class="navigation__hamburger-icon-bar"></div>
            <div class="navigation__hamburger-icon-bar"></div>
            <div class="navigation__hamburger-icon-bar"></div>
        </div>
        <div class="navigation__items" :class="{'navigation__items--active': isMobileMenuActive}">
            <router-link to="/" class="navigation__item" :class="{'navigation__item--active': isMainPageActive}">Strona główna</router-link>
            <router-link to="/adopcja" class="navigation__item" :class="{'navigation__item--active': isAdoptionActive}">Adopcja zwierzaka</router-link>
            <router-link to="/zaginione-zwierzaki" class="navigation__item" :class="{'navigation__item--active': isLostAnimalsActive}">Zaginione zwierzaki</router-link>
            <router-link to="/zagrozone-gatunki" class="navigation__item" :class="{'navigation__item--active': isEndangeredSpeciesActive}">Informacje o zagrożonych gatunkach</router-link>
            <router-link to="/blog" class="navigation__item" :class="{'navigation__item--active': isBlogActive}">Blog</router-link>
        </div>
        <div class="navigation__sign-in" :class="{'navigation__sign-in--active': isMobileMenuActive}">
            <router-link to="/logowanie" class="navigation__item" :class="{'navigation__item--active': isSignInActive}">Zaloguj się</router-link>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "NavigationBar",
        data () {
            return {
                isMobileMenuActive: false
            }
        },
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
                return this.$route.path === '/logowanie';
            },
        },
        methods: {
            toggleMobileMenu: function () {
                this.isMobileMenuActive = !this.isMobileMenuActive;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .navigation {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 90px;
        background-color: #00A8E8;

        @media (min-width: 768px) {
            flex-direction: row;
        }

        &__hamburger-icon {
            display: inline-block;
            cursor: pointer;
            width: fit-content;
            height: fit-content;
            margin: 27.5px 0 27.5px 20px;
            background-color: #e9ffff;
            padding: 2px 8px;
            border: 1px solid #192BC2;
            border-radius: 3px;

            @media (min-width: 768px) {
                display: none;
            }
        }

        &__hamburger-icon-bar {
            width: 25px;
            height: 3px;
            background-color: #192BC2;
            margin: 5px 0;
            border-radius: 2px;
        }

        &__items {
            display: flex;
            flex-direction: column;
            background-color: #00A8E8;
            position: relative;
            z-index: 99;
            max-width: 400px;
            margin-left: -400px;
            transition: all 0.5s ease-out;

            @media (min-width: 768px) {
                flex-direction: row;
                max-width: none;
            }

            &--active {
                margin-left: 0;
            }
        }

        &__item {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-size: 18px;
            display: flex;
            align-items: center;
            height: 100%;
            /*line-height: 80px;*/
            padding: 15px 20px 20px;
            box-sizing: border-box;
            transition: 350ms ease-in-out;
            box-shadow: inset 0px -5px 0px 0px #192BC2;
            border-right: 5px solid #192BC2;

            @media (min-width: 768px) {
                text-align: center;
                padding: 0 25px;
                box-shadow: none;
                border-right: none;
            }

            @media (min-width: 1024px) {
                font-size: 20px;
            }

            &:hover, &--active {
                background-color: #00BB00;
                box-shadow: inset 0px -5px 0px 0px #192BC2;
            }
        }

        &__items > &__item:first-child {
            border-top: 5px solid #192BC2;
            @media (min-width: 768px) {
                border-top: none;
            }
        }

        &__sign-in {
            display: block;
            background-color: #00A8E8;
            position: relative;
            z-index: 99;
            max-width: 400px;
            margin-left: -400px;
            transition: all 0.5s ease-out;

            @media (min-width: 768px) {
                max-width: none;
            }

            &--active {
                margin-left: 0;
            }
        }
    }
</style>
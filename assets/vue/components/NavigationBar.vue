<template>
    <nav class="navigation">
        <div class="navigation__hamburger-icon"
             :class="{'navigation__hamburger-icon--active': isMobileMenuActive}"
             @click="toggleMobileMenu">
            <div class="navigation__hamburger-icon-bar"></div>
            <div class="navigation__hamburger-icon-bar"></div>
            <div class="navigation__hamburger-icon-bar"></div>
        </div>
        <div class="navigation__items" :class="{'navigation__items--mobile': isMobileMenuActive}" @click="toggleMobileMenu">
            <router-link to="/"
                         class="navigation__item"
                         :class="{'navigation__item--active': isMainPageActive}">
                Strona główna
            </router-link>
            <router-link to="/adopcja"
                         class="navigation__item"
                         :class="{'navigation__item--active': isAdoptionActive}">
                Adopcja zwierzaka
            </router-link>
            <router-link to="/zaginione-zwierzaki"
                         class="navigation__item"
                         :class="{'navigation__item--active': isLostAnimalsActive}">
                Zaginione zwierzaki
            </router-link>
            <router-link to="/zagrozone-gatunki"
                         class="navigation__item"
                         :class="{'navigation__item--active': isEndangeredSpeciesActive}">
                Informacje o zagrożonych gatunkach
            </router-link>
            <router-link to="/zwierzaki-uzytkownika"
                         class="navigation__item"
                         :class="{'navigation__item--active': isUserAnimalsActive}"
                         v-show="isUserAuthenticated">
                Moje zwierzaki
            </router-link>
        </div>
        <div class="navigation__sign-in"
             :class="{'navigation__sign-in--mobile': isMobileMenuActive}"
             @click="toggleMobileMenu">
            <router-link to="/logowanie"
                         class="navigation__item"
                         :class="{'navigation__item--active': isSignInActive}"
                         v-show="!isUserAuthenticated">
                Zaloguj się
            </router-link>
            <router-link to="/rejestracja"
                         class="navigation__item"
                         :class="{'navigation__item--active': isSignUpActive}"
                         v-show="!isUserAuthenticated">
                Rejestracja
            </router-link>
            <a href="/logout"
                         class="navigation__item"
                         v-show="isUserAuthenticated">
                Wyloguj się
            </a>
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
            isMainPageActive: function() {
                return this.$route.path === '/';
            },
            isAdoptionActive: function() {
                return this.$route.path === '/adopcja';
            },
            isLostAnimalsActive: function() {
                return this.$route.path === '/zaginione-zwierzaki';
            },
            isEndangeredSpeciesActive: function() {
                return this.$route.path === '/zagrozone-gatunki';
            },
            isUserAnimalsActive: function() {
                return this.$route.path === '/zwierzaki-uzytkownika';
            },
            isSignInActive: function() {
                return this.$route.path === '/logowanie';
            },
            isSignUpActive: function() {
                return this.$route.path === '/rejestracja';
            },
            isUserAuthenticated: function() {
                return this.$store.getters.isAuthenticated;
            }
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
            margin: 28.5px 0 28.5px 20px;
            padding: 2px 8px;
            border-radius: 3px;
            transition: 350ms ease-in-out;

            @media (min-width: 768px) {
                display: none;
            }

            &:hover, &--active {
                background-color: #fff;
                color: #00A8E8;
            }

            &:hover > &-bar, &--active > &-bar {
                background-color: #00A8E8;
            }
        }

        &__hamburger-icon-bar {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            border-radius: 2px;
            transition: 350ms ease-in-out;
        }

        &__items {
            display: flex;
            flex-direction: column;
            background-color: #00A8E8;
            position: relative;
            z-index: 99;
            max-width: 345px;
            margin-left: -345px;
            transition: all 0.5s ease-out;

            @media (min-width: 768px) {
                flex-direction: row;
                max-width: none;
                margin-left: 0;
            }

            &--mobile {
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
            padding: 15px 20px 20px;
            box-sizing: border-box;
            transition: 350ms ease-in-out;
            box-shadow: inset 0px -2px 0px 0px #192BC2;
            border-right: 2px solid #192BC2;

            @media (min-width: 768px) {
                text-align: center;
                padding: 0 25px;
                box-shadow: none;
                border-right: none;
                font-size: 14px;
            }

            @media (min-width: 1024px) {
                font-size: 20px;
            }

            &:hover, &--active {
                background-color: #008c4b;

                @media (min-width: 768px) {
                    box-shadow: inset 0px -5px 0px 0px #192BC2;
                }
            }
        }

        &__items > &__item:first-child {
            border-top: 2px solid #192BC2;
            @media (min-width: 768px) {
                border-top: none;
            }
        }

        &__sign-in {
            display: flex;
            flex-direction: column;
            background-color: #00A8E8;
            position: relative;
            z-index: 99;
            max-width: 345px;
            margin-left: -345px;
            transition: all 0.5s ease-out;

            @media (min-width: 768px) {
                flex-direction: row;
                max-width: none;
                margin-left: 0;
            }

            &--mobile {
                margin-left: 0;
            }
        }
    }
</style>
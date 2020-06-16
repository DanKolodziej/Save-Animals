<template>
    <div class="animal-tabs">
        <div class="animal-tabs__titles">
            <div class="animal-tabs__tab-title"
                 :class="{'animal-tabs__tab-title--active': isAdoptionTabActive}"
                 @click="setAdoptionTabActive">
                Zwierzak/i do adopcji
                <div class="animal-tabs__title-underline adoption-underline"></div>
            </div>
            <div class="animal-tabs__tab-title"
                 :class="{'animal-tabs__tab-title--active': isWantedTabActive}"
                 @click="setWantedTabActive">
                Zwierzak/i, które chciałbym przygarnąć
                <div class="animal-tabs__title-underline wanted-underline"></div>
            </div>
            <div class="animal-tabs__tab-title"
                 :class="{'animal-tabs__tab-title--active': isLostTabActive}"
                 @click="setLostTabActive">
                Zwierzak/i, które mi zaginęły
                <div class="animal-tabs__title-underline lost-underline"></div>
            </div>
            <div class="animal-tabs__tab-title"
                 :class="{'animal-tabs__tab-title--active': isFoundTabActive}"
                 @click="setFoundTabActive">
                Zwierzak/i, które znalazłem
                <div class="animal-tabs__title-underline found-underline"></div>
            </div>
        </div>
        <div class="animal-tabs__content animal-tabs__adoption" v-show="isAdoptionTabActive">
            <animal-card></animal-card>
        </div>
        <div class="animal-tabs__content animal-tabs__wanted" v-show="isWantedTabActive">
            <animal-card></animal-card>
        </div>
        <div class="animal-tabs__content animal-tabs__lost" v-show="isLostTabActive">
            <animal-card></animal-card>
        </div>
        <div class="animal-tabs__content animal-tabs__found" v-show="isFoundTabActive">
            <animal-card v-for="animal in foundAnimals"
                         :name="animal.name"
                         :description="animal.description">
            </animal-card>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import AnimalCard from "./AnimalCard";

    export default {
        name: "AnimalTabs",
        components: {
            AnimalCard
        },
        data() {
            return {
                isAdoptionTabActive: true,
                isWantedTabActive: false,
                isLostTabActive: false,
                isFoundTabActive: false,
                adoptionAnimals: [],
                wantedAnimals: [],
                lostAnimals: [],
                foundAnimals: [],
                userId: null
            }
        },
        methods: {
            setAdoptionTabActive: function() {
                this.isAdoptionTabActive = true;
                this.isWantedTabActive = false;
                this.isLostTabActive = false;
                this.isFoundTabActive = false;
            },
            setWantedTabActive: function() {
                this.isAdoptionTabActive = false;
                this.isWantedTabActive = true;
                this.isLostTabActive = false;
                this.isFoundTabActive = false;
            },
            setLostTabActive: function() {
                this.isAdoptionTabActive = false;
                this.isWantedTabActive = false;
                this.isLostTabActive = true;
                this.isFoundTabActive = false;
            },
            setFoundTabActive: function() {
                this.isAdoptionTabActive = false;
                this.isWantedTabActive = false;
                this.isLostTabActive = false;
                this.isFoundTabActive = true;
            },
            getUsersAdoptionAnimals: function () {
                axios.get('/animals-by-user-category?userId=' + this.userId + '&category=adoption')
                    .then(response => {
                        this.adoptionAnimals = response.data;
                    })
            },
            getUsersWantedAnimals: function () {
                axios.get('/animals-by-user-category?userId=' + this.userId + '&category=wanted')
                    .then(response => {
                        this.wantedAnimals = response.data;
                    })
            },
            getUsersLostAnimals: function () {
                axios.get('/animals-by-user-category?userId=' + this.userId + '&category=lost')
                    .then(response => {
                        this.lostAnimals = response.data;
                    })
            },
            getUsersFoundAnimals: function () {
                axios.get('/animals-by-user-category?userId=' + this.userId + '&category=found')
                    .then(response => {
                        this.foundAnimals = response.data;
                        console.log(JSON.parse(JSON.stringify(this.foundAnimals)));
                    })
            }
        },
        mounted() {
            this.userId = this.$store.getters.userId;

            this.getUsersAdoptionAnimals();
            this.getUsersWantedAnimals();
            this.getUsersLostAnimals();
            this.getUsersFoundAnimals();
        }
    }
</script>

<style lang="scss" scoped>
    .animal-tabs {
        max-width: 650px;
        margin: 0 auto;

        &__titles {
            display: flex;
            border-radius: 5px 5px 0 0;
        }

        &__tab-title {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
            border-radius: 5px 5px 0 0;
            border: 1px solid transparent;
            border-bottom: 1px solid #e0e0e0;
            padding: 5px 15px;
            cursor: pointer;
            transition: all 0.5s ease-out;

            &:hover {
                background-color: #e0e0e0;
            }

            &--active {
                background-color: #fff;
                border: 1px solid #e0e0e0;
                border-bottom-color: transparent;

                &:hover {
                    background-color: #fff;
                }
            }
        }

        &__title-underline {
            height: 5px;
            width: 70px;
            margin: 5px auto 0;
        }

        .adoption-underline {
            background-color: #008c4b;
        }

        .wanted-underline {
            background-color: #00b84b;
        }

        .lost-underline {
            background-color: #192bc2;
        }

        .found-underline {
            background-color: #00a8e8;
        }

        &__content {
            background-color: #fff;
            padding-top: 15px;
            border: 1px solid #e0e0e0;
            border-top: 0;
        }
    }
</style>
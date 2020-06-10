<template>
    <div class="user-animals-page">
        <div class="user-info">
            <h2>Email</h2>
            <h2>Name</h2>
            <h3>User Type</h3>
        </div>
        <div class="animals-section">
            <font-awesome-icon class="add-animal-icon"
                               icon="plus" size="3x"
                               @click="isFormDisplayed = true"
                               :class="{'add-animal-icon--hidden': isFormDisplayed}"/>
            <transition name="slide-fade">
                <form class="add-animal-form" v-show="isFormDisplayed">
                    <div class="add-animal-form__minimize-icon-container">
                        <font-awesome-icon class="add-animal-form__minimize-icon"
                                           icon="minus" size="3x"
                                           @click="isFormDisplayed = false"/>
                    </div>
                    <label class="add-animal-form__label">
                        Imię zwierzaka:
                    </label>
                    <div class="add-animal-form__input-group">
                        <input class="add-animal-form__input" type="text">
                    </div>
                    <label class="add-animal-form__label">
                        Gatunek:
                    </label>
                    <div class="add-animal-form__input-group" @click="toggleSpecies">
                        <input type="text" id="animal-species" class="add-animal-form__input"
                               v-model="selectedSpecies" disabled>
                        <div class="add-animal-form__input-arrow">
                            <font-awesome-icon icon="chevron-down"/>
                        </div>
                    </div>
                    <div class="species-list-container">
                        <ul class="species-list" :class="{'species-list--displayed': areSpeciesDisplayed}">
                            <li class="species-list__item"
                                v-for="speciesName in species"
                                @click="setSpecies(speciesName.name)">
                                {{ speciesName.name }}
                            </li>
                        </ul>
                    </div>
                    <label class="add-animal-form__label">
                        Opis:
                    </label>
                    <div class="add-animal-form__input-group">
                        <textarea class="add-animal-form__input" rows="4" cols="20"></textarea>
                    </div>
                    <label class="add-animal-form__label">
                        Kategoria:
                    </label>
                    <div class="add-animal-form__input-group">
                        <input class="add-animal-form__input" type="text">
                    </div>
                    <label>

                    </label>
                </form>
            </transition>
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
                    <animal-card></animal-card>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";
    import axios from "axios";

    export default {
        name: "UserAnimals",
        components: {
            AnimalCard
        },
        data() {
            return {
                isFormDisplayed: false,
                areSpeciesDisplayed: false,
                species: [],
                selectedSpecies: '',
                isAdoptionTabActive: true,
                isWantedTabActive: false,
                isLostTabActive: false,
                isFoundTabActive: false,
            }
        },
        methods: {
            toggleSpecies: function() {
                this.areSpeciesDisplayed = !this.areSpeciesDisplayed;
            },
            showSpecies: function() {
                this.areSpeciesDisplayed = true;
            },
            getSpecies: function() {
                axios.get('/species')
                    .then(response => {
                        this.species = response.data;
                        this.species.sort(this.compareSpeciesIds);
                    });
            },
            compareSpeciesIds: function(a, b) {
                if(a.id > b.id) {
                    return 1
                } else  if(a.id < b.id) {
                    return -1
                }
                return 0;
            },
            setSpecies: function(speciesName) {
                this.selectedSpecies  = speciesName;
                this.areSpeciesDisplayed = false;
            },
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
            }
        },
        mounted() {
            this.getSpecies();
        }
    }
</script>

<style lang="scss" scoped>
    .user-animals-page {
        display: flex;
        justify-content: space-between;
        max-width: 1000px;
        padding: 30px 5% 0 5%;
        margin: 0 auto;

        .animals-section {
            display: flex;
            flex-direction: column;

            .add-animal-icon {
                align-self: center;
                color: #008c4b;
                margin-bottom: 15px;
                padding: 0 3px;
                border-radius: 5px;
                transition: all 0.5s ease-out;
                cursor: pointer;
                opacity: 1;

                &:hover {
                    background-color: #008c4b;
                    color: #fff;
                }

                &--hidden {
                    opacity: 0;
                }
            }

            .slide-fade-enter-active {
                transition: all 0.5s ease-out;
            }
            .slide-fade-leave-active {
                transition: all 0.5s ease-out;
            }
            .slide-fade-enter, .slide-fade-leave-to
                /* .slide-fade-leave-active below version 2.1.8 */ {
                transform: translateY(-100px);
                /*transform: scale(0.1);*/
                opacity: 0;
            }

            .add-animal-form {
                width: 250px;
                margin: 0 auto;
                padding: 15px;
                background-color: #008c4b;
                border-radius: 5px;
                box-shadow: 0 0 20px 0 rgba(0,0,0,0.75);

                &__minimize-icon-container {
                    display: flex;
                    justify-content: flex-end;
                }

                &__minimize-icon {
                    color: #fff;
                    margin-bottom: 15px;
                    padding: 0 3px;
                    border-radius: 5px;
                    transition: all 0.5s ease-out;
                    cursor: pointer;

                    &:hover {
                        background-color: #fff;
                        color: #008c4b;
                    }
                }

                &__label {
                    color: #fff;
                }

                &__input-group {
                    display: flex;
                    margin: 5px 0 10px;
                }

                &__input {
                    display: block;
                    width: 100%;
                    padding: 5px;
                    font-size: 18px;
                    border: 2px solid #00A8E8;
                    border-radius: 3px;
                    box-sizing: border-box;
                    box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

                    &:disabled {
                        background-color: #fff;
                        cursor: pointer;
                    }
                }

                &__input-arrow {
                    display: flex;
                    align-items: center;
                    padding: 0 10px;
                    cursor: pointer;
                    background-color: #00A8E8;
                    color: #fff;
                    border-radius: 0 3px 3px 0;
                    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.75);
                }

                .species-list-container {
                    overflow: hidden;
                    position: absolute;
                    width: 200px;
                    height: 128.33px;
                    margin-top: -10px;
                }

                .species-list {
                    visibility: hidden;
                    list-style: none;
                    background-color: #fff;
                    color: #000;
                    position: absolute;
                    width: 98%;
                    margin: -125px 0 0;
                    padding-left: 0;
                    border: 2px solid #00A8E8;
                    border-radius: 3px;
                    transition: all 0.5s ease-out;
                    max-height: 124.33px;
                    overflow-y: auto;
                    scrollbar-width: thin;
                    scrollbar-color: #00A8E8 #e0e0e0;
                    &::-webkit-scrollbar {
                        width: 8px;
                    }
                    &::-webkit-scrollbar-track {
                        background-color: #e0e0e0;
                        border-radius: 10px;
                    }
                    &::-webkit-scrollbar-thumb {
                        background-color: #00A8E8;
                        border-radius: 10px;
                        box-shadow: inset 0 0 6px rgba(0,0,0,.3);
                    }

                    &--displayed {
                        visibility: visible;
                        margin-top: 0;
                    }

                    &__item {
                        padding: 5px;
                        border-bottom: 1px solid #00A8E8;
                        cursor: pointer;
                        transition: all 0.5s ease-out;

                        &:hover {
                            background-color: #e0e0e0;
                        }

                        &:last-child {
                            border-bottom: 0;
                        }

                        &--disabled {
                            cursor: default;
                            pointer-events: none;
                        }
                    }
                }

            }

            .animal-tabs {
                max-width: 650px;

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
                    background-color: #00bb00;
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
        }
    }

</style>
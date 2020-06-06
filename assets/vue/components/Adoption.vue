<template>
    <div class="adoption-page">
        <h1 class="page-title">Adopcja Zwierzaków</h1>
        <div class="adoption-page__radio-group">
            <label for="adoption-waiting">Zwierzaki do adopcji</label>
            <input type="radio" id="adoption-waiting" name="adoption" value="waiting">
            <label for="adoption-wanted">Zwierzaki poszukiwane do adopcji</label>
            <input type="radio" id="adoption-wanted" name="adoption" value="wanted">
        </div>
        <div class="adoption-content">
            <div class="animal-cards-container">
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
            </div>
            <div class="filter-options">
                <label for="animal-species" class="filter-options__label">
                    Gatunki zwierząt:
                </label>
                <div class="filter-options__input-group">
                    <input type="text" id="animal-species" class="filter-options__input">
                    <div class="filter-options__input-arrow" @click="toggleResults">
                        <font-awesome-icon icon="chevron-down"/>
                    </div>
                </div>
                <div class="results-list-container">
                    <ul class="results-list" :class="{'results-list--displayed': areResultsDisplayed}">
                        <li class="results-list__item">This</li>
                        <li class="results-list__item">is</li>
                        <li class="results-list__item">a</li>
                        <li class="results-list__item">placeholder</li>
                    </ul>
                </div>
                <label for="animal-name" class="filter-options__label">
                    Imię zwierzaka:
                </label>
                <div class="filter-options__input-group">
                    <input type="text" id="animal-name" class="filter-options__input">
                    <div class="filter-options__input-arrow">
                        <font-awesome-icon icon="chevron-down"/>
                    </div>
                </div>
                <label for="animal-description" class="filter-options__label">
                    Opis:
                </label>
                <div class="filter-options__input-group">
                    <input type="text" id="animal-description" class="filter-options__input">
                    <div class="filter-options__input-arrow">
                        <font-awesome-icon icon="chevron-down"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";

    export default {
        name: "Adoption",
        components: {AnimalCard},
        data () {
            return {
                areResultsDisplayed: false
            }
        },
        methods: {
            toggleResults: function () {
                this.areResultsDisplayed = !this.areResultsDisplayed;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .adoption-page {
        padding-top: 30px;

        .page-title {
            text-align: center;
            text-transform: uppercase;
            margin: 0 0 30px;
        }

        &__radio-group {
            width: 445px;
            margin: 0 auto;
        }

        .adoption-content {
            display: flex;
            justify-content: center;
            flex-direction: column-reverse;

            @media (min-width: 1024px) {
                flex-direction: row;
            }

            .animal-cards-container {
                max-width: 1000px;
                display: flex;
                justify-content: flex-start;
                flex-wrap: wrap;

                @media (min-width: 768px) {
                    width: 702px;
                    margin: 0 auto;
                }

                @media (min-width: 1024px) {
                    /*width: auto;*/
                    margin: unset;
                    width: 55%;
                    max-width: 951px;
                    min-width: 717px;
                }
            }

            .filter-options {
                position: relative;
                background-color: #008c4b;
                padding: 15px;
                border-radius: 5px;
                color: #fff;
                width: 250px;
                box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);

                &__input-group {
                    display: flex;
                    margin: 5px 0 10px;
                }

                &__input {
                    /*display: block;*/
                    width: 80%;
                    /*margin: 5px 0 10px;*/
                    padding: 5px;
                    font-size: 18px;
                    border: 2px solid #00A8E8;
                    border-radius: 3px 0 0 3px;
                    box-sizing: border-box;
                    box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);
                }

                &__input-arrow {
                    display: flex;
                    align-items: center;
                    padding: 0 10px;
                    cursor: pointer;
                    background-color: #00A8E8;
                    border-radius: 0 3px 3px 0;
                    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.75);
                }

                .results-list-container {
                    overflow: hidden;
                    position: absolute;
                    width: 200px;
                    height: 124.33px;
                    margin-top: -10px;
                }

                .results-list {
                    /*display: none;*/
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

                    &--displayed {
                        /*display: block;*/
                        visibility: visible;
                        margin-top: 0;
                    }

                    &__item {
                        padding: 5px;
                        border-bottom: 1px solid #00A8E8;

                        &:last-child {
                            border-bottom: 0;
                        }
                    }
                }
            }
        }
    }
</style>
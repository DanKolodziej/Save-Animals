<template>
    <div class="adoption-page">
        <h1 class="page-title">Adopcja Zwierzaków</h1>
        <div class="adoption-page__radio-group" v-if="category === 'adoption'">
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio" id="adoption"
                       name="adoption-category"
                       value="adoption"
                       v-model="selectedAdoptionCategory"
                       @change="FilterAnimals">
                <label class="adoption-page__label" for="adoption">Zwierzaki do adopcji</label>
            </div>
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio"
                       id="wanted"
                       name="adoption-category"
                       value="wanted"
                       v-model="selectedAdoptionCategory"
                       @change="FilterAnimals">
                <label class="adoption-page__label" for="wanted">Zwierzaki poszukiwane do adopcji</label>
            </div>
        </div>
        <div class="adoption-page__radio-group" v-else-if="category === 'lost'">
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio" id="lost"
                       ame="lost-category"
                       value="lost"
                       v-model="selectedLostCategory"
                       @change="FilterAnimals">
                <label class="adoption-page__label" for="lost">Zaginione Zwierzaki</label>
            </div>
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio"
                       id="found"
                       name="lost-category"
                       value="found"
                       v-model="selectedLostCategory"
                       @change="FilterAnimals">
                <label class="adoption-page__label" for="found">Znalezione Zwierzaki</label>
            </div>
        </div>
        <div class="adoption-content">
            <div class="animal-cards-container">
                <animal-card v-for="animal in animals"
                             :key="animal.id"
                             :name="animal.name"
                             :description="animal.description"
                             :image-file-name="animal.imageFileName">
                </animal-card>
            </div>
            <FilterOptions @filterSpecies="speciesFilter"
                           @filterName="namePhraseFilter"
                           @filterDescription="descriptionFilter">
            </FilterOptions>
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";
    import FilterOptions from "./FilterOptions";
    import axios from 'axios';

    export default {
        name: "Animals",
        components: {
            AnimalCard,
            FilterOptions
        },
        data() {
            return {
                selectedAdoptionCategory: 'adoption',
                selectedLostCategory: 'lost',
                species: '',
                namePhrase: '',
                descriptionPhrase: '',
                animals: []
            }
        },
        props: {
            category: {
                type: String,
                required: true
            }
        },
        computed: {
            selectedCategory: function() {
                if(this.category === 'adoption'){
                    return this.selectedAdoptionCategory;
                } else if(this.category === 'lost') {
                    return this.selectedLostCategory;
                }
            }
        },
        methods: {
            FilterAnimals: function() {
                var url = '/animals-by-category-species-name-description?category='
                    + this.selectedCategory + '&species=' + this.species
                    + '&name=' + this.namePhrase + '&description=' + this.descriptionPhrase;

                url = encodeURI(url);

                axios.get(url)
                    .then(response => {
                        this.animals = response.data['animals'];
                    });
            },
            speciesFilter: function(newSpecies) {
                this.species = newSpecies;
                this.FilterAnimals();
            },
            namePhraseFilter: function(newNamePhrase) {
                this.namePhrase = newNamePhrase;
                this.FilterAnimals();
            },
            descriptionFilter: function(newDescription) {
                this.description = newDescription;
                this.FilterAnimals();
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
            width: fit-content;
            background-color: #6495ed;
            margin: 0 auto 30px;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);
        }

        &__label {
            cursor: pointer;
        }

        &__radio-button-container {
            margin: 3px 0;
        }

        &__radio-button {

            &:checked, &:not(:checked) {
                position: absolute;
                left: -9999px;
            }

            &:checked + label, &:not(:checked) + label {
                position: relative;
                padding-left: 28px;
                cursor: pointer;
                line-height: 20px;
                display: inline-block;
            }

            &:checked + label:before, &:not(:checked) + label:before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                width: 18px;
                height: 18px;
                border: 1px solid #ddd;
                border-radius: 100%;
                background: #fff;
            }

            &:checked + label:after, &:not(:checked) + label:after {
                content: '';
                width: 12px;
                height: 12px;
                background: #00A8E8;
                position: absolute;
                top: 4px;
                left: 4px;
                border-radius: 100%;
                -webkit-transition: all 0.2s ease;
                transition: all 0.2s ease;
            }

            &:not(:checked) + label:after {
                opacity: 0;
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            &:checked + label:after {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1);
            }
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
                    margin: unset;
                    width: 55%;
                    max-width: 951px;
                    min-width: 717px;
                }
            }
        }
    }
</style>
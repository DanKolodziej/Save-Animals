<template>
    <div class="adoption-page">
        <h1 class="page-title">
            {{ pageTitle }}
        </h1>
        <div class="adoption-page__radio-group"
             v-if="category === 'adoption'"
        >
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio" id="adoption"
                       name="adoption-category"
                       value="adoption"
                       v-model="selectedAdoptionCategory"
                       @change="filterAnimals"
                >
                <label class="adoption-page__label"
                       for="adoption"
                >
                    Zwierzaki do adopcji
                </label>
            </div>
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio"
                       id="wanted"
                       name="adoption-category"
                       value="wanted"
                       v-model="selectedAdoptionCategory"
                       @change="filterAnimals"
                >
                <label class="adoption-page__label"
                       for="wanted"
                >
                    Zwierzaki poszukiwane do adopcji
                </label>
            </div>
        </div>
        <div class="adoption-page__radio-group"
             v-else-if="category === 'lost'"
        >
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio" id="lost"
                       ame="lost-category"
                       value="lost"
                       v-model="selectedLostCategory"
                       @change="filterAnimals"
                >
                <label class="adoption-page__label"
                       for="lost">
                    Zaginione Zwierzaki
                </label>
            </div>
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button"
                       type="radio"
                       id="found"
                       name="lost-category"
                       value="found"
                       v-model="selectedLostCategory"
                       @change="filterAnimals"
                >
                <label class="adoption-page__label"
                       for="found"
                >
                    Znalezione Zwierzaki
                </label>
            </div>
        </div>
        <div class="animal-content">
            <ClipLoader class="animal-content__loader"
                        :loading="isLoading"
                        :color="'#0057E8'"
                        :size="'45px'"
            />
            <div class="animal-cards-container"
                 v-show="!isLoading && animals.length > 0"
            >
                <AnimalCard
                        v-for="animal in animals"
                        :key="animal.id"
                        :id="animal.id"
                        :name="animal.name"
                        :description="animal.description"
                        :image-file-name="animal.imageFileName == null ? '' : animal.imageFileName"
                >
                </AnimalCard>
            </div>
            <div class="animal-content__no-animals-message"
                 v-show="!isLoading && animals.length === 0"
            >
                Nie znaleziono żadnego zwierzaka
            </div>
            <FilterOptions
                    @filterSpecies="speciesFilter"
                    @filterName="namePhraseFilter"
                    @filterDescription="descriptionPhraseFilter"
                    @filterProvince="provinceFilter"
                    @filterCity=cityPhraseFilter
            >
            </FilterOptions>
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";
    import FilterOptions from "./FilterOptions";
    import axios from 'axios';
    import ClipLoader from 'vue-spinner/src/ClipLoader';

    export default {
        name: "Animals",
        components: {
            AnimalCard,
            FilterOptions,
            ClipLoader
        },
        props: {
            category: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                selectedAdoptionCategory: 'adoption',
                selectedLostCategory: 'lost',
                species: '',
                namePhrase: '',
                descriptionPhrase: '',
                province: '',
                cityPhrase: '',
                animals: [],
                isLoading: false
            }
        },
        computed: {
            pageTitle: function() {
                if(this.category === 'adoption'){
                    return 'Adopcja Zwierzaków';
                } else if(this.category === 'lost') {
                    return 'Zaginione Zwierzaki';
                }
            },
            selectedCategory: function() {
                if(this.category === 'adoption'){
                    return this.selectedAdoptionCategory;
                } else if(this.category === 'lost') {
                    return this.selectedLostCategory;
                }
            }
        },
        mounted() {
            this.filterAnimals();
        },
        methods: {
            filterAnimals: function() {
                var provincePhrase = this.province !== 'Wszystkie' ? this.province : '';
                var url = '/animals-by-category-species-name-description?category='
                    + this.selectedCategory + '&species=' + this.species
                    + '&name=' + this.namePhrase + '&description=' + this.descriptionPhrase
                    + '&province=' + provincePhrase + '&city=' + this.cityPhrase;
                url = encodeURI(url);

                this.isLoading = true;
                axios.get(url)
                    .then(response => {
                        this.animals = response.data['animals'];
                        this.isLoading = false;
                    }).catch(() => {
                    this.isLoading = false;
                });
            },
            speciesFilter: function(newSpecies) {
                this.species = newSpecies;
                this.filterAnimals();
            },
            namePhraseFilter: function(newNamePhrase) {
                this.namePhrase = newNamePhrase;
                this.filterAnimals();
            },
            descriptionPhraseFilter: function(newDescription) {
                this.descriptionPhrase = newDescription;
                this.filterAnimals();
            },
            provinceFilter: function(provincePhrase) {
                this.province = provincePhrase;
                this.filterAnimals();
            },
            cityPhraseFilter: function(newCityPhrase) {
                this.cityPhrase = newCityPhrase;
                this.filterAnimals();
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
            width: -moz-fit-content;
            background-color: #0057E8;
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

        .animal-content {
            display: flex;
            justify-content: center;
            flex-direction: column-reverse;

            @media (min-width: 1024px) {
                flex-direction: row;
            }

            &__loader, &__no-animals-message {
                width: 55%;
                align-self: center;
                margin-bottom: 30px;

                @media (min-width: 768px) {
                    width: 702px;
                    margin: 0 auto 30px;
                }

                @media (min-width: 1024px) {
                    margin: unset;
                    width: 55%;
                    max-width: 951px;
                    min-width: 717px;
                }
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

            &__no-animals-message {
                color: #0057E8;
                font-size: 22px;
                font-weight: bold;
                text-align: center;
                padding: 13.5px 0;
            }
        }
    }
</style>
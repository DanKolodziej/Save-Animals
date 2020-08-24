<template>
    <div class="filter-options">
        <label for="animal-species"
               class="filter-options__label"
        >
            Gatunek zwierzaka
        </label>
        <div class="filter-options__dropdown-container"
             @keypress.enter="toggleResults"
             @keyup.up.stop="selectUpSpecies"
             @keyup.down.stop="selectDownSpecies"
             @focusout.self="hideResults"
             tabindex="0"
        >
            <div class="filter-options__dropdown-group">
                <input type="text"
                       id="animal-species"
                       class="filter-options__dropdown"
                       v-model="selectedSpecies"
                       @input="filterSpecies"
                       @click="showResults"
                >
                <div class="filter-options__dropdown-arrow-container"
                     @click="toggleResults"
                >
                    <font-awesome-icon class="filter-options__dropdown-arrow"
                                       icon="chevron-down"
                                       :class="{'filter-options__dropdown-arrow--active': areResultsDisplayed}"
                    />
                </div>
            </div>
            <div class="results-list-container">
                <ul class="results-list"
                    :class="{'results-list--displayed': areResultsDisplayed}"
                >
                    <li class="results-list__item"
                        v-for="speciesName in filteredSpecies"
                        @click="setSpecies(speciesName.name)"
                        :class="{'results-list__item--selected': selectedSpecies === speciesName.name, 'results-list__item--disabled': speciesName.name === 'Brak wyników'}"
                    >
                        {{ speciesName.name }}
                    </li>
                </ul>
            </div>
        </div>
        <label for="animal-name"
               class="filter-options__label"
        >
            Imię zwierzaka
            <input class="filter-options__input"
                   v-model="name"
                   type="text"
                   id="animal-name"
                   @input="filterName"
            >
        </label>
        <label for="animal-description"
               class="filter-options__label"
        >
            Opis
            <textarea class="filter-options__input filter-options__textarea"
                      v-model="description"
                      id="animal-description"
                      rows="4" cols="20"
                      @input="filterDescription"
            >
            </textarea>
        </label>
        <label for="animal-province"
               class="filter-options__label"
        >
            Województwo
        </label>
        <div class="filter-options__dropdown-container"
             @keypress.enter="toggleProvinces"
             @keyup.up.stop="selectUpProvince"
             @keyup.down.stop="selectDownProvince"
             @focusout="hideProvinces"
             tabindex="0"
        >
            <div class="filter-options__dropdown-group"
                 @click="toggleProvinces"
            >
                <input type="text"
                       id="animal-province"
                       class="filter-options__dropdown"
                       v-model="selectedProvince"
                       disabled
                >
                <div class="filter-options__dropdown-arrow-container">
                    <font-awesome-icon class="filter-options__dropdown-arrow"
                                       icon="chevron-down"
                                       :class="{'filter-options__dropdown-arrow--active': areProvincesDisplayed}"
                    />
                </div>
            </div>
            <div class="results-list-container">
                <ul class="results-list"
                    :class="{'results-list--displayed': areProvincesDisplayed}"
                >
                    <li class="results-list__item"
                        v-for="province in provinces"
                        :class="{'results-list__item--selected': selectedProvince === province}"
                        @click="setProvince(province)"
                    >
                        {{ province }}
                    </li>
                </ul>
            </div>
        </div>
        <label for="animal-city"
               class="filter-options__label"
        >
            Miejscowość
            <input class="filter-options__input"
                   v-model="city"
                   type="text"
                   id="animal-city"
                   @input="filterCity"
            >
        </label>
    </div>
</template>

<script>
    import axios from "axios";

    export default {
        name: "FilterOptions",
        data() {
            return {
                areResultsDisplayed: false,
                species: [],
                filteredSpecies: [],
                selectedSpecies: '',
                name: '',
                description: '',
                provinces: ['Wszystkie', 'Dolnośląskie', 'Kujawsko-Pomorskie', 'Lubelskie',
                    'Lubuskie', 'Łódzkie', 'Małopolskie', 'Mazowieckie',
                    'Opolskie', 'Podkarpackie', 'Podlaskie',
                    'Pomorskie', 'Ślaskie', 'Świętokrzyskie',
                    'Warmińsko-Mazurskie', 'Wielkopolskie', 'Zachodniopomorskie'],
                selectedProvince: 'Wszystkie',
                areProvincesDisplayed: false,
                city: ''
            }
        },
        mounted() {
            this.getSpecies();
        },
        methods: {
            toggleResults: function() {
                this.areResultsDisplayed = !this.areResultsDisplayed;
            },
            showResults: function() {
                this.areResultsDisplayed = true;
            },
            selectUpSpecies: function() {
                if(this.areResultsDisplayed) {
                    var speciesIndex = this.species.map(species => species.name).indexOf(this.selectedSpecies);
                    if(speciesIndex > 0) {
                        this.selectedSpecies = this.species[speciesIndex - 1].name;
                    } else {
                        this.selectedSpecies = this.species[this.species.length - 1].name;
                    }
                    this.$emit('filterSpecies', this.selectedSpecies)
                }
            },
            selectDownSpecies: function() {
                if(this.areResultsDisplayed) {
                    var speciesIndex = this.species.map(species => species.name).indexOf(this.selectedSpecies);
                    if(this.species.length - 1 > speciesIndex) {
                        this.selectedSpecies = this.species[this.species.map(species => species.name)
                            .indexOf(this.selectedSpecies) + 1].name;
                    } else {
                        this.selectedSpecies = this.species[0].name;
                    }
                    this.$emit('filterSpecies', this.selectedSpecies)
                }
            },
            hideResults: function() {
                this.areResultsDisplayed = false;
            },
            toggleProvinces: function() {
                this.areProvincesDisplayed = !this.areProvincesDisplayed;
            },
            showProvinces() {
                this.areProvincesDisplayed = true;
            },
            selectUpProvince() {
                if(this.areProvincesDisplayed) {
                    var provinceIndex = this.provinces.indexOf(this.selectedProvince);
                    if(provinceIndex > 0) {
                        this.selectedProvince = this.provinces[provinceIndex - 1];
                    } else {
                        this.selectedProvince = this.provinces[this.provinces.length - 1];
                    }
                    this.$emit('filterProvince', this.selectedProvince)
                }
            },
            selectDownProvince() {
                if(this.areProvincesDisplayed) {
                    var provinceIndex = this.provinces.indexOf(this.selectedProvince);
                    if(this.provinces.length - 1 > provinceIndex) {
                        this.selectedProvince = this.provinces[this.provinces.indexOf(this.selectedProvince) + 1];
                    } else {
                        this.selectedProvince = this.provinces[0];
                    }
                    this.$emit('filterProvince', this.selectedProvince)
                }
            },
            hideProvinces() {
                this.areProvincesDisplayed = false;
            },
            getSpecies: function() {
                axios.get('/species')
                    .then(response => {
                        this.species = response.data;
                        this.species.sort(this.compareSpeciesIds);
                        this.filteredSpecies = this.species;
                    });
            },
            setSpecies: function(speciesName) {
                this.selectedSpecies  = speciesName;
                this.areResultsDisplayed = false;

                this.$emit('filterSpecies', this.selectedSpecies)
            },
            setProvince: function(province) {
                this.selectedProvince  = province;
                this.areProvincesDisplayed = false;

                this.$emit('filterProvince', this.selectedProvince)
            },
            compareSpeciesIds: function(a, b) {
                if(a.id > b.id) {
                    return 1
                } else  if(a.id < b.id) {
                    return -1
                }
                return 0;
            },
            filterSpecies: function() {
                this.filteredSpecies = this.species.filter(species => {
                    return species.name.toLowerCase().includes(this.selectedSpecies.toLowerCase())
                });
                this.areResultsDisplayed = true;
                if (this.filteredSpecies.length === 0) {
                    this.filteredSpecies.push({name: 'Brak wyników'});
                }
            },
            filterName: function() {
                this.$emit('filterName', this.name);
            },
            filterDescription: function() {
                this.$emit('filterDescription', this.description);
            },
            filterProvince: function() {
                this.$emit('filterProvince', this.selectedProvince);
            },
            filterCity: function() {
                this.$emit('filterCity', this.city);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .filter-options {
        position: relative;
        height: fit-content;
        background-color: #0057E8;
        margin: 0 auto 30px;
        padding: 15px;
        border-radius: 5px;
        color: #fff;
        width: 250px;
        box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);

        @media (min-width: 1024px) {
            margin: 0 0 30px;
        }

        &__label {
            font-weight: bold;
        }

        &__input {
            width: 100%;
            margin: 5px 0 10px;
            padding: 5px;
            font-size: 18px;
            border: 2px solid #00A8E8;
            border-radius: 3px 0 0 3px;
            box-sizing: border-box;
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #00dce8;
            }
        }

        &__dropdown-container {
            &:focus {
                outline: none;

                .filter-options__dropdown,
                .filter-options__dropdown-arrow-container {
                    box-shadow: 0 0 5px 0 #00dce8;
                }
            }
        }

        &__dropdown-group {
            display: flex;
            margin: 5px 0 10px;
        }

        &__dropdown {
            width: 100%;
            padding: 5px;
            font-size: 18px;
            border: 2px solid #00A8E8;
            border-radius: 3px 0 0 3px;
            box-sizing: border-box;
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #00dce8;
            }

            &:disabled {
                background-color: #fff;
                color: #000;
                cursor: pointer;
            }
        }

        &__dropdown-arrow-container {
            display: flex;
            align-items: center;
            padding: 0 10px;
            cursor: pointer;
            background-color: #00A8E8;
            border-radius: 0 3px 3px 0;
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.75);
        }

        &__dropdown-arrow {
            transition: all 0.5s ease-out;

            &--active {
                transform: rotate(180deg);
            }
        }

        .results-list-container {
            overflow: hidden;
            position: absolute;
            width: 200px;
            height: 128.33px;
            margin-top: -10px;
            pointer-events: none;
        }

        .results-list {
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
            pointer-events: all;
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

                &:hover, &--selected {
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

        &__textarea {
            margin-bottom: 10px;
        }
    }
</style>
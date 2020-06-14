<template>
    <div class="user-animals-page">
        <div class="user-info">
            <h2>Email</h2>
            <h2>Name</h2>
            <h3>User Type</h3>
        </div>
        <div class="animals-section">
            <transition name="fade">
                <div class="add-animal-success-message" v-show="addedAnimal">
                    Pomyślnie dodano nowego zwierzaka :)
                </div>
            </transition>
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
                        Kategoria:
                    </label>
                    <div class="add-animal-form__radio-group">
                        <div class="add-animal-form__radio-button-container">
                            <label class="add-animal-form__radio-label" for="adoption">Zwierzak do adopcji</label>
                            <input class="add-animal-form__radio-button"
                                   type="radio" id="adoption" name="category"
                                   value="adoption" v-model="category">
                        </div>
                        <div class="add-animal-form__radio-button-container">
                            <label class="add-animal-form__radio-label" for="wanted">Zwierzak, który chciałbym adoptować</label>
                            <input class="add-animal-form__radio-button"
                                   type="radio" id="wanted" name="category"
                                   value="wanted" v-model="category">
                        </div>
                        <div class="add-animal-form__radio-button-container">
                            <label class="add-animal-form__radio-label" for="lost">Zagioniony zwierzak</label>
                            <input class="add-animal-form__radio-button"
                                   type="radio" id="lost" name="category"
                                   value="lost" v-model="category">
                        </div>
                        <div class="add-animal-form__radio-button-container">
                            <label class="add-animal-form__radio-label" for="found">Znaleziony zwierzak</label>
                            <input class="add-animal-form__radio-button"
                                   type="radio" id="found" name="category"
                                   value="found" v-model="category">
                        </div>
                    </div>
                    <text-input
                            :label="'Imię zwierzaka:'"
                            :error="nameError"
                            @updateValue="nameUpdate"
                            @deleteErrorMessage="nameErrorDelete">
                    </text-input>
                    <label class="add-animal-form__label">
                        Gatunek:
                    </label>
                    <div class="add-animal-form__dropdown-group" @click="toggleSpecies">
                        <input type="text" id="animal-species" class="add-animal-form__dropdown"
                               :class="{'add-animal-form__dropdown--error': speciesError.length > 0}"
                               v-model="selectedSpecies" disabled>
                        <div class="add-animal-form__dropdown-arrow">
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
                        <textarea class="add-animal-form__input" rows="4" cols="20" v-model="description"></textarea>
                    </label>
<!--                    <div class="add-animal-form__input-group">-->
<!--                        <textarea class="add-animal-form__input" rows="4" cols="20" v-model="description"></textarea>-->
<!--                    </div>-->
                    <label class="add-animal-form__label">
                        Zdjęcie:
                        <input class="add-animal-form__image-input" type="file" accept="image/x-png,image/gif,image/jpeg" ref="image" @change="onFileChange">
                    </label>
<!--                    <div class="add-animal-form__input-group">-->
<!--                        <input type="file" accept="image/x-png,image/gif,image/jpeg" ref="image" @change="onFileChange">-->
<!--                    </div>-->
                    <input class="add-animal-form__submit"
                           type="submit"
                           value="Dodaj zwierzaka"
                           @click.prevent="addAnimal()"
                           v-show="!isLoading">
                    <clip-loader :loading="isLoading" :color="'#00A8E8'" :size="'45px'"></clip-loader>
                </form>
            </transition>
            <animal-tabs></animal-tabs>
        </div>
    </div>
</template>

<script>
    import TextInput from "./TextInput";
    import AnimalTabs from "./AnimalTabs";
    import axios from "axios";
    import ClipLoader from 'vue-spinner/src/ClipLoader';

    export default {
        name: "UserAnimals",
        components: {
            TextInput,
            AnimalTabs,
            ClipLoader
        },
        data() {
            return {
                name: '',
                species: [],
                selectedSpecies: '',
                description: '',
                category: '',
                image: '',
                isFormDisplayed: false,
                areSpeciesDisplayed: false,
                isLoading: false,
                nameError: '',
                speciesError: '',
                categoryError: '',
                addedAnimal: false
            }
        },
        methods: {
            nameUpdate: function(value) {
                console.log('XDDDD');
                this.name = value;
            },
            nameErrorDelete: function() {
                this.nameError = '';
            },
            toggleSpecies: function() {
                this.areSpeciesDisplayed = !this.areSpeciesDisplayed;
                if(this.selectedSpecies === this.speciesError) {
                    this.selectedSpecies = '';
                    this.speciesError = ''
                }
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
            onFileChange(e) {
                // var files = e.target.files || e.dataTransfer.files;
                // if (!files.length)
                //     return;
                // this.createImage(files[0]);

                this.image = this.$refs.image.files[0];
            },
            createImage(file) {
                var image = new Image();
                var reader = new FileReader();
                var vm = this;

                reader.onload = (e) => {
                    vm.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            addAnimal: function() {
                var formData = new FormData();
                formData.append('name', this.name);
                formData.append('species', this.selectedSpecies);
                formData.append('description', this.description);
                formData.append('category', this.category);
                formData.append('image', this.image);

                this.isLoading = true;
                axios.post('/add-animal', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.addedAnimal = true;
                    this.isLoading = false;
                    this.isFormDisplayed = false;
                    setTimeout(() => this.addedAnimal = false, 2000);
                }).catch(error => {
                    var errorMessages = error.response.data;
                    if(errorMessages.name) {
                        this.nameError = errorMessages.name[0];
                        this.name = this.nameError;
                    }
                    if(errorMessages.species) {
                        this.speciesError = errorMessages.species[0];
                        this.selectedSpecies = this.speciesError;
                    }
                    if(errorMessages.category) {
                        this.categoryError = errorMessages.category[0];
                    }

                    this.isLoading = false;
                })
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
        flex-direction: column;
        justify-content: space-between;
        max-width: 1000px;
        padding: 30px 5% 0 5%;
        margin: 0 auto;
        
        @media (min-width: 1024px) {
            flex-direction: row;
        }

        .user-info {
            background-color: #00A8E8;
            color: #fff;
            height: fit-content;
            width: fit-content;
            margin: 0 auto 15px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.75);

            @media (min-width: 1024px) {
                margin: 0;
            }
        }

        .animals-section {
            display: flex;
            flex-direction: column;

            .fade-enter-active, .fade-leave-active {
                transition: opacity .5s ease-in-out;
            }
            .fade-enter, .fade-leave-to {
                opacity: 0;
            }

            .add-animal-success-message {
                width: fit-content;
                align-self: center;
                background-color: #008c4b;
                color: #fff;
                font-weight: bold;
                padding: 20px;
                margin-bottom: 15px;
                border-radius: 5px;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.75);
            }

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
                    height: 0;
                    margin: 0;

                    * {
                        display: none;
                    }
                }
            }

            .slide-fade-enter-active {
                transition: all 0.5s ease-out;
            }
            .slide-fade-leave-active {
                transition: all 0.5s ease-out;
            }
            .slide-fade-enter, .slide-fade-leave-to {
                transform: translateY(-100px);
                opacity: 0;
            }

            .add-animal-form {
                width: 250px;
                height: fit-content;
                margin: 0 auto 15px;
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
                    font-weight: bold;
                }

                &__input {
                    display: block;
                    width: 100%;
                    margin: 5px 0 10px;
                    padding: 5px;
                    font-size: 18px;
                    border: 2px solid #00A8E8;
                    border-radius: 3px;
                    box-sizing: border-box;
                    box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

                    &:focus {
                        outline: none;
                        box-shadow: 0 0 5px 0 #00dce8;
                    }

                    &--error {
                        border-color: #C82829;
                        background-color: #eeaaaa;
                        color: #C82829;

                        &:focus {
                            box-shadow: 0 0 5px 0 #eeaaaa;
                        }
                    }
                }

                &__dropdown-group {
                    display: flex;
                    margin: 5px 0 10px;
                }

                &__dropdown {
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

                    &:focus {
                        outline: none;
                        box-shadow: 0 0 5px 0 #00dce8;
                    }

                    &--error:disabled {
                        border-color: #C82829;
                        background-color: #eeaaaa;
                        color: #C82829;

                        &:focus {
                            box-shadow: 0 0 5px 0 #eeaaaa;
                        }
                    }
                }

                &__dropdown {
                    border-radius: 3px 0 0 3px;
                }

                &__dropdown-arrow {
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
                    pointer-events: none;
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

                &__radio-group {
                    margin-bottom: 10px;
                }

                &__radio-button-container {
                    font-size: 13px;
                    display: flex;
                    justify-content: space-between;
                    margin: 3px 0;
                }

                &__radio-label {
                    color: #fff;
                    cursor: pointer;
                    transition: all 0.5s ease-in-out;

                    &:hover {
                        color: #00a8e8;
                    }
                }

                &__image-input {
                    margin: 5px 0 10px;
                }

                &__submit {
                    display: block;
                    width: 50%;
                    padding: 7px 0;
                    margin: 0 auto;
                    white-space: normal;
                    background-color: #00A8E8;
                    color: #fff;
                    font-size: 16px;
                    font-weight: bold;
                    border: 1px solid transparent;
                    border-radius: 3px;
                    cursor: pointer;
                    box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);
                }
            }
        }
    }

</style>
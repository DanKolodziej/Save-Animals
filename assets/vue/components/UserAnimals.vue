<template>
    <div class="user-animals-page"
         :class="{'user-animals-page--centered': owner !== null}"
    >
        <div class="users-animals">
            <div class="user-info">
                <h2 class="user-info__name">
                    {{ ownerName }}
                </h2>
            </div>
            <AnimalTabs :id="parseInt(id)"/>
        </div>
        <div class="add-animal-form-column"
             v-if="owner === null"
        >
            <transition name="fade">
                <div class="add-animal-success-message"
                     v-show="addedAnimal"
                >
                    Pomyślnie dodano nowego zwierzaka :)
                </div>
            </transition>
            <font-awesome-icon class="add-animal-icon"
                               :class="{'add-animal-icon--hidden': isFormDisplayed}"
                               icon="plus" size="3x"
                               @click="isFormDisplayed = true"
            />
            <transition name="slide-fade">
                <form class="add-animal-form"
                      v-show="isFormDisplayed"
                >
                    <div class="add-animal-form__minimize-icon-container">
                        <font-awesome-icon class="add-animal-form__minimize-icon"
                                           icon="minus" size="3x"
                                           @click="isFormDisplayed = false"
                        />
                    </div>
                    <label class="add-animal-form__label">
                        Kategoria
                    </label>
                    <div class="add-animal-form__radio-group">
                        <div class="add-animal-form__radio-button-container">
                            <input class="add-animal-form__radio-button"
                                   type="radio"
                                   id="adoption"
                                   name="category"
                                   value="adoption"
                                   v-model="category"
                            >
                            <label class="add-animal-form__radio-label"
                                   for="adoption"
                            >
                                Zwierzak do adopcji
                            </label>
                        </div>
                        <div class="add-animal-form__radio-button-container">
                            <input class="add-animal-form__radio-button"
                                   type="radio"
                                   id="wanted"
                                   name="category"
                                   value="wanted"
                                   v-model="category"
                            >
                            <label class="add-animal-form__radio-label"
                                   for="wanted"
                            >
                                Zwierzak, który chciałbym adoptować
                            </label>
                        </div>
                        <div class="add-animal-form__radio-button-container">
                            <input class="add-animal-form__radio-button"
                                   type="radio"
                                   id="lost"
                                   name="category"
                                   value="lost"
                                   v-model="category"
                            >
                            <label class="add-animal-form__radio-label"
                                   for="lost"
                            >
                                Zagioniony zwierzak
                            </label>
                        </div>
                        <div class="add-animal-form__radio-button-container">
                            <input class="add-animal-form__radio-button"
                                   type="radio"
                                   id="found"
                                   name="category"
                                   value="found"
                                   v-model="category"
                            >
                            <label class="add-animal-form__radio-label"
                                   for="found">
                                Znaleziony zwierzak
                            </label>
                        </div>
                    </div>
                    <TextInput
                            :label="'Imię zwierzaka'"
                            :error="nameError"
                            @updateValue="nameUpdate"
                            @deleteErrorMessage="nameErrorDelete"
                            v-show="category !== 'wanted' && category !== 'found'"
                    >
                    </TextInput>
                    <label class="add-animal-form__label">
                        Gatunek
                    </label>
                    <div class="add-animal-form__dropdown-container"
                         @focusout="hideSpecies"
                         tabindex="0"
                    >
                        <div class="add-animal-form__dropdown-group"
                             @click="toggleSpecies"
                        >
                            <input type="text"
                                   id="animal-species"
                                   class="add-animal-form__dropdown"
                                   :class="{'add-animal-form__dropdown--error': speciesError.length > 0}"
                                   v-model="selectedSpecies"
                                   disabled
                            >
                            <div class="add-animal-form__dropdown-arrow-container">
                                <font-awesome-icon class="add-animal-form__dropdown-arrow"
                                                   icon="chevron-down"
                                                   :class="{'add-animal-form__dropdown-arrow--active': areSpeciesDisplayed}"
                                />
                            </div>
                        </div>
                        <div class="species-list-container">
                            <ul class="species-list"
                                :class="{'species-list--displayed': areSpeciesDisplayed}"
                            >
                                <li class="species-list__item"
                                    v-for="speciesName in species"
                                    @click="setSpecies(speciesName.nameSingular)"
                                >
                                    {{ speciesName.nameSingular }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <label class="add-animal-form__label">
                        Opis
                        <textarea class="add-animal-form__input"
                                  :class="{'add-animal-form__input--error': descriptionError.length > 0}"
                                  rows="3" cols="20"
                                  v-model="description"
                                  @click="descriptionErrorDelete"
                                  :placeholder="descriptionError"
                        >
                        </textarea>
                    </label>
                    <TextInput
                            :label="'Kontakt (email/tel./facebook/inne)'"
                            :error="contactError"
                            @updateValue="contactUpdate"
                            @deleteErrorMessage="contactErrorDelete"
                    >
                    </TextInput>
                    <input class="add-animal-form__image-input"
                           id="animal-image" type="file"
                           accept="image/x-png,image/gif,image/jpeg"
                           ref="image"
                           @change="onFileChange"
                    >
                    <label class="add-animal-form__image-label"
                           for="animal-image"
                    >
                        <font-awesome-icon
                                icon="file-image"
                                size="lg"
                        />
                        {{ imageInputlabel }}
                    </label>
                    <input class="add-animal-form__submit"
                           type="submit"
                           value="Dodaj zwierzaka"
                           @click.prevent="addAnimal()"
                           v-show="!isLoading"
                    >
                    <ClipLoader
                            :loading="isLoading"
                            :color="'#fff'"
                            :size="'45px'"
                    />
                </form>
            </transition>
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
        props: {
            id: {
                required: false
            }
        },
        data() {
            return {
                owner: {},
                ownerName: '',
                name: '',
                species: [],
                selectedSpecies: '',
                description: '',
                category: 'adoption',
                contact: '',
                image: '',
                ImageFileName: '',
                isFormDisplayed: false,
                areSpeciesDisplayed: false,
                isLoading: false,
                categoryError: '',
                nameError: '',
                speciesError: '',
                descriptionError: '',
                contactError: '',
                addedAnimal: false
            }
        },
        computed: {
            userName: function() {
                return this.$store.getters.userName
            },
            imageInputlabel: function () {
                return this.ImageFileName.length > 0 ? this.ImageFileName : 'Wybierz zdjęcie zwierzaka';
            }
        },
        mounted() {
            if(!isNaN(parseInt(this.id))) {
                this.getOwner();
            } else {
                this.owner = null;
                this.ownerName = this.$store.getters.userName;
            }
            this.getSpecies();
        },
        methods: {
            getOwner: function() {
                axios.get('/owner/' + this.id)
                    .then(response => {
                        this.owner = response.data.owner;
                        this.ownerName = this.owner.name;
                    });
            },
            nameUpdate: function(value) {
                this.name = value;
            },
            nameErrorDelete: function() {
                this.nameError = '';
            },
            descriptionErrorDelete: function() {
                this.descriptionError = '';
            },
            toggleSpecies: function() {
                this.areSpeciesDisplayed = !this.areSpeciesDisplayed;
                if(this.selectedSpecies === this.speciesError) {
                    this.selectedSpecies = '';
                    this.speciesError = ''
                }
            },
            hideSpecies: function() {
                this.areSpeciesDisplayed = false;
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
            contactUpdate: function(value) {
                this.contact = value;
            },
            contactErrorDelete: function() {
                this.contactError = '';
            },
            onFileChange() {
                this.image = this.$refs.image.files[0];
                this.ImageFileName = this.image.name;
            },
            addAnimal: function() {
                var formData = new FormData();
                formData.append('name', this.name);
                formData.append('species', this.selectedSpecies);
                formData.append('description', this.description);
                formData.append('category', this.category);
                formData.append('contact', this.contact);
                formData.append('image', this.image);

                this.isLoading = true;
                axios.post('/add-animal', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(() => {
                    this.addedAnimal = true;
                    this.isLoading = false;
                    this.isFormDisplayed = false;
                    setTimeout(() => this.addedAnimal = false, 3000);
                }).catch(error => {
                    var errorMessages = error.response.data;
                    if(errorMessages.name) {
                        this.nameError = errorMessages.name[0];
                        this.name = '';
                    }
                    if(errorMessages.species) {
                        this.speciesError = errorMessages.species[0];
                        this.selectedSpecies = this.speciesError;
                    }
                    if(errorMessages.category) {
                        this.categoryError = errorMessages.category[0];
                    }
                    if(errorMessages.description) {
                        this.descriptionError = errorMessages.description[0];
                        this.description = '';
                    }
                    if(errorMessages.contact) {
                        this.contactError = errorMessages.contact[0];
                        this.contact = '';
                    }

                    this.isLoading = false;
                })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .user-animals-page {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        max-width: 1000px;
        padding: 30px 2%;
        margin: 0 auto;
        
        @media (min-width: 1024px) {
            flex-direction: row;
            justify-content: space-between;
        }

        &--centered {
            @media (min-width: 1024px) {
                justify-content: center;
            }
        }

        .user-info {
            display: block;
            border: 1px solid #e0e0e0;
            background-color: #fff;
            height: fit-content;
            width: fit-content;
            width: -moz-fit-content;
            margin: 0 auto 30px;
            padding: 10px 30px;
            border-radius: 5px;

            &__name {
                margin: 0;
            }
        }

        .add-animal-form-column {
            display: flex;
            flex-direction: column;
            width: 300px;
            margin: 0 auto;

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
                margin-top: 30px;
                border-radius: 5px;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.75);

                @media (min-width: 1024px) {
                    margin-top: 0;
                    margin-bottom: 30px;
                }
            }

            .add-animal-icon {
                align-self: center;
                color: #008c4b;
                margin-top: 30px;
                padding: 0 3px;
                border-radius: 5px;
                transition: all 0.5s ease-out;
                cursor: pointer;
                opacity: 1;

                @media (min-width: 1024px) {
                    margin-top: 0;
                }

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
                align-self: center;
                width: 250px;
                height: fit-content;
                margin: 30px auto 15px;
                padding: 15px;
                background-color: #6495ed;
                border-radius: 5px;
                box-shadow: 0 0 20px 0 rgba(0,0,0,0.75);

                @media (min-width: 1024px) {
                    margin-top: 0;
                }

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
                        color: #6495ED;
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

                        &::placeholder {
                            color: #C82829;
                        }
                    }
                }

                &__dropdown-container {
                    &:focus {
                        outline: none;

                        .add-animal-form__dropdown,
                        .add-animal-form__dropdown-arrow-container {
                            box-shadow: 0 0 5px 0 #00dce8;
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
                        color: #000;
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

                &__dropdown-arrow-container {
                    display: flex;
                    align-items: center;
                    padding: 0 10px;
                    cursor: pointer;
                    background-color: #00A8E8;
                    color: #fff;
                    border-radius: 0 3px 3px 0;
                    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.75);
                }

                &__dropdown-arrow {
                    transition: all 0.5s ease-out;

                    &--active {
                        transform: rotate(180deg);
                    }
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
                    margin: 3px 0;
                }

                &__radio-label {
                    color: #fff;
                    cursor: pointer;
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

                &__image-input {
                    width: 0.1px;
                    height: 0.1px;
                    opacity: 0;
                    overflow: hidden;
                    position: absolute;
                    z-index: -1;
                }

                &__image-label {
                    display: block;
                    width: calc(100% - 12px);
                    padding: 7px 5px;
                    margin: 15px 0;
                    background-color: #00A8E8;
                    color: #fff;
                    text-align: center;
                    font-size: 16px;
                    font-weight: bold;
                    border: 1px solid transparent;
                    border-radius: 3px;
                    text-overflow: ellipsis;
                    white-space: nowrap;
                    overflow: hidden;
                    cursor: pointer;
                    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.75);
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

                    &:focus {
                        outline: none;
                        box-shadow: 0 0 5px 0 #00dce8;
                    }
                }
            }

            .add-animal-form__image-input:focus + .add-animal-form__image-label {
                outline: none;
                box-shadow: 0 0 5px 0 #00dce8;
            }
        }
    }

</style>
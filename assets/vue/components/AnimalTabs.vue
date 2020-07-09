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
            <animal-card class="animal-card--deletable"
                         v-for="animal in adoptionAnimals"
                         :key="animal.id"
                         :ref="'animal-card-' + animal.id"
                         :id="parseInt(animal.id)"
                         :name="animal.name"
                         :description="animal.description"
                         :image-file-name="animal.imageFileName == null ? '' : animal.imageFileName">
                <button v-if="isNaN(id)"
                        class="animal-tabs__delete-button"
                        @click="deleteAnimal(animal.id)">
                    Usuń
                </button>
            </animal-card>
            <clip-loader class="animal-tabs__loading-icon"
                         :loading="isAdoptionLoading"
                         :color="'#008c4b'"
                         :size="'45px'">
            </clip-loader>
            <p v-show="adoptionAnimals.length === 0 && !isAdoptionLoading"
               class="animal-tabs__no-animals-message">
                Brak zwierzaków
            </p>
        </div>
        <div class="animal-tabs__content animal-tabs__wanted" v-show="isWantedTabActive">
            <animal-card class="animal-card--deletable"
                         v-for="animal in wantedAnimals"
                         :key="animal.id"
                         :ref="'animal-card-' + animal.id"
                         :id="parseInt(animal.id)"
                         :name="animal.name"
                         :description="animal.description"
                         :image-file-name="animal.imageFileName == null ? '' : animal.imageFileName">
                <button v-if="isNaN(id)"
                        class="animal-tabs__delete-button"
                        @click="deleteAnimal(animal.id)">
                    Usuń
                </button> 
            </animal-card>
            <clip-loader class="animal-tabs__loading-icon"
                         :loading="isWantedLoading"
                         :color="'#00b84b'"
                         :size="'45px'">
            </clip-loader>
            <p v-show="wantedAnimals.length === 0 && !isWantedLoading"
               class="animal-tabs__no-animals-message">
                Brak zwierzaków
            </p>
        </div>
        <div class="animal-tabs__content animal-tabs__lost" v-show="isLostTabActive">
            <animal-card class="animal-card--deletable"
                         v-for="animal in lostAnimals"
                         :key="animal.id"
                         :ref="'animal-card-' + animal.id"
                         :id="parseInt(animal.id)"
                         :name="animal.name"
                         :description="animal.description"
                         :image-file-name="animal.imageFileName == null ? '' : animal.imageFileName">
                <button v-if="isNaN(id)"
                        class="animal-tabs__delete-button"
                        @click="deleteAnimal(animal.id)">
                    Usuń
                </button>
            </animal-card>
            <clip-loader class="animal-tabs__loading-icon"
                         :loading="isLostLoading"
                         :color="'#192bc2'"
                         :size="'45px'">
            </clip-loader>
            <p v-show="lostAnimals.length === 0 && !isLostLoading"
               class="animal-tabs__no-animals-message">
                Brak zwierzaków
            </p>
        </div>
        <div class="animal-tabs__content animal-tabs__found" v-show="isFoundTabActive">
            <animal-card class="animal-card--deletable"
                         v-for="animal in foundAnimals"
                         :key="animal.id"
                         :ref="'animal-card-' + animal.id"
                         :id="parseInt(animal.id)"
                         :name="animal.name"
                         :description="animal.description"
                         :image-file-name="animal.imageFileName == null ? '' : animal.imageFileName">
                <button v-if="isNaN(id)"
                        class="animal-tabs__delete-button"
                        @click="deleteAnimal(animal.id)">
                    Usuń
                </button>
            </animal-card>
            <clip-loader class="animal-tabs__loading-icon"
                         :loading="isFoundLoading"
                         :color="'#00a8e8'"
                         :size="'45px'">
            </clip-loader>
            <p v-show="foundAnimals.length === 0 && !isFoundLoading"
               class="animal-tabs__no-animals-message">
                Brak zwierzaków
            </p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import AnimalCard from "./AnimalCard";
    import ClipLoader from 'vue-spinner/src/ClipLoader';

    export default {
        name: "AnimalTabs",
        components: {
            AnimalCard,
            ClipLoader
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
                userId: null,
                isAdoptionLoading: false,
                isWantedLoading: false,
                isLostLoading: false,
                isFoundLoading: false
            }
        },
        props: {
            id: {
                type: Number,
                required: false
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
                this.isAdoptionLoading = true;
                axios.get('/animals-by-user-category?user-id=' + this.userId + '&category=adoption')
                    .then(response => {
                        this.isAdoptionLoading = false;
                        this.adoptionAnimals = response.data['animals'];
                    })
            },
            getUsersWantedAnimals: function () {
                this.isWantedLoading = true;
                axios.get('/animals-by-user-category?user-id=' + this.userId + '&category=wanted')
                    .then(response => {
                        this.isWantedLoading = false;
                        this.wantedAnimals = response.data['animals'];
                    })
            },
            getUsersLostAnimals: function () {
                this.isLostLoading = true;
                axios.get('/animals-by-user-category?user-id=' + this.userId + '&category=lost')
                    .then(response => {
                        this.isLostLoading = false;
                        this.lostAnimals = response.data['animals'];
                    })
            },
            getUsersFoundAnimals: function () {
                this.isFoundLoading = true;
                axios.get('/animals-by-user-category?user-id=' + this.userId + '&category=found')
                    .then(response => {
                        this.isFoundLoading = false;
                        this.foundAnimals = response.data['animals'];
                    })
            },
            deleteAnimal: function(id) {
                axios.delete('/delete-animal/' + id)
                    .then(response => {
                        this.$refs['animal-card-' + id][0].$el.style.display = 'none';
                        switch(response.data.category) {
                            case 'adoption':
                                this.getUsersAdoptionAnimals();
                                break;
                            case 'wanted':
                                this.getUsersWantedAnimals();
                                break;
                            case 'lost':
                                this.getUsersLostAnimals();
                                break;
                            case 'found':
                                this.getUsersFOundAnimals();
                                break;
                        }
                    });
            }
        },
        mounted() {
            if(!isNaN(this.id)) {
                this.userId = this.id;
            } else {
                this.userId = this.$store.getters.userId;
            }

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
            font-size: 13px;
            border-radius: 5px 5px 0 0;
            border: 1px solid transparent;
            border-bottom: 1px solid #e0e0e0;
            padding: 5px 6px;
            cursor: pointer;
            transition: all 0.5s ease-out;

            @media (min-width: 768px) {
                padding: 5px 15px;
                font-size: 16px;
            }

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
            padding-top: 30px;
            border: 1px solid #e0e0e0;
            border-top: 0;
        }

        &__loading-icon {
            margin-bottom: 30px;
        }

        &__no-animals-message {
            text-align: center;
            font-style: italic;
            margin: 0 0 30px;
        }

        &__delete-button {
            height: 35px;
            padding: 7px 14px;
            background-color: #d9534f;
            color: #fff;
            text-transform: uppercase;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            border: 2px solid #d9534f;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.5s ease;
            opacity: 0;

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #008c4b;
            }
        }

        .animal-card--deletable:hover &__delete-button {
            opacity: 1;
        }
    }
</style>
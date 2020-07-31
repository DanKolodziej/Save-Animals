<template>
    <div class="slider">
        <Carousel
                :per-page="1"
                :autoplay="true"
                :loop="true"
                :paginationPadding="6"
                :paginationPosition="'bottom-overlay'"
                :mouse-drag="false"
        >
            <slide class="slider__slide"
                   v-for="animal in animals"
                   :style="{'background-image': 'url(' + getImage(animal.imageSrc) + ')'}"
            >
                <div v-if="animal.imageSrc === null"
                     class="slider__no-image-info"
                >
                    Brak zdjęcia
                </div>
                <div class="slider__slide-text">
                    <h2 v-show="animal.name.length > 0"
                        class="slider__slide-title"
                    >
                        {{ animal.name }}
                    </h2>
                    <p v-show="animal.description.length > 0"
                       class="slider__slide-description"
                    >
                        {{ animal.description }}
                    </p>
                    <p class="slider__slide-category">
                        <span v-if="animal.type === 'endangeredSpecies'">Kategoria zagrożenia: </span>{{ category(animal.category) }}
                    </p>
                    <RouterLink v-if="animal.type === 'animal'"
                                 :to="{name: 'animal', params: {id: animal.id}}"
                                 class="slider__slide-link"
                    >
                        Sprawdź
                    </RouterLink>
                    <RouterLink v-else-if="animal.type === 'endangeredSpecies'"
                                 :to="{name: 'endangeredSpecies', params: {name: encodeName(animal.name)}}"
                                 class="slider__slide-link"
                    >
                        Sprawdź
                    </RouterLink>
                </div>
            </slide>
        </Carousel>
    </div>
</template>

<script>
    import { Carousel, Slide } from 'vue-carousel';
    import axios from 'axios';

    export default {
        name: "Slider",
        components: {
            Carousel,
            Slide
        },
        data() {
          return {
              animals: []
          }
        },
        computed: {
            threeRandomEndangeredSpecies: function() {
                return this.$store.getters.threeRandomEndangeredSpecies;
            }
        },
        watch: {
            threeRandomEndangeredSpecies: function(newThreeRandomEndangeredSpecies) {
                if(newThreeRandomEndangeredSpecies.length > 0) {
                    var threeRandomEndangeredSpecies = newThreeRandomEndangeredSpecies
                        .map(endangeredSpecies => {
                            return {
                                name: endangeredSpecies.name,
                                description: endangeredSpecies.description,
                                category: endangeredSpecies.endangeredSpeciesType,
                                imageSrc: endangeredSpecies.imageLink,
                                type: 'endangeredSpecies'
                            }
                        });
                    this.animals = this.animals.concat(threeRandomEndangeredSpecies);
                    this.animals = this.animals.sort(() => 0.5 - Math.random());
                }
            }
        },
        created() {
            axios.get('/three-random-animals')
                .then(response => {
                    var randomAnimals = response.data.animals.map(animal => {
                        return {
                            id: animal.id,
                            name: animal.name,
                            description: animal.description,
                            category: animal.category,
                            imageSrc: animal.image_file_name,
                            type: 'animal'
                        }
                    });;
                    this.animals = this.animals.concat(randomAnimals);
                    this.animals = this.animals.sort(() => 0.5 - Math.random());
                });
        },
        methods: {
            category: function(category) {
                if(category === 'adoption') {
                    return 'adopcja';
                } else if(category === 'wanted') {
                    return 'poszukiwany';
                } else if(category === 'lost') {
                    return 'zaginiony';
                } else if(category === 'found') {
                    return 'znaleziony';
                }
                return category;
            },
            getImage: function(imageSrc) {
                if(imageSrc !== null) {
                    if(imageSrc.includes('upload.wikimedia.org')) {
                        return imageSrc;
                    } else {
                        return require(`../../../public/uploads/images/${imageSrc}`)
                    }
                }
            },
            encodeName: function(name) {
                return encodeURI(name);
            },
        }
    }
</script>

<style lang="scss" scoped>
    .slider {
        &__slide {
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 60vh;

            &:first-child {
                background-color: #00A650;
            }

            &:nth-child(2) {
                background-color: #00E813;
            }

            &:nth-child(3) {
                background-color: #00E8B2;
            }

            &:nth-child(4) {
                background-color: #007FE8;
            }

            &:nth-child(5) {
                background-color: #0057E8;
            }

            &:last-child {
                background-color: #002FE8;
            }
        }

        &__no-image-info {
            align-self: center;
            background-color: #fff;
            padding: 2%;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            text-transform: uppercase;
            font-style: italic;
            font-weight: bold;

            @media (min-width: 1024px) {
                padding: 1%;
            }
        }

        &__slide-text {
            max-width: 170px;
            align-self: flex-end;
            background-color: #fff;
            padding: 2%;
            margin: 2% 2% 35px;
            border: 1px solid #e0e0e0;
            border-radius: 5px;

            @media (min-width: 768px) {
                padding: 15px;
                margin: 4%;
            }
        }

        &__slide-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-top: 0;
            margin-bottom: 5px;

            &--endangered-species {
                text-transform: capitalize;
            }
        }

        &__slide-description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
            margin-top: 0;
            margin-bottom: 5px;
        }

        &__slide-category {
            margin-top: 0;
            text-transform: uppercase;
            font-size: 12px;
            font-style: italic;
        }

        &__slide-link {
            color: #0057E8;
            text-decoration: none;

            &:active, &:visited {
                color: #0057E8;
            }
        }
    }
</style>
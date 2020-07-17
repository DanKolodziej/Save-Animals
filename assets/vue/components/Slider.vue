<template>
    <div class="slider">
        <carousel :per-page="1" :autoplay="true" :loop="true" :paginationPadding="6" :paginationPosition="'bottom-overlay'" :mouse-drag="false">
            <slide class="slider__slide"
                   v-for="animal in animals"
                   :style="{'background-image': 'url(' + getImage(animal.imageSrc) + ')'}">
                <div class="slider__slide-text">
                    <h2 v-show="animal.name.length > 0"
                        class="slider__slide-title">
                        {{ animal.name }}
                    </h2>
                    <p v-show="animal.description.length > 0"
                       class="slider__slide-description">
                        {{ animal.description }}
                    </p>
                    <p class="slider__slide-category">
                        <span class="slider__slide-category-name">{{ category(animal.category) }}</span>
                    </p>
                    <router-link v-if="animal.type === 'animal'"
                                 :to="{name: 'animal', params: {id: animal.id}}"
                                 class="slider__slide-link">
                        Sprawdź
                    </router-link>
                    <router-link v-else-if="animal.type === 'endangeredSpecies'"
                                 :to="{name: 'endangeredSpecies', params: {name: encodeName(animal.name)}}"
                                 class="slider__slide-link">
                        Sprawdź
                    </router-link>
                </div>
            </slide>
        </carousel>
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
                if(imageSrc.includes('upload.wikimedia.org')) {
                    return imageSrc;
                } else {
                    return require(`../../../public/uploads/images/${imageSrc}`)
                }
            },
            encodeName: function(name) {
                return encodeURI(name);
            },
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

            @media (min-width: 768px) {
                background-size: contain;
                height: 50vh;
            }

            @media (min-width: 1024px) {
                height: 40vh;
            }

            &:first-child {
                background-color: #008ee8;
            }

            &:nth-child(2) {
                background-color: #0096AF;
            }

            &:nth-child(3) {
                background-color: #00A64B;
            }

            &:nth-child(4) {
                background-color: #6495ed;
            }

            &:nth-child(5) {
                background-color: #008C65;
            }

            &:last-child {
                background-color: #007CAF;
            }
        }

        &__slide-text {
            max-width: 150px;
            align-self: flex-end;
            background-color: #fff;
            padding: 2%;
            margin: 2% 2% 25px;
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
            color: #192BC2;
            text-decoration: none;

            &:active, &:visited {
                color: #6495ed;
            }
        }
    }
</style>
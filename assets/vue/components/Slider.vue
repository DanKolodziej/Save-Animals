<template>
    <div class="slider">
        <carousel :per-page="1" :autoplay="true" :loop="true" :paginationPadding="6" :paginationPosition="'bottom-overlay'" :mouse-drag="false">
            <slide class="slider__slide" v-for="animal in animals" :style="{'background-image': 'url(' + require(`../../../public/uploads/images/${animal['image_file_name']}`) + ')'}">
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
                    <router-link :to="{name: 'animal', params: {id: animal.id}}"
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
            }
        },
        created() {
            axios.get('/three-random-animals')
                .then(response => {
                    this.animals = response.data.animals;
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
            height: 50vh;
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
                margin-bottom: 2%;
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
            margin-bottom: 0;
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
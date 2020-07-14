<template>
    <div class="slider">
        <carousel :per-page="1" :autoplay="true" :loop="true" :paginationPosition="'bottom-overlay'" :mouse-drag="false">
            <slide class="slider__slide" v-for="animal in animals" :style="{'background-image': 'url(' + require(`../../../public/uploads/images/${animal['image_file_name']}`) + ')'}">
                <div class="slider__slide-text">
                    <h2 v-show="animal.name !== undefined"
                        class="slider__slide-title"
                        :class="{'slider__slide-title--no-description': animal.description !== undefined}">
                        {{ animal.name }}
                    </h2>
                    <p v-show="animal.description !== undefined"
                       class="slider__slide-description"
                       :class="{'slider__slide-description--no-title': animal.name !== undefined}">
                        {{ animal.description }}
                    </p>
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
            margin: 2% 2% 40px;
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

            &--no-description {
                margin-bottom: 0;
            }
        }

        &__slide-description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
            margin-bottom: 0;

            &--no-title {
                margin-top: 0;
            }
        }
    }
</style>
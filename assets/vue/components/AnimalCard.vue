<template>
    <div class="animal-card">
        <div class="animal-card__image-container">
            <img class="animal-card__image"
                 :src="require(`../../../public/uploads/images/${imageName}`)">
            <button class="animal-card__cta-button">
                <router-link :to="{name: 'animal', params: {id: id}}"
                             class="animal-card__link">
                    Sprawdź
                </router-link>
            </button>
        </div>
        <div class="animal-card__text" :class="{'animal-card__text--hover-hide': hasDeleteButton}">
            <h2 class="animal-card__name" v-show="name.length > 0">{{ name }}</h2>
            <p class="animal-card__description" v-show="description.length > 0">
                {{ description }}
            </p>
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AnimalCard",
        props: {
            id: {
                type: Number,
                required: true,
            },
            name: {
                type: String,
                required: false,
                default: ''
            },
            description: {
                type: String,
                required: false,
                default: ''
            },
            imageFileName: {
                type: String,
                required: true,
            }
        },
        computed: {
            imageName: function() {
                if(this.imageFileName.length === 0) {
                    return 'placeholder.png'
                }
                return this.imageFileName;
            },
            hasDeleteButton() {
                return !!this.$slots.default;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .animal-card {
        background-color: #fff;
        box-shadow: 0 0 15px 0 rgba(0,0,0,0.75);
        border-radius: 5px;
        width: 60%;
        height: fit-content;
        height: -moz-fit-content;
        margin: 15px auto;
        max-width: none;
        overflow:auto;

        &:first-child {
            margin-top: 0;
        }

        @media (min-width: 768px) {
            width: auto;
            max-width: 200px;
            margin: 0 15px 30px;
        }

        &__image-container {
            position: relative;
        }

        &__image {
            width: 100%;
            object-fit: cover;
            border-radius: 5px 5px 0 0;
            transition: all 0.5s ease;
        }

        &__cta-button {
            height: 35px;
            padding: 7px 14px;
            background-color: #008c4b;
            color: #fff;
            text-transform: uppercase;
            border: 2px solid #008c4b;
            border-radius: 5px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            cursor: pointer;
            transition: all 0.5s ease;
            opacity: 0;

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #008c4b;
            }
        }

        &__link {
            color: #fff;
            text-decoration: none;

            &:active, &:visited {
                color: #fff;
            }
        }

        &__text {
            position: relative;
            padding: 0 15px;
            transition: all 0.5s ease;
        }

        &__name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        &__description {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
        }
    }

    .animal-card:hover .animal-card__image {
        filter: brightness(0.3);
    }

    .animal-card:hover .animal-card__cta-button {
        opacity: 1;
    }

    .animal-card:hover .animal-card__text--hover-hide {
        color: transparent;
        user-select: none;
    }
</style>
<template>
    <div class="animal-card">
        <img class="animal-card__image"
             :src="require(`../../../public/uploads/images/${imageName}`)">
        <div class="animal-card__text">
            <h2 class="animal-card__name" v-show="name.length > 0">{{ name }}</h2>
            <p class="animal-card__description" v-show="description.length > 0">
                {{ description }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AnimalCard",
        props: {
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
                required: false,
                default: ''
            }
        },
        computed: {
            imageName: function() {
                if(this.imageFileName.length === 0) {
                    return 'placeholder.png'
                }
                return this.imageFileName;
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
        margin: 15px auto;
        max-width: none;

        &:first-child {
            margin-top: 0;
        }

        @media (min-width: 768px) {
            width: auto;
            max-width: 200px;
            margin: 0 15px 30px;
        }

        &__image {
            width: 100%;
            object-fit: cover;
            border-radius: 5px 5px 0 0;
        }

        &__text {
            padding: 0 15px;
        }
    }
</style>
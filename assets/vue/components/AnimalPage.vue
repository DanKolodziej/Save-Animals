<template>
    <div class="animal-page">
        <img class="animal__image"
             :src="imageName">
        <div class="animal__text">
            <h2 class="animal__name">{{ name }}</h2>
            <p class="animal__description">
                {{ description }}
            </p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "AnimalPage",
        data() {
            return {
                description: '',
                imageName: ''
            }
        },
        props: {
            name: {
                type: String,
                required: true
            }
        },
        methods: {
            getEndangeredSpecies: function() {
                axios.get('/singular-endangered-species-data/' + this.name)
                    .then(response => {
                        this.description = response.data.description;
                        this.imageName = response.data.imageLink;
                    })
            }
        },
        created() {
            this.getEndangeredSpecies();
        }
    }
</script>

<style lang="scss" scoped>
    .post {
        max-width: 1450px;
        margin: 0 auto 30px;
        color: #192BC2;

        @media (min-width: 1024px) {
            margin-bottom: 30px;
        }

        &__image {
            display: block;
            width: 80%;
            max-width: 450px;
            margin: 30px auto 0;
        }

        &__text {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 0 10%;
        }

        &__description {
            margin-top: 0;
        }
    }
</style>
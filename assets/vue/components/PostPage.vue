<template>
    <div class="post">
        <img class="post__image"
             :src="imageName"
        >
        <div class="post__text">
            <h2 class="post__name">
                {{ decodedName }}
            </h2>
            <p class="post__description">
                {{ description }}
            </p>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "PostPage",
        props: {
            name: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                description: '',
                imageName: ''
            }
        },
        computed: {
            decodedName: function() {
                return decodeURI(this.name);
            }
        },
        created() {
            this.getEndangeredSpecies();
        },
        methods: {
            getEndangeredSpecies: function() {
                var endangeredSpecies = this.$store.getters.endangeredSpeciesByName(this.decodedName)[0];
                if(endangeredSpecies !== undefined) {
                    this.description = endangeredSpecies.description;
                    this.imageName = endangeredSpecies.imageLink;
                } else {
                    axios.get('/endangered-species/' + this.name)
                        .then(response => {
                            this.description = response.data.endangeredSpecies.description;
                            this.imageName = response.data.endangeredSpecies.imageLink;
                        });
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .post {
        max-width: 1450px;
        margin: 0 auto 30px;

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
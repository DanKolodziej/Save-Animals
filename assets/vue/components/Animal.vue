<template>
    <div class="animal">
        <img class="animal__image"
             :src="require(`../../../public/uploads/images/${imageName}`)"
        >
        <div class="animal__text">
            <h2 class="animal__name">
                {{ name }}
            </h2>
            <p class="animal__description">
                {{ description }}
            </p>
            <p class="animal__contact">
                Kontakt: {{ contact }}
            </p>
            <RouterLink class="animal__owner-link"
                         :to="{name: 'userAnimals', params: {id: ownerId}}"
            >
                Inne zwierzaki tego samego właściciela
                <font-awesome-icon class="animal__arrow-icon"
                                   icon="long-arrow-alt-right"
                />
            </RouterLink>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Animal",
        props: {
            id: {
                required: true
            }
        },
        data() {
            return {
                name: '',
                description: '',
                imageFileName: '',
                ownerId: '',
                contact: ''
            }
        },
        computed: {
            imageName: function() {
                if(this.imageFileName.length === 0) {
                    return 'placeholder.png'
                }
                return this.imageFileName;
            }
        },
        created() {
            this.getAnimal();
        },
        methods: {
            getAnimal: function() {
                axios.get('/animal/' + this.id)
                    .then(response => {
                        this.name = response.data['animal'].name;
                        this.description = response.data['animal'].description;
                        this.imageFileName = response.data['animal'].imageFileName;
                        this.ownerId = response.data['animal'].owner.id;
                        this.contact = response.data['animal'].contact;
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .animal {
        margin-bottom: 30px;

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
            width: 80%;
            max-width: 450px;
            margin: 0 auto;
        }

        &__description {
            margin-top: 0;
        }

        &__owner-link {
            width: fit-content;
            width: -moz-fit-content;
            margin-left: auto;
            color: #0057E8;
            text-decoration: none;
            font-weight: bold;

            &:active, &:visited {
                color: #0057E8;
            }
        }

        &__arrow-icon {
            position: relative;
            top: 2px;
            visibility: hidden;
            opacity: 0;
            transition: all .5s ease-in-out;
        }

        &__owner-link:hover &__arrow-icon {
            visibility: visible;
            opacity: 1;
        }
    }
</style>
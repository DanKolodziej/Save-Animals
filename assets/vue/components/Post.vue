<template>
    <div class="post">
        <img class="post__image"
             :src="imageName"
        >
        <div class="post__text">
            <h2 class="post__name">
                {{ title }}
            </h2>
            <p class="post__description">
                {{ description }}
            </p>
            <p>
                Kategoria zagrożenia: {{ endangeredSpeciesType }}
            </p>
            <router-link :to="{name: 'endangeredSpecies', params: {name: encodedName}}"
                         class="post__link"
            >
                Czytaj więcej
                <font-awesome-icon class="post__arrow-icon"
                               icon="long-arrow-alt-right"
                />
            </router-link>
        </div>
        <div class="post__divider"></div>
    </div>
</template>

<script>
    export default {
        name: "Post",
        props: {
            title: {
                type: String,
                required: true
            },
            description: {
                type: String,
                required: true
            },
            endangeredSpeciesType: {
                type: String,
                required: true
            },
            imageFileName: {
                type: String,
                required: true
            },
        },
        computed: {
            encodedName: function() {
                return encodeURI(this.title);
            },
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
    .post {
        max-width: 450px;
        margin: 0 auto 30px;

        @media (min-width: 1024px) {
            margin-bottom: 30px;
        }

        &__image {
            display: block;
            width: 80%;
            margin: 0 auto;

            @media (min-width: 1024px) {
                margin: 0;
            }
        }

        &__text {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 0 10%;

            @media (min-width: 1024px) {
                padding: 0;
            }
        }

        &__description {
            margin-top: 0;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
            overflow: hidden;
        }

        &__link {
            width: fit-content;
            width: -moz-fit-content;
            margin-left: auto;
            color: #0057E8;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
            align-self: flex-end;

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

        &__link:hover &__arrow-icon {
            visibility: visible;
            opacity: 1;
        }

        &__divider {
            border-bottom: 2px solid #0057E8;
            width: 90%;
            margin: 15px auto 30px;

            @media (min-width: 1024px) {
                width: 100%;
            }
        }
    }
</style>
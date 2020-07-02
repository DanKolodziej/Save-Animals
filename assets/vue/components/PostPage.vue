<template>
    <div class="post">
        <img class="post__image"
             :src="imageName">
        <div class="post__text">
            <h2 class="post__name">{{ name }}</h2>
            <p class="post__description">
                {{ description }}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "PostPage",
        props: {
            name: {
                type: String,
                required: true
            },
            description: {
                type: String,
                required: true
            },
            imageName: {
                type: String,
                required: true
            },
        }
    }
</script>

<style lang="scss" scoped>
    .post {
        max-width: 450px;
        margin: 0 auto 30px;
        color: #192BC2;

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
        }
    }
</style>
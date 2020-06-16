<template>
    <div class="animal-card">
        <img class="animal-card__image"
             src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTmAlZoXH7c35THjrLVaIsu5FcgpWVdpPprOl6xaXhvMviVVmwI&usqp=CAU">
        <div class="animal-card__text">
            <h2 class="animal-card__name">Title</h2>
            <p class="animal-card__description">
                This is a placeholder This is a placeholder This is a placeholder
                This is a placeholder
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
                required: false
            },
            description: {
                type: String,
                required: false
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
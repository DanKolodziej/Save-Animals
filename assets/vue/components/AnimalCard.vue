<template>
    <div class="animal-card">
        <img class="animal-card__image"
             src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTmAlZoXH7c35THjrLVaIsu5FcgpWVdpPprOl6xaXhvMviVVmwI&usqp=CAU">
        <div class="animal-card__text">
            <h2 class="animal-card__name">Title</h2>
            <p class="animal-card__description">
                This is a placeholder This is a placeholder This is a placeholder
                This is a placeholder This is a placeholder This is a placeholder
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AnimalCard",
    }
</script>

<style lang="scss" scoped>
    .animal-card {
        max-width: 250px;
        border: 2px solid #192BC2;
        box-shadow: 10px 0 50px -10px rgba(0,0,0,0.75);
        margin-right: 30px;
        margin-bottom: 30px;
        &__image {
            width: 100%;
            object-fit: cover;
        }
        &__text {
            padding: 0 15px;
        }
    }
</style>
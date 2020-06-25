<template>
    <div class="post">
        <img class="animal-card__image"
             :src="require(`../../../public/uploads/images/${imageName}`)">
        <div class="animal-card__text">
            <h2 class="animal-card__name">{{ title }}</h2>
            <p class="animal-card__description">
                {{ description }}
            </p>
            <a href="#">Czytaj więcej</a>
        </div>
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
            imageFileName: {
                type: String,
                required: true
            },
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

</style>
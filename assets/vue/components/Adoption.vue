<template>
    <div>
        <h1 class="adoption-title">Adopcja Zwierzaków</h1>
        <div class="adoption-content">
            <div class="animal-cards-container">
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
            </div>
            <div class="adoption-options">
                options
            </div>
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";

    export default {
        name: "Adoption",
        components: {AnimalCard},
        comments: {
            AnimalCard
        }
    }
</script>

<style lang="scss" scoped>
    .adoption-title {
        text-align: center;
        text-transform: uppercase;
    }

    .adoption-content {
        /*width: calc(100% - 50px);*/
        /*margin: 0 auto;*/
        display: flex;
        justify-content: center;
        .animal-cards-container {
            /*margin: 0 auto;*/
            /*width: calc(100% - 50px);*/
            max-width: 1200px;
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        .adoption-options {
            background-color: #00D764;
            border: 2px solid #192BC2;
            border-radius: 5px;
            color: #fff;
        }
    }
</style>
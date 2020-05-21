<template>
    <div class="adoption-page">
        <h1 class="page-title">Adopcja Zwierzaków</h1>
        <div class="adoption-content">
            <div class="animal-cards-container">
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
                <animal-card></animal-card>
            </div>
            <div class="filter-options">
                options
            </div>
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";

    export default {
        name: "Adoption",
        components: {AnimalCard}
    }
</script>

<style lang="scss" scoped>
    .adoption-page {
        padding-top: 30px;

        .page-title {
            text-align: center;
            text-transform: uppercase;
            margin: 0 0 30px;
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

            .filter-options {
                background-color: #00BB00;
                border: 2px solid #192BC2;
                border-radius: 5px;
                color: #fff;
            }
        }
    }
</style>
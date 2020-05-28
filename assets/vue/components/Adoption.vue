<template>
    <div class="adoption-page">
        <h1 class="page-title">Adopcja Zwierzaków</h1>
        <div class="adoption-page__radio-group">
            <label for="adoption-waiting">Zwierzaki do adopcji</label>
            <input type="radio" id="adoption-waiting" name="adoption" value="waiting">
            <label for="adoption-wanted">Zwierzaki poszukiwane do adopcji</label>
            <input type="radio" id="adoption-wanted" name="adoption" value="wanted">
        </div>
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
        components: {AnimalCard},
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

        &__radio-group {
            width: 445px;
            margin: 0 auto;
        }

        .adoption-content {
            display: flex;
            justify-content: center;
            .animal-cards-container {
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
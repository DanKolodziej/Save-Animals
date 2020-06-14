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
            <FilterOptions></FilterOptions>
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";
    import FilterOptions from "./FilterOptions";

    export default {
        name: "Animals",
        components: {
            AnimalCard,
            FilterOptions
        },
        props: {
            category: {
                type: String,
                required: true
            }
        }
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
            flex-direction: column-reverse;

            @media (min-width: 1024px) {
                flex-direction: row;
            }

            .animal-cards-container {
                max-width: 1000px;
                display: flex;
                justify-content: flex-start;
                flex-wrap: wrap;

                @media (min-width: 768px) {
                    width: 702px;
                    margin: 0 auto;
                }

                @media (min-width: 1024px) {
                    margin: unset;
                    width: 55%;
                    max-width: 951px;
                    min-width: 717px;
                }
            }
        }
    }
</style>
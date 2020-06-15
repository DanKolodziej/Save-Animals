<template>
    <div class="adoption-page">
        <h1 class="page-title">Adopcja Zwierzaków</h1>
        <div class="adoption-page__radio-group">
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button" type="radio" id="adoption" name="adoption-category" value="adoption">
                <label class="adoption-page__label" for="adoption">Zwierzaki do adopcji</label>
            </div>
            <div class="adoption-page__radio-button-container">
                <input class="adoption-page__radio-button" type="radio" id="wanted" name="adoption-category" value="wanted">
                <label class="adoption-page__label" for="wanted">Zwierzaki poszukiwane do adopcji</label>
            </div>
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
            width: fit-content;
            background-color: #6495ed;
            margin: 0 auto 30px;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);
        }

        &__label {
            cursor: pointer;
        }

        &__radio-button-container {
            margin: 3px 0;
        }

        &__radio-button {

            &:checked, &:not(:checked) {
                position: absolute;
                left: -9999px;
            }

            &:checked + label, &:not(:checked) + label {
                position: relative;
                padding-left: 28px;
                cursor: pointer;
                line-height: 20px;
                display: inline-block;
            }

            &:checked + label:before, &:not(:checked) + label:before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                width: 18px;
                height: 18px;
                border: 1px solid #ddd;
                border-radius: 100%;
                background: #fff;
            }

            &:checked + label:after, &:not(:checked) + label:after {
                content: '';
                width: 12px;
                height: 12px;
                background: #00A8E8;
                position: absolute;
                top: 4px;
                left: 4px;
                border-radius: 100%;
                -webkit-transition: all 0.2s ease;
                transition: all 0.2s ease;
            }

            &:not(:checked) + label:after {
                opacity: 0;
                -webkit-transform: scale(0);
                transform: scale(0);
            }

            &:checked + label:after {
                opacity: 1;
                -webkit-transform: scale(1);
                transform: scale(1);
            }
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
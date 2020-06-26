<template>
    <div class="endangered-species-page">
        <h1 class="page-title">Zagrożone gatunki zwierząt w Polsce</h1>
        <div class="endangered-species-content">
            <div class="posts-container">
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                    </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
            </div>
            <div class="endangered-species-content__radio-group">
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="radio" id="adoption"
                        name="endangered-species-type"
                        value="extinct"
                        v-model="selectedEndangeredSpeciesType"
                        @change="FilterPosts">
                    <label class="endangered-species-content__label" for="adoption">
                        Gatunki wymarłe
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="radio"
                        id="to-disappear"
                        name="endangered-species-type"
                        value="toDisappear"
                        v-model="selectedEndangeredSpeciesType"
                        @change="FilterPosts">
                    <label class="endangered-species-content__label" for="to-disappear">
                        Gatunki zanikłe
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="radio"
                        id="extremely-endangered"
                        name="endangered-species-type"
                        value="extremelyEndangered"
                        v-model="selectedEndangeredSpeciesType"
                        @change="FilterPosts">
                    <label class="endangered-species-content__label" for="extremely-endangered">
                        Gatunki skrajnie zagrożone
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="radio"
                        id="highly-endangered"
                        name="endangered-species-type"
                        value="highlyEndangered"
                        v-model="selectedEndangeredSpeciesType"
                        @change="FilterPosts">
                    <label class="endangered-species-content__label" for="highly-endangered">
                        Gatunki silnie zagrożone
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="radio"
                        id="at-endanger-risk"
                        name="endangered-species-type"
                        value="atEndangerRisk"
                        v-model="selectedEndangeredSpeciesType"
                        @change="FilterPosts">
                    <label class="endangered-species-content__label" for="at-endanger-risk">
                        Gatunki narażone na wyginięcie
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="radio"
                        id="close-to-danger"
                        name="endangered-species-type"
                        value="closeToDanger"
                        v-model="selectedEndangeredSpeciesType"
                        @change="FilterPosts">
                    <label class="endangered-species-content__label" for="close-to-danger">
                        Gatunki bliskie zagrożenia
                    </label>
                </div>
                <div class="endangered-species-content_radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="radio"
                        id="not-endangered"
                        name="endangered-species-type"
                        value="notEndangered"
                        v-model="selectedEndangeredSpeciesType"
                        @change="FilterPosts">
                    <label class="endangered-species-content__label" for="not-endangered">
                        Gatunki narazie nie zagrożone wymarciem
                    </label>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Post from './Post';

    export default {
        name: "EndangeredSpecies",
        components: {
            Post,
            selectedEndangeredSpeciesType: ''
        },
        methods: {
            filterPosts: function() {

            }
        }
    }
</script>

<style lang="scss" scoped>

    .endangered-species-page {
        padding-top: 30px;
        
        .page-title {
            text-align: center;
            text-transform: uppercase;
            margin: 0 0 30px;
        }

        .endangered-species-content {
            display: flex;
            justify-content: space-between;
            flex-direction: column-reverse;
            max-width: 1200px;
            margin: 0 auto;

            @media (min-width: 1024px) {
                flex-direction: row;
            }

            .endangered-species-content__radio-group {
                height: fit-content;
                background-color: #6495ed;
                margin: 0 auto 30px;
                padding: 15px;
                border-radius: 5px;
                color: #fff;
                width: 300px;
                box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);

                @media (min-width: 1024px) {
                    margin: 0 0 30px;
                }
            }

            &__radio-group {
                width: fit-content;
                width: -moz-fit-content;
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
        }
    }
</style>
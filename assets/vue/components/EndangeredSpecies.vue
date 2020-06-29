<template>
    <div class="endangered-species-page">
        <h1 class="page-title">Zagrożone gatunki zwierząt w Polsce</h1>
        <div class="endangered-species-content">
            <div class="posts-container">
                <post :title="'Title'"
                    :description="'This is a placeholder This is a placeholder This is a placeholder This is a placeholder This is a placeholder This is a placeholder This is a placeholder This is a placeholder This is a placeholder'"
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
                        type="checkbox"
                        id="extinct"
                        name="extinct"
                        value="extinct"
                        v-model="extinct"
                        @change="filterPosts">
                    <label class="endangered-species-content__label" for="extinct">
                        Gatunki wymarłe
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="checkbox"
                        id="to-disappear"
                        name="to-disappear"
                        value="toDisappear"
                        v-model="toDisappear"
                        @change="filterPosts">
                    <label class="endangered-species-content__label" for="to-disappear">
                        Gatunki zanikłe
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="checkbox"
                        id="extremely-endangered"
                        name="extremely-endangered"
                        value="extremelyEndangered"
                        v-model="extremelyEndangered"
                        @change="filterPosts">
                    <label class="endangered-species-content__label" for="extremely-endangered">
                        Gatunki skrajnie zagrożone
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="checkbox"
                        id="highly-endangered"
                        name="highly-endangered"
                        value="highlyEndangered"
                        v-model="highlyEndangered"
                        @change="filterPosts">
                    <label class="endangered-species-content__label" for="highly-endangered">
                        Gatunki silnie zagrożone
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="checkbox"
                        id="at-endanger-risk"
                        name="at-endanger-risk"
                        value="atEndangerRisk"
                        v-model="atEndangerRisk"
                        @change="filterPosts">
                    <label class="endangered-species-content__label" for="at-endanger-risk">
                        Gatunki narażone na wyginięcie
                    </label>
                </div>
                <div class="endangered-species-content__radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="checkbox"
                        id="close-to-danger"
                        name="close-to-danger"
                        value="closeToDanger"
                        v-model="closeToDanger"
                        @change="filterPosts">
                    <label class="endangered-species-content__label" for="close-to-danger">
                        Gatunki bliskie zagrożenia
                    </label>
                </div>
                <div class="endangered-species-content_radio-button-container">
                    <input class="endangered-species-content__radio-button"
                        type="checkbox"
                        id="not-endangered"
                        name="not-endangered"
                        value="notEndangered"
                        v-model="notEndangered"
                        @change="filterPosts">
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
            Post
        },
        data() {
            return {
                extinct: '',
                toDisappear: '',
                extremelyEndangered: '',
                highlyEndangered: '',
                atEndangerRisk: '',
                closeToDanger: '',
                notEndangered: ''
            }
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
                    background: #fff;
                }

                &:checked + label:after, &:not(:checked) + label:after {
                    content: '';
                    width: 5px;
                    height: 10px;
                    position: absolute;
                    top: 3px;
                    left: 6px;
                    border: solid #00A8E8;
                    border-width: 0 3px 3px 0;
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
                    transform: rotate(45deg) scale(1);
                }
            }
        }
    }
</style>
<template>
    <div class="endangered-species-page">
        <h1 class="page-title">Zagrożone gatunki zwierząt w Polsce</h1>
        <div class="endangered-species-content">
            <div class="posts-container" ref="posts-container">
                <clip-loader class="endangered-species-content__loader" :loading="isLoadingEndangeredSpecies" :color="'#192BC2'" :size="'45px'"></clip-loader>
                <div v-show="isLoadingEndangeredSpecies" class="endangered-species-content__loading-message">
                    <span class="loading-text">Czekaj chwilę</span><span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>
                </div>
                <post v-if="showExtinct" v-for="endangeredSpecies in extinct"
                    :title="endangeredSpecies.name"
                    :description="endangeredSpecies.description"
                    :endangered-species-type="endangeredSpecies.endangeredSpeciesType"
                    :image-file-name="endangeredSpecies.imageLink">
                </post>
                <post v-if="showToDisappear" v-for="endangeredSpecies in toDisappear"
                    :title="endangeredSpecies.name"
                    :description="endangeredSpecies.description"
                    :endangered-species-type="endangeredSpecies.endangeredSpeciesType"
                    :image-file-name="endangeredSpecies.imageLink">
                </post>
                <post v-if="showExtremelyEndangered" v-for="endangeredSpecies in extremelyEndangered"
                    :title="endangeredSpecies.name"
                    :description="endangeredSpecies.description"
                    :endangered-species-type="endangeredSpecies.endangeredSpeciesType"
                    :image-file-name="endangeredSpecies.imageLink">
                </post>
                <post v-if="showHighlyEndangered" v-for="endangeredSpecies in highlyEndangered"
                    :title="endangeredSpecies.name"
                    :description="endangeredSpecies.description"
                    :endangered-species-type="endangeredSpecies.endangeredSpeciesType"
                    :image-file-name="endangeredSpecies.imageLink">
                </post>
                <post v-if="showAtEndangerRisk" v-for="endangeredSpecies in atEndangerRisk"
                    :title="endangeredSpecies.name"
                    :description="endangeredSpecies.description"
                    :endangered-species-type="endangeredSpecies.endangeredSpeciesType"
                    :image-file-name="endangeredSpecies.imageLink">
                </post>
                <post v-if="showCloseToDanger" v-for="endangeredSpecies in closeToDanger"
                    :title="endangeredSpecies.name"
                    :description="endangeredSpecies.description"
                    :endangered-species-type="endangeredSpecies.endangeredSpeciesType"
                    :image-file-name="endangeredSpecies.imageLink">
                </post>
                <post v-if="showNotEndangered" v-for="endangeredSpecies in notEndangered"
                    :title="endangeredSpecies.name"
                    :description="endangeredSpecies.description"
                    :endangered-species-type="endangeredSpecies.endangeredSpeciesType"
                    :image-file-name="endangeredSpecies.imageLink">
                </post>
            </div>
            <div class="endangered-species-content__checkbox-group">
                <div class="endangered-species-content__checkbox-container">
                    <input class="endangered-species-content__checkbox"
                        type="checkbox"
                        id="extinct"
                        name="extinct"
                        value="extinct"
                        v-model="showExtinct"
                        @change="resetCurrentPage()">
                    <label class="endangered-species-content__label" for="extinct">
                        Gatunki wymarłe
                    </label>
                </div>
                <div class="endangered-species-content__checkbox-container">
                    <input class="endangered-species-content__checkbox"
                        type="checkbox"
                        id="to-disappear"
                        name="to-disappear"
                        value="toDisappear"
                        v-model="showToDisappear"
                        @change="resetCurrentPage()">
                    <label class="endangered-species-content__label" for="to-disappear">
                        Gatunki zanikłe
                    </label>
                </div>
                <div class="endangered-species-content__checkbox-container">
                    <input class="endangered-species-content__checkbox"
                        type="checkbox"
                        id="extremely-endangered"
                        name="extremely-endangered"
                        value="extremelyEndangered"
                        v-model="showExtremelyEndangered"
                        @change="resetCurrentPage()">
                    <label class="endangered-species-content__label" for="extremely-endangered">
                        Gatunki skrajnie zagrożone
                    </label>
                </div>
                <div class="endangered-species-content__checkbox-container">
                    <input class="endangered-species-content__checkbox"
                        type="checkbox"
                        id="highly-endangered"
                        name="highly-endangered"
                        value="highlyEndangered"
                        v-model="showHighlyEndangered"
                        @change="resetCurrentPage()">
                    <label class="endangered-species-content__label" for="highly-endangered">
                        Gatunki silnie zagrożone
                    </label>
                </div>
                <div class="endangered-species-content__checkbox-container">
                    <input class="endangered-species-content__checkbox"
                        type="checkbox"
                        id="at-endanger-risk"
                        name="at-endanger-risk"
                        value="atEndangerRisk"
                        v-model="showAtEndangerRisk"
                        @change="resetCurrentPage()">
                    <label class="endangered-species-content__label" for="at-endanger-risk">
                        Gatunki narażone na wyginięcie
                    </label>
                </div>
                <div class="endangered-species-content__checkbox-container">
                    <input class="endangered-species-content__checkbox"
                        type="checkbox"
                        id="close-to-danger"
                        name="close-to-danger"
                        value="closeToDanger"
                        v-model="showCloseToDanger"
                        @change="resetCurrentPage()">
                    <label class="endangered-species-content__label" for="close-to-danger">
                        Gatunki bliskie zagrożenia
                    </label>
                </div>
                <div class="endangered-species-content_checkbox-container">
                    <input class="endangered-species-content__checkbox"
                        type="checkbox"
                        id="not-endangered"
                        name="not-endangered"
                        value="notEndangered"
                        v-model="showNotEndangered"
                        @change="resetCurrentPage()">
                    <label class="endangered-species-content__label" for="not-endangered">
                        Gatunki narazie nie zagrożone wymarciem
                    </label>
                </div>
            </div>
        </div>
        <div class="pagination" v-show="!loadingEndangeredSpecies && pageAmount > 0">
            <font-awesome-icon class="pagination__arrow"
                                   icon="chevron-left"
                                   :class="{'pagination__arrow--hidden': currentPage === 1}"
                                   @click="previousPage"/>
            {{currentPage}}/{{ pageAmount }}
            <font-awesome-icon class="pagination__arrow"
                                   icon="chevron-right"
                                   :class="{'pagination__arrow--hidden': currentPage === pageAmount}"
                                   @click="nextPage"/>
        </div>
    </div>
</template>

<script>
    import Post from './Post';
    import ClipLoader from 'vue-spinner/src/ClipLoader';

    export default {
        name: "EndangeredSpecies",
        components: {
            Post,
            ClipLoader
        },
        data() {
            return {
                showExtinct: false,
                showToDisappear: false,
                showExtremelyEndangered: false,
                showHighlyEndangered: false,
                showAtEndangerRisk: false,
                showCloseToDanger: false,
                showNotEndangered: false,
                loadingEndangeredSpecies: false,
                currentPage: 1
            }
        },
        computed: {
            isLoadingEndangeredSpecies: function() {
                return this.$store.getters.isLoadingEndangeredSpecies;
            },
            extinct: function() {
                return this.$store.getters.extinct;
            },
            toDisappear: function() {
                return this.$store.getters.toDisappear;
            },
            extremelyEndangered: function() {
                return this.$store.getters.extremelyEndangered;
            },
            highlyEndangered: function() {
                return this.$store.getters.highlyEndangered;
            },
            atEndangerRisk: function() {
                return this.$store.getters.atEndangerRisk;
            },
            closeToDanger: function() {
                return this.$store.getters.closeToDanger;
            },
            notEndangered: function() {
                return this.$store.getters.notEndangered;
            },
            postsAmount: function() {
                var postsAmount = 0;
                postsAmount += this.showExtinct ? this.extinct.length : 0;
                postsAmount += this.showToDisappear ? this.toDisappear.length : 0;
                postsAmount += this.showExtremelyEndangered ? this.extremelyEndangered.length : 0;
                postsAmount += this.showHighlyEndangered ? this.highlyEndangered.length : 0;
                postsAmount += this.showAtEndangerRisk ? this.atEndangerRisk.length : 0;
                postsAmount += this.showCloseToDanger ? this.closeToDanger.length : 0;
                postsAmount += this.showNotEndangered ? this.notEndangered.length : 0;

                return postsAmount;
            },
            pageAmount: function() {
                return Math.ceil(this.postsAmount / 10);
            }
        },
        watch: {
            isLoadingEndangeredSpecies: function(newIsLoadingEndangeredSpecies, oldIsLoadingEndangeredSpecies) {
                if(!newIsLoadingEndangeredSpecies && oldIsLoadingEndangeredSpecies) {
                    this.showExtinct = this.extinct.length > 0;
                    this.showToDisappear = this.toDisappear.length > 0;
                    this.showExtremelyEndangered = this.extremelyEndangered.length > 0;
                    this.showHighlyEndangered = this.highlyEndangered.length > 0;
                    this.showAtEndangerRisk = this.atEndangerRisk.length > 0;
                    this.showCloseToDanger = this.closeToDanger.length > 0;
                    this.showNotEndangered = this.notEndangered.length > 0;
                }
            }
        },
        methods: {
            resetCurrentPage: function() {
                this.currentPage = 1;
            },
            currentPageEndangeredSpecies: function(index) {
                return ((this.currentPage - 1) * 10) < index - 1 && index - 1 <= (this.currentPage * 10);
            },
            previousPage: function() {
                this.currentPage--;
            },
            nextPage: function() {
                this.currentPage++;
            }
        },
        mounted() {
            this.showExtinct = this.extinct.length > 0;
            this.showToDisappear = this.toDisappear.length > 0;
            this.showExtremelyEndangered = this.extremelyEndangered.length > 0;
            this.showHighlyEndangered = this.highlyEndangered.length > 0;
            this.showAtEndangerRisk = this.atEndangerRisk.length > 0;
            this.showCloseToDanger = this.closeToDanger.length > 0;
            this.showNotEndangered = this.notEndangered.length > 0;
        },
        updated() {
            var postsContainerChildElements = this.$refs['posts-container'].children;
            for(var i = 2; i < postsContainerChildElements.length; i++) {
                if (!this.currentPageEndangeredSpecies(i)) {
                    postsContainerChildElements[i].style.display = 'none';
                } else {
                    postsContainerChildElements[i].style.display = 'block';
                }
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
                padding: 0 15px
            }

            &__loading-message {
                text-align: center;
                color: #192BC2;
                font-size: 22px;
                font-weight: bold;
                margin-bottom: 30px;

                .loading-text {
                    margin-left: 24px;
                }

                .dot {
                    letter-spacing: 1.6px;
                    animation-name: blink;
                    animation-duration: 1.4s;
                    animation-iteration-count: infinite;
                    animation-fill-mode: both;
                    animation-delay: .2s;
                    
                    &:first-child {
                        animation-delay: 0;
                    }

                    &:last-child {
                        animation-delay: .4s;
                    }
                }

                @keyframes blink {
                    0%   {opacity: 0;}
                    20%   {opacity: 1;}
                    100% {opacity: 0;}
                }
            }

            &__checkbox-group {
                height: fit-content;
                background-color: #6495ed;
                margin: 0 auto 30px;
                padding: 15px;
                border-radius: 5px;
                color: #fff;
                width: 300px;
                box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);

                @media (min-width: 1024px) {
                    margin: 0;
                    position: sticky;
                    top: 30px;
                }
            }

            &__label {
                cursor: pointer;
            }

            &__checkbox-container {
                margin: 3px 0;
            }

            &__checkbox {

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

        .posts-container {
            @media (min-width: 1024px) {
                width: calc(100% - 330px);
            }
        }

        .pagination {
            display: flex;
            justify-content: space-between;
            width: 250px;
            margin: 30px auto;
            font-size: 55px;
            color: #192BC2;

            &__arrow {
                background-color: #192BC2;
                color: #fff;
                border-radius: 5px;
                padding: 5px;
                width: 55px;
                cursor: pointer;

                &--hidden {
                    visibility: hidden;
                }
            }
        }
    }
</style>
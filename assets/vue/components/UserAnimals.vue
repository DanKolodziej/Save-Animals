<template>
    <div class="user-animals-page">
        <div class="user-info">
            <h2>Email</h2>
            <h2>Name</h2>
            <h3>User Type</h3>
        </div>
        <div class="animal-tabs">
            <div class="animal-tabs__titles">
                <div class="animal-tabs__tab-title animal-tabs__tab-title--active">
                    Zwierzak/i do adopcji
                    <div class="animal-tabs__title-underline adoption-underline"></div>
                </div>
                <div class="animal-tabs__tab-title">
                    Zwierzak/i, które chciałbym przygarnąć
                    <div class="animal-tabs__title-underline wanted-underline"></div>
                </div>
                <div class="animal-tabs__tab-title">
                    Zwierzak/i, które mi zaginęły
                    <div class="animal-tabs__title-underline lost-underline"></div>
                </div>
                <div class="animal-tabs__tab-title">
                    Zwierzak/i, które znalazłem
                    <div class="animal-tabs__title-underline found-underline"></div>
                </div>
            </div>
            <div class="animal-tabs__content animal-tabs__adoption">
                <animal-card></animal-card>
            </div>
<!--            <div class="animal-tabs__content animal-tabs__wanted">-->

<!--            </div>-->
<!--            <div class="animal-tabs__content animal-tabs__lost">-->

<!--            </div>-->
<!--            <div class="animal-tabs__content animal-tabs__found">-->

<!--            </div>-->
        </div>
    </div>
</template>

<script>
    import AnimalCard from "./AnimalCard";

    export default {
        name: "UserAnimals",
        components: {
            AnimalCard
        }
    }
</script>

<style lang="scss" scoped>
    .user-animals-page {
        display: flex;
        justify-content: space-between;
        max-width: 1000px;
        padding: 30px 5% 0 5%;
        margin: 0 auto;

        .animal-tabs {
            max-width: 650px;

            &__titles {
                display: flex;
                border-radius: 5px 5px 0 0;
            }

            &__tab-title {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                text-align: center;
                border-radius: 5px 5px 0 0;
                border-bottom: 1px solid #e0e0e0;
                padding: 5px 15px;
                cursor: pointer;

                &:hover {
                    background-color: #e0e0e0;
                }

                &--active {
                    background-color: #fff;
                    border: 1px solid #e0e0e0;
                    border-bottom: none;
                }
            }

            &__title-underline {
                height: 5px;
                width: 70px;
                margin: 5px auto 0;
            }

            .adoption-underline {
                background-color: #008c4b;
            }

            .wanted-underline {
                background-color: #00bb00;
            }

            .lost-underline {
                background-color: #192bc2;
            }

            .found-underline {
                background-color: #00a8e8;
            }

            &__content {
                background-color: #fff;
                padding-top: 15px;
                border: 1px solid #e0e0e0;
                border-top: 0;
            }
        }
    }

</style>
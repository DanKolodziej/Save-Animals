<template>
    <div class="index">
        <h1 class="page-title">
            Strona Główna
        </h1>
        <img class="index__icon"
             :src="require('../../images/icons8-dog-64.png')"
        >
        Strona internetowa pomoc-zwierzakom.pl powstała w celu pomagania ludziom w adopcji, odnalezieniu zaginionych zwierzaków oraz informowaniu o zagrożonych gatunkach w Polsce.
        Głównym celem jest stworzenie miejsca gdzie zgromadzone będą dane o jak największej liczbie różnych zwierzaków, które:
        <ul>
            <li>
                różne osoby (zarówno osoby fizyczne jak i schroniska itp.) chciałyby oddać do adopcji
            </li>
            <li>
                różne osoby poszukują do adopcji
            </li>
            <li>
                zaginęły
            </li>
            <li>
                zostały znalezione i szukają swojego właściciela.
            </li>
        </ul>
        <img class="index__icon"
             :src="require('../../images/icons8-cat-64.png')"
        >
        Dodatkowym celem jest udostępnianie informacji o zagrożonych gatunkach w Polsce poprzez udostępnienie danych na ich temat na podstawie wikipedii.
        Strona ta została stworzona jako osobisty projekt, który przy okazji będzie pożyteczny.
        Wszelkie uwagi, problemy, porady, pytania itp. można wysyłać na email: pomoc.zwierzakom.kontakt@gmail.com
        <img class="index__icon"
             :src="require('../../images/icons8-mouse-animal-64.png')"
        >
    </div>
</template>

<script>
    export default {
        name: "Index"
    }
</script>

<style lang="scss" scoped>
    .index {
        padding: 30px 5%;

        .page-title {
            font-weight: normal;
            font-size: 38px;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        &__icon {
            display: block;
            margin: 30px auto;
        }
    }
</style>
<template>
    <div class="administration">
        <button class="administration__button" @click="getEndangeredSpecies">
            Zagrożone gatunki zwierząt z wikipedii
        </button>
        <table class="endangered-species-table">
            <tr class="endangered-species-table__row">
                <th>Name</th>
                <th>Description</th>
                <th>Type</th>
                <th>Image link</th>
            </tr>
            <tr v-for="endangeredSpeciesSingular in endangeredSpecies" class="endangered-species-table__row">
                <td class="endangered-species-table__cell">{{ endangeredSpeciesSingular.name }}</td>
                <td class="endangered-species-table__cell">{{ endangeredSpeciesSingular.description }}</td>
                <td class="endangered-species-table__cell">{{endangeredSpeciesSingular.endangeredSpeciesType}}</td>
                <td class="endangered-species-table__cell">{{endangeredSpeciesSingular.imageLink}}</td>
            </tr>
        </table>
        <button class="administration__button" @click="updateEndangeredSpecies">
            Zaktualizuj zagrożone gatunki zwierząt
        </button>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Administration",
        data() {
            return {
                endangeredSpecies: []
            }
        },
        methods: {
            getEndangeredSpecies: function() {
                axios.get('/endangered-species-data')
                    .then(response => {
                        this.endangeredSpecies = this.endangeredSpecies.concat(response.data['EX']);
                        this.endangeredSpecies = this.endangeredSpecies.concat(response.data['EXP']);
                        this.endangeredSpecies = this.endangeredSpecies.concat(response.data['CR']);
                        this.endangeredSpecies = this.endangeredSpecies.concat(response.data['EN']);
                        this.endangeredSpecies = this.endangeredSpecies.concat(response.data['VU']);
                        this.endangeredSpecies = this.endangeredSpecies.concat(response.data['NT']);
                        this.endangeredSpecies = this.endangeredSpecies.concat(response.data['LC']);
                });
            },
            updateEndangeredSpecies: function() {
                console.log(this.endangeredSpecies);
                axios.post('/update-endangered-species', {
                    endangeredSpecies: this.endangeredSpecies
                });
            }
        }
    }
</script>

<style lang="scss" scoped>

    .administration {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        padding-top: 30px;

        &__button {
            width: 300px;
            background-color: #192BC2;
            color: #fff;
            padding: 5px;
            font-size: 30px;
            border: 1px solid transparent;
            border-radius: 5px;
            box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);
            cursor: pointer;

            &:focus {
                outline: none;
                box-shadow: 0 0 50px -10px #00dce8;
            }
        }

        .endangered-species-table {
            table-layout: fixed;
            width: calc(100% - 30px);
            margin: 30px auto;
            border: 1px solid;
            border-radius: 5px;

            &__row {
                &:nth-child(odd) {
                    background-color: #e0e0e0;
                }
            }

            &__cell {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                text-align: center;
            }
        }
    }

</style>
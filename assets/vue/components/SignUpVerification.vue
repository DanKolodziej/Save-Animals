<template>
    <div class="sign-up-verification">
        <div v-if="verified" class="sign-up-verification__success-message">
            Rejestracja przebiegła pomyślnie!
        </div>
        <div v-else-if="verified === false" class="sign-up-verification__error-message">
            Nieprawidłowy link weryfikacji!
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "SignUpVerification",
        props: {
            token: {
                type: String
            }
        },
        data() {
            return {
                verified: null
            }
        },
        mounted() {
            axios.get('/verify-user/' + this.token)
                .then(response => {
                    this.verified = response.data.verified;
                })
        }
    }
</script>

<style lang="scss" scoped>
    .sign-up-verification {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px 0;

        &__success-message, &__error-message {
            width: 250px;
            background-color: #008c4b;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 20px;
            margin-top: 30px;
            border-radius: 5px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.75);
        }

        &__success-message {
            background-color: #008c4b;
        }

        &__error-message {
            background-color: #C82829;
        }
    }
</style>
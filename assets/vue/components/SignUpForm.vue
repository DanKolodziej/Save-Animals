<template>
    <form class="form" method="post">
        <h1 class="form__title">Rejestracja</h1>
        <p v-if="error" class="form__error">
            {{ errorMessage }}
        </p>
        <label class="form__label" for="email">
            Email:
            <input class="form__input" type="email" id="email" name="email" v-model="email">
        </label>
        <label class="form__label" for="password">
            Hasło:
            <input class="form__input" type="password" id="password" name="password" v-model="password">
        </label>
        <label class="form__label" for="repeat-password">
            Powtórz hasło:
            <input class="form__input" type="password" id="repeat-password" name="repeat-password" v-model="repeatPassword">
        </label>
        <label class="form__label" for="name">
            Imię (+ opcjonalnie nazwisko):
            <input class="form__input" type="text" id="name" name="name" v-model="name">
        </label>
        <label class="form__label" for="city">
            Miasto:
            <input class="form__input" type="text" id="city" name="city" v-model="city">
        </label>
        <label class="form__label" for="address">
            Adres:
            <input class="form__input" type="text" id="address" name="address" v-model="address">
        </label>
        <label class="form__label" for="postal-code">
            Kod pocztowy:
            <input class="form__input" type="text" id="postal-code" name="postal-code" v-model="postalCode">
        </label>
        <input class="form__submit" type="submit" value="Zatwierdź" @click.prevent="register">
    </form>
</template>

<script>
    export default {
        name: "SignUpForm",
        data () {
            return {
                email: '',
                password: '',
                repeatPassword: '',
                role: '',
                name: '',
                city: '',
                address: '',
                postalCode: '',
                errorMessage: ''
            }
        },
        methods: {
            register: function() {

            }
        }
    }
</script>

<style lang="scss" scoped>
    .form {
        width: 250px;
        margin: 0 auto;
        padding: 15px;
        background-color: #6495ed;
        border-radius: 5px;
        box-shadow: 0 0 20px 0 rgba(0,0,0,0.75);

        &__title {
            text-align: center;
            color: #fff;
            font-weight: normal;
            margin: 0 0 30px;
        }

        &__error {
            color: #C82829;
        }

        &__label, &__remember {
            color: #fff;
            font-weight: bold;
        }

        &__input {
            display: block;
            width: 100%;
            margin: 5px 0 10px;
            padding: 5px;
            font-size: 18px;
            border: 2px solid #00A8E8;
            border-radius: 3px;
            box-sizing: border-box;
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #00dce8;
            }
        }

        &__submit {
            width: 50%;
            padding: 7px 0;
            background-color: #00A8E8;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: 1px solid transparent;
            border-radius: 3px;
            cursor: pointer;
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #00dce8;
            }
        }
    }
</style>
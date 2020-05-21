<template>
    <form class="form">
        <h1 class="form__title">Zaloguj się</h1>
        <label class="form__label" for="email">
            Email:
            <input class="form__input" type="email" id="email" name="email">
        </label>

        <label class="form__label" for="password">
            Hasło:
            <input class="form__input" type="password" id="password" name="password">
        </label>
        <label class="form__remember" for="remember">
            Zapamiętaj mnie
            <input class="form__remember-input" type="checkbox" id="remember" name="remember">
            <span class="form__remember-checkbox"></span>
        </label>
        <input class="form__submit" type="submit" value="Zatwierdź">
    </form>
</template>

<script>
    export default {
        name: "SignInForm"
    }
</script>

<style lang="scss" scoped>
    .form {
        width: 250px;
        margin: 0 auto;
        padding: 15px;
        background-color: #e9ffff;
        border: 1px solid #192BC2;
        border-radius: 5px;
        box-shadow: 0 0 25px -10px rgba(0, 0, 0, 0.75);

        &__title {
            text-align: center;
            color: #192BC2;
            font-weight: normal;
            margin: 0 0 30px;
        }

        &__label, &__remember {
            color: #192BC2;
        }

        &__remember {
            display: inline-block;
            width: 48%;
            font-size: 13px;
            position: relative;
            margin-bottom: 12px;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

            &-input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }

            &-checkbox {
                position: absolute;
                top: 0;
                left: 100px;
                height: 15px;
                width: 15px;
                background-color: #fff;
                border: 1px solid #192BC2;
                border-radius: 3px;

                &:after {
                    content: "";
                    position: absolute;
                    display: none;
                    left: 4px;
                    width: 5px;
                    height: 10px;
                    border: solid #192BC2;
                    border-width: 0 3px 3px 0;
                    -webkit-transform: rotate(45deg);
                    -ms-transform: rotate(45deg);
                    transform: rotate(45deg);
                }
            }

            &-input:checked ~ &-checkbox:after {
                display: block;
            }
        }

        &__input {
            display: block;
            width: 100%;
            margin: 5px 0 10px;
            padding: 5px;
            font-size: 18px;
            border: 1px solid #192BC2;
            border-radius: 3px;
            box-sizing: border-box;
        }

        &__submit {
            width: 50%;
            padding: 7px 0;
            background-color: #192BC2;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: 1px solid #192BC2;
            border-radius: 3px;
            cursor: pointer;
        }
    }
</style>
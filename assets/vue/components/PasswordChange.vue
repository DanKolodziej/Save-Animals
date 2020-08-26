<template>
    <div class="password-reset">
        <h1 class="password-reset__title">
            Zmiana hasła
        </h1>
        <div v-if="!isPasswordChanged"
             class="password-reset__content"
        >
            <label class="password-reset__label"
                   for="password"
            >
                Nowe Hasło
                <input class="password-reset__input"
                       :class="{'password-reset__input--error': passwordError.length > 0}"
                       type="password"
                       id="password"
                       name="password"
                       v-model="password"
                       :placeholder="passwordError"
                       @click="passwordErrorDelete"
                >
            </label>
            <label class="password-reset__label"
                   for="password-repeat"
            >
                Powtórz nowe hasło
                <input class="password-reset__input"
                       :class="{'password-reset__input--error':repeatPasswordError.length > 0}"
                       type="password"
                       id="password-repeat"
                       name="password-repeat"
                       v-model="repeatPassword"
                       :placeholder="repeatPasswordError"
                       @click="repeatPasswordErrorDelete"
                >
            </label>
            <input class="password-reset__submit"
                   v-show="!isLoading"
                   type="submit"
                   value="Potwierdź"
                   @click.prevent="changePassword"
            >
            <ClipLoader
                    class="password-reset__loading"
                    :loading="isLoading"
                    :color="'#fff'"
                    :size="'45px'"
            />
        </div>
        <div v-if="isPasswordChanged"
             class="password-reset__success-message"
        >
            Pomyślnie zmieniono hasło!
        </div>
    </div>
</template>

<script>
    import ClipLoader from 'vue-spinner/src/ClipLoader';
    import axios from 'axios';

    export default {
        name: "PasswordChange",
        components: {
            ClipLoader
        },
        props: {
            token: {
                type: String
            }
        },
        data() {
            return {
                password: '',
                repeatPassword: '',
                passwordError: '',
                repeatPasswordError: '',
                isLoading: false,
                isPasswordChanged: false
            }
        },
        methods: {
            passwordErrorDelete: function() {
                this.passwordError = '';
            },
            repeatPasswordErrorDelete: function() {
                this.repeatPasswordError = '';
            },
            changePassword: function() {
                this.isLoading = true;
                var formData = new FormData();
                formData.append('password', this.password);
                formData.append('password-repeat', this.repeatPassword);
                formData.append('token', this.token);
                axios.post('/password-change', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(() => {
                    this.isLoading = false;
                    this.isPasswordChanged = true;
                }).catch(error => {
                    var errorMessages = error.response.data;
                    if(errorMessages.password) {
                        this.passwordError = errorMessages.password[0];
                        this.password = '';
                    }
                    if(errorMessages.repeatPassword) {
                        this.repeatPasswordError = errorMessages.repeatPassword[0];
                        this.repeatPassword = '';
                    }
                    this.isLoading = false;
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .password-reset {
        padding-top: 30px;

        &__title {
            font-weight: normal;
            font-size: 38px;
            text-align: center;
            text-transform: uppercase;
            margin: 0 0 30px;
        }

        &__content {
            max-width: 250px;
            background-color: #0057E8;
            margin: 0 auto 30px;
            padding: 15px;
            border-radius: 5px;
            color: #fff;
            box-shadow: 0 0 50px -10px rgba(0, 0, 0, 0.75);
        }

        &__paragraph {
            margin-top: 0;
        }

        &__label {
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

            &--error {
                border-color: #C82829;
                background-color: #eeaaaa;
                color: #C82829;

                &:focus {
                    box-shadow: 0 0 5px 0 #eeaaaa;
                }

                &::placeholder {
                    color: #C82829;
                }
            }
        }

        &__submit {
            display: block;
            margin: 0 auto;
            padding: 7px 14px;
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

        &__loading {
            margin-top: 15px;
        }

        &__success-message {
            width: 250px;
            background-color: #008c4b;
            color: #fff;
            text-align: center;
            font-weight: bold;
            padding: 20px;
            margin: 30px auto;
            border-radius: 5px;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.75);
        }
    }
</style>
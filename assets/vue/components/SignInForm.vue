<template>
    <form class="form" method="post">
        <h1 class="form__title">
            Zaloguj się
        </h1>
        <label class="form__label"
               for="email"
        >
            Email
            <input class="form__input"
                   :class="{'form__input--error': emailError.length > 0}"
                   type="email"
                   id="email"
                   name="email"
                   v-model="email"
                   :placeholder="emailError"
                   @click="emailErrorDelete"
            >
        </label>
        <label class="form__label"
               for="password"
        >
            Hasło
            <input class="form__input"
                   :class="{'form__input--error': credentialsError.length > 0}"
                   type="password"
                   id="password"
                   name="password"
                   v-model="password"
                   :placeholder="credentialsError"
                   @click="credentialsErrorDelete"
            >
        </label>
        <label class="form__remember"
               for="remember"
        >
            Zapamiętaj mnie
            <input class="form__remember-input"
                   type="checkbox"
                   id="remember"
                   name="remember"
            >
            <span class="form__remember-checkbox"></span>
        </label>
        <input class="form__submit"
               type="submit"
               value="Zatwierdź"
               @click.prevent="performLogin()"
        >
        <div class="form__links">
            <RouterLink class="form__link"
               to="/rejestracja"
            >
                Utwórz konto
            </RouterLink>
            <RouterLink class="form__link"
               to="/reset-hasla"
            >
                Nie pamiętam hasła
            </RouterLink>
        </div>
    </form>
</template>

<script>
    export default {
        name: "SignInForm",
        data() {
            return {
                email: '',
                password: '',
                emailError: '',
                credentialsError: ''
            }
        },
        computed: {
            isLoading() {
                return this.$store.getters.isLoading;
            },
            hasError() {
                return this.$store.getters.hasError;
            },
            errorMessage() {
                return this.$store.getters.errorMessage;
            }
        },
        created() {
            let redirect = this.$route.query.redirect;

            if (this.$store.getters.isAuthenticated) {
                if (typeof redirect !== "undefined") {
                    this.$router.push({path: redirect});
                } else {
                    this.$router.push({path: "/"});
                }
            }
        },
        methods: {
            emailErrorDelete: function() {
                this.emailError = '';
            },
            credentialsErrorDelete: function() {
                this.credentialsError = '';
            },
            async performLogin() {
                let payload = {email: this.$data.email, password: this.$data.password},
                    redirect = this.$route.query.redirect;

                await this.$store.dispatch("login", payload);
                if (!this.$store.getters.hasError) {
                    if (typeof redirect !== "undefined") {
                        this.$router.push({path: redirect});
                    } else {
                        this.$router.push({path: "/"});
                    }
                } else {
                    if (this.errorMessage === 'Username could not be found.') {
                        this.emailError = 'Nie ma takiego użytkownika';
                        this.email = '';
                        this.credentialsError = '';
                    } else if(this.errorMessage === 'Invalid credentials.') {
                        this.credentialsError = 'Nieprawidłowe hasło';
                        this.password = '';
                    } else {
                        this.emailError = this.errorMessage;
                        this.email = '';
                        this.credentialsError = '';
                    }
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .form {
        width: 250px;
        margin: 0 auto;
        padding: 15px;
        background-color: #0057E8;
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
            font-weight: normal;
            -webkit-backface-visibility: hidden;

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
                border: 1px solid #00A8E8;
                border-radius: 3px;
                box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

                &:after {
                    content: "";
                    position: absolute;
                    display: none;
                    left: 4px;
                    width: 5px;
                    height: 10px;
                    border: solid #00A8E8;
                    border-width: 0 3px 3px 0;
                    -webkit-transform: rotate(45deg);
                    -ms-transform: rotate(45deg);
                    transform: rotate(45deg);
                }

                &:focus {
                    outline: none;
                    box-shadow: 0 0 5px 0 #00dce8;
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
            -webkit-appearance: none;

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #00dce8;
            }
        }

        &__links {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        &__link {
            color: #fff;
            font-size: 13px;
            text-decoration: none;
        }
    }
</style>
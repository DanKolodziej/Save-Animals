<template>
    <div class="password-reset">
        <h1 class="password-reset__title">
            Nie pamiętasz hasła?
        </h1>
        <div v-if="!isResetLinkSent"
             class="password-reset__content"
        >
            <p class="password-reset__paragraph">
                Podaj adres email i wyślemy Ci link do wprowadzenia nowego hasła.
            </p>
            <label class="password-reset__label"
                   for="email"
            >
                Email
                <input class="password-reset__input"
                       :class="{'password-reset__input--error': emailError.length > 0}"
                       type="email"
                       id="email"
                       name="email"
                       v-model="email"
                       :placeholder="emailError"
                       @click="emailErrorDelete"
                >
            </label>
            <input class="password-reset__submit"
                   v-show="!isLoading"
                   type="submit"
                   value="Wyślij"
                   @click.prevent="sendPasswordResetLink"
            >
            <ClipLoader
                    class="password-reset__loading"
                    :loading="isLoading"
                    :color="'#fff'"
                    :size="'45px'"
            />
        </div>
        <div v-if="isResetLinkSent"
             class="password-reset__success-message"
        >
            Wysłano link do podanego adresu email w celu uzyskania nowego hasła!
        </div>
    </div>
</template>

<script>
    import ClipLoader from 'vue-spinner/src/ClipLoader';
    import axios from 'axios';

    export default {
        name: "PasswordReset",
        components: {
            ClipLoader
        },
        data() {
            return {
                email: '',
                emailError: '',
                isLoading: false,
                isResetLinkSent: false
            }
        },
        methods: {
            emailErrorDelete: function() {
                this.emailError = '';
            },
            sendPasswordResetLink: function() {
                this.isLoading = true;
                var formData = new FormData();
                formData.append('email', this.email);
                axios.post('/password-reset', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(() => {
                    this.isLoading = false;
                    this.isResetLinkSent = true;
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
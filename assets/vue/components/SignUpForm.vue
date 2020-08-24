<template>
    <form class="form" method="post">
        <h1 class="form__title">
            Rejestracja
        </h1>
        <label class="form__label"
               for="email"
        >
            Email
            <input class="form__input"
                   :class="{'form__input--error': emailError.length > 0}"
                   :placeholder="emailError"
                   type="email"
                   id="email"
                   name="email"
                   v-model="email"
                   @click="emailErrorDelete"
            >
        </label>
        <label class="form__label"
               for="password"
        >
            Hasło
            <input class="form__input"
                   :class="{'form__input--error': passwordError.length > 0}"
                   :placeholder="passwordError"
                   type="password"
                   id="password"
                   name="password"
                   v-model="password"
                   @click="passwordErrorDelete"
            >
        </label>
        <label class="form__label"
               for="repeat-password"
        >
            Powtórz hasło
            <input class="form__input"
                   :class="{'form__input--error': repeatPasswordError.length > 0}"
                   :placeholder="repeatPasswordError"
                   type="password"
                   id="repeat-password"
                   name="repeat-password"
                   v-model="repeatPassword"
                   @click="repeatPasswordErrorDelete"
            >
        </label>
        <label class="form__label">
            Rodzaj użytkownika
        </label>
        <div class="form__radio-group">
            <div class="form__radio-button-container">
                <input class="form__radio-button"
                       type="radio"
                       id="person"
                       name="role"
                       value="PERSON"
                       v-model="role">
                <label class="form__radio-label"
                       for="person">
                    Osoba fizyczna
                </label>
            </div>
            <div class="form__radio-button-container">
                <input class="form__radio-button"
                       type="radio"
                       id="animal-shelter"
                       name="role"
                       value="ANIMAL_SHELTER"
                       v-model="role"
                >
                <label class="form__radio-label"
                       for="animal-shelter"
                >
                    Schronisko (lub inny typ organizacji)
                </label>
            </div>
        </div>
        <TextInput
                :label="nameLabel"
                :error="nameError"
                @updateValue="nameUpdate"
                @deleteErrorMessage="nameErrorDelete"
        />
        <label class="form__label">
            Województwo
        </label>
        <div class="form__dropdown-container"
             @keypress.enter="toggleProvinces"
             @keyup.up.stop="selectUpProvince"
             @keyup.down.stop="selectDownProvince"
             @focusout="hideProvinces"
             tabindex="0"
        >
            <div class="form__dropdown-group"
                 @click="toggleProvinces"
            >
                <input type="text"
                       id="province"
                       class="form__dropdown"
                       :class="{'add-animal-form__dropdown--error': provinceError.length > 0}"
                       v-model="selectedProvince"
                       disabled
                >
                <div class="form__dropdown-arrow-container">
                    <font-awesome-icon class="form__dropdown-arrow"
                                       icon="chevron-down"
                                       :class="{'form__dropdown-arrow--active': areProvincesDisplayed}"
                    />
                </div>
            </div>
            <div class="provinces-list-container">
                <ul class="provinces-list"
                    :class="{'provinces-list--displayed': areProvincesDisplayed}"
                >
                    <li class="provinces-list__item"
                        v-for="province in provinces"
                        :class="{'provinces-list__item--selected': selectedProvince === province}"
                        @click="setProvince(province)"
                    >
                        {{ province }}
                    </li>
                </ul>
            </div>
        </div>
        <TextInput
                :label="'Miejscowość'"
                :error="cityError"
                @updateValue="cityUpdate"
                @deleteErrorMessage="cityErrorDelete"
        />
        <label class="form__terms"
               for="terms"
        >
            Wyrażam zgodę na przetwarzanie danych osobowych oraz zapoznałem/am się z
            <a class="form__link"
               href="/polityka-prywatnosci"
               target="_blank"
            >
                polityką prywatności
            </a>.
            <input class="form__terms-input"
                   type="checkbox"
                   id="terms"
                   name="terms"
                   v-model="termsAccepted"
            >
            <span class="form__terms-checkbox"></span>
            <span class="form__terms-unaccepted"
                  v-show="!termsAccepted">
                Wymagane jest potwierdzenie.
            </span>
        </label>
        <input class="form__submit"
               type="submit"
               value="Zatwierdź"
               @click.prevent="register"
               v-show="!isLoading"
        >
        <ClipLoader
                :loading="isLoading"
                :color="'#fff'"
                :size="'45px'"
        />
    </form>
</template>

<script>
    import TextInput from "./TextInput";
    import axios from "axios";
    import ClipLoader from 'vue-spinner/src/ClipLoader';

    export default {
        name: "SignUpForm",
        components: {
            TextInput,
            ClipLoader
        },
        data() {
            return {
                email: '',
                password: '',
                repeatPassword: '',
                role: 'PERSON',
                name: '',
                provinces: ['Dolnośląskie', 'Kujawsko-Pomorskie', 'Lubelskie',
                    'Lubuskie', 'Łódzkie', 'Małopolskie', 'Mazowieckie',
                    'Opolskie', 'Podkarpackie', 'Podlaskie',
                    'Pomorskie', 'Ślaskie', 'Świętokrzyskie',
                    'Warmińsko-Mazurskie', 'Wielkopolskie', 'Zachodniopomorskie'],
                selectedProvince: 'Dolnośląskie',
                areProvincesDisplayed: false,
                city: '',
                termsAccepted: false,
                emailError: '',
                passwordError: '',
                repeatPasswordError: '',
                nameError: '',
                provinceError: '',
                cityError: '',
                isLoading: false
            }
        },
        computed: {
            nameLabel: function() {
                return this.role === 'PERSON' ? 'Imię (+ opcjonalnie nazwisko)' : 'Nazwa'
            }
        },
        methods: {
            toggleProvinces: function() {
                this.areProvincesDisplayed = !this.areProvincesDisplayed;
                if(this.selectedProvince === this.provinceError) {
                    this.selectedProvince = '';
                    this.provinceError = ''
                }
            },
            selectUpProvince() {
                if(this.areProvincesDisplayed) {
                    var provinceIndex = this.provinces.indexOf(this.selectedProvince);
                    if(provinceIndex > 0) {
                        this.selectedProvince = this.provinces[provinceIndex - 1];
                    } else {
                        this.selectedProvince = this.provinces[this.provinces.length - 1];
                    }
                }
            },
            selectDownProvince() {
                if(this.areProvincesDisplayed) {
                    var provinceIndex = this.provinces.indexOf(this.selectedProvince);
                    if(this.provinces.length - 1 > provinceIndex) {
                        this.selectedProvince = this.provinces[this.provinces.indexOf(this.selectedProvince) + 1];
                    } else {
                        this.selectedProvince = this.provinces[0];
                    }
                }
            },
            hideProvinces() {
                this.areProvincesDisplayed = false;
            },
            setProvince: function(province) {
                this.selectedProvince  = province;
                this.areProvincesDisplayed = false;
            },
            emailErrorDelete: function() {
                this.emailError = '';
            },
            passwordErrorDelete: function() {
                this.passwordError = '';
            },
            repeatPasswordErrorDelete: function() {
                this.repeatPasswordError = '';
            },
            nameUpdate: function(value) {
                this.name = value;
            },
            nameErrorDelete: function() {
                this.nameError = '';
            },
            cityUpdate: function(value) {
                this.city = value;
            },
            cityErrorDelete: function() {
                this.cityError = '';
            },
            register: function() {
                if(this.validate()) {
                    var formData = new FormData();
                    formData.append('email', this.email);
                    formData.append('password', this.password);
                    formData.append('password-repeat', this.repeatPassword);
                    formData.append('role', this.role);
                    formData.append('name', this.name);
                    formData.append('city', this.city);
                    formData.append('province', this.selectedProvince);
                    formData.append('terms-accepted', this.termsAccepted);

                    this.isLoading = true;
                    axios.post('/register', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(() => {
                        this.isLoading = false;
                        this.$emit('showSuccessMessage');
                    }).catch(error => {
                        var errorMessages = error.response.data;
                        if (errorMessages.email) {
                            this.emailError = errorMessages.email[0];
                            this.email = '';
                        }
                        if (errorMessages.password) {
                            this.passwordError = errorMessages.password[0];
                            this.password = '';
                        }
                        if (errorMessages.repeatPassword) {
                            this.repeatPasswordError = errorMessages.repeatPassword[0];
                            this.repeatPassword = '';
                        }
                        if (errorMessages.name) {
                            this.nameError = errorMessages.name[0];
                            this.name = '';
                        }
                        if (errorMessages.province) {
                            this.provinceError = errorMessages.province[0];
                            this.province = this.provinceError;
                        }
                        if (errorMessages.city) {
                            this.cityError = errorMessages.city[0];
                            this.city = '';
                        }

                        this.isLoading = false;
                    });
                }
            },
            validate: function() {
                return this.termsAccepted;
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

        &__radio-group {
            margin-bottom: 10px;
        }

        &__radio-button-container {
            font-size: 13px;
            margin: 3px 0;
        }

        &__radio-label {
            color: #fff;
            cursor: pointer;
        }

        &__radio-button {

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
                border-radius: 100%;
                background: #fff;
            }

            &:checked + label:after, &:not(:checked) + label:after {
                content: '';
                width: 12px;
                height: 12px;
                background: #00A8E8;
                position: absolute;
                top: 4px;
                left: 4px;
                border-radius: 100%;
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
                transform: scale(1);
            }
        }
        
        &__dropdown-container {
            &:focus {
                outline: none;

                .form__dropdown,
                .form__dropdown-arrow-container {
                    box-shadow: 0 0 5px 0 #00dce8;
                }
            }
        }

        &__dropdown-group {
            display: flex;
            margin: 5px 0 10px;
        }

        &__dropdown {
            display: block;
            width: 100%;
            padding: 5px;
            font-size: 18px;
            border: 2px solid #00A8E8;
            border-radius: 3px 0 0 3px;
            box-sizing: border-box;
            box-shadow: 0 0 5px 0 rgba(0,0,0,0.75);

            &:disabled {
                background-color: #fff;
                color: #000;
                cursor: pointer;
            }

            &:focus {
                outline: none;
                box-shadow: 0 0 5px 0 #00dce8;
            }

            &--error:disabled {
                border-color: #C82829;
                background-color: #eeaaaa;
                color: #C82829;

                &:focus {
                    box-shadow: 0 0 5px 0 #eeaaaa;
                }
            }
        }

        &__dropdown-arrow-container {
            display: flex;
            align-items: center;
            padding: 0 10px;
            cursor: pointer;
            background-color: #00A8E8;
            color: #fff;
            border-radius: 0 3px 3px 0;
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.75);
        }

        &__dropdown-arrow {
            transition: all 0.5s ease-out;

            &--active {
                transform: rotate(180deg);
            }
        }

        .provinces-list-container {
            overflow: hidden;
            position: absolute;
            width: 200px;
            height: 128.33px;
            margin-top: -10px;
            pointer-events: none;
        }

        .provinces-list {
            visibility: hidden;
            list-style: none;
            background-color: #fff;
            color: #000;
            position: absolute;
            width: 98%;
            margin: -125px 0 0;
            padding-left: 0;
            border: 2px solid #00A8E8;
            border-radius: 3px;
            transition: all 0.5s ease-out;
            max-height: 124.33px;
            overflow-y: auto;
            pointer-events: all;
            scrollbar-width: thin;
            scrollbar-color: #00A8E8 #e0e0e0;
            z-index: 99;
            &::-webkit-scrollbar {
                width: 8px;
            }
            &::-webkit-scrollbar-track {
                background-color: #e0e0e0;
                border-radius: 10px;
            }
            &::-webkit-scrollbar-thumb {
                background-color: #00A8E8;
                border-radius: 10px;
                box-shadow: inset 0 0 6px rgba(0,0,0,.3);
            }

            &--displayed {
                visibility: visible;
                margin-top: 0;
            }

            &__item {
                padding: 5px;
                border-bottom: 1px solid #00A8E8;
                cursor: pointer;
                transition: all 0.5s ease-out;

                &:hover, &--selected {
                    background-color: #e0e0e0;
                }

                &:last-child {
                    border-bottom: 0;
                }

                &--disabled {
                    cursor: default;
                    pointer-events: none;
                }
            }
        }

        &__terms {
            display: inline-block;
            width: 100%;
            color: #fff;
            font-size: 13px;
            line-height: 1.5;
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
                left: 130px;
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

            &-unaccepted {
                margin-left: 25px;
                font-weight: bold;
                color: #ed3e12;
            }

            &-input:checked ~ &-checkbox:after {
                display: block;
            }
        }

        &__link {
            color: #fff;
        }

        &__submit {
            display: block;
            margin: 0 auto;
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
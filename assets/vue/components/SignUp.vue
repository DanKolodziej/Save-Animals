<template>
    <div class="sign-up-page">
        <div class="sign-up-success-message"
             v-show="isUserRegistered"
        >
            Wysłano link do podanego adresu email w celu weryfikacji!
        </div>
        <signUpForm
                v-show="!isUserRegistered"
                @showSuccessMessage="isUserRegistered = true"
        />
    </div>
</template>

<script>
    import SignUpForm from "./SignUpForm";

    export default {
        name: "SignUp",
        components: {
            SignUpForm
        },
        data() {
            return {
                isUserRegistered: false
            }
        }
    }
</script>

<style lang="scss" scoped>
    .sign-up-page {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px 0;

        .sign-up-success-message {
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
    }

</style>
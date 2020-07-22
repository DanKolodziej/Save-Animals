<template>
    <div class="sign-up-page">
        <signUpForm/>
    </div>
</template>

<script>
    import SignUpForm from "./SignUpForm";

    export default {
        name: "SignUp",
        components: {
            SignUpForm
        }
    }
</script>

<style lang="scss" scoped>
    .sign-up-page {
        display: flex;
        align-items: center;
        padding: 30px 0;
    }

</style>
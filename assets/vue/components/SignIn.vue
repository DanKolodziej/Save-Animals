<template>
    <div class="sign-in-page">
        <sign-in-form></sign-in-form>
    </div>
</template>

<script>
    import SignInForm from "./SignInForm";

    export default {
        name: "SignIn",
        components: {SignInForm}
    }
</script>

<style lang="scss" scoped>
    .sign-in-page {
        display: flex;
        align-items: center;
        padding: 30px 0;
    }
</style>
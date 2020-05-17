<template>
    <div class="animal-card">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcTmAlZoXH7c35THjrLVaIsu5FcgpWVdpPprOl6xaXhvMviVVmwI&usqp=CAU">
        <div>
            <h2>Title</h2>
            <p>This is a placeholder This is a placeholder This is a placeholder
                This is a placeholder This is a placeholder This is a placeholder
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AnimalCard",
    }
</script>

<style lang="scss" scoped>
    .animal-card {
        max-width: 250px;
        border: 2px solid #192BC2;
        box-shadow: 10px 0 50px -10px rgba(0,0,0,0.75);
        margin-right: 30px;
        margin-bottom: 30px;
        img {
            width: 100%;
            object-fit: cover;
        }
        div {
            padding: 0 15px;
            /*border: 2px solid #192BC2;*/
        }
    }
</style>
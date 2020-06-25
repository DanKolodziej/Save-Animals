<template>
    <div class="endangered-species-page">
        <h1 class="page-title">Zagrożone gatunki zwierząt w Polsce</h1>
        <div class="endangered-species-content">
            <div class="posts-container">
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                    </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
                <post :title="'Title'"
                    :description="'This is a placholder This is a placholder This is a placholder'"
                    :image-file-name="''">
                </post>
            </div>
            <div class="endangered-species-radio-group">

            </div>
        </div>
    </div>
</template>

<script>
    import Post from './Post';

    export default {
        name: "EndangeredSpecies",
        components: {
            Post
        }
    }
</script>

<style lang="scss" scoped>

</style>
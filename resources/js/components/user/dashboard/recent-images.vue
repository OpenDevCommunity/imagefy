<template>
    <div>

    </div>
</template>

<script>
    export default {
        props: ['apikey'],
        name: "recent-images",
        data() {
            return {
                images: []
            }
        },
        methods: {
            getUserImages() {
                //
            }
        },
        mounted() {
            this.getUserImages();
        }
    }
</script>

<style scoped>

</style>

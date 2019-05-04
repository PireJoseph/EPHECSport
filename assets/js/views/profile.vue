<style scoped>

</style>

<template>
    <div>
        <div class="row col">
            <h1>Profile</h1>
            <router-view name="profileContent"></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'profile'
    }
</script>
<template>
    <div>
        <div class="row col">
            <h1>Information</h1>
            <router-view name="informationContent"></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'information'
    }
</script>
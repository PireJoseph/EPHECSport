<template>
    <div>
        <div class="row col">
            <h1>Activité</h1>
            <router-view name="activityContent"></router-view>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'activity'
    }
</script>
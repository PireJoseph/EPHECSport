<style scoped="true">

    #logoContainer {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-grow: 1;
        justify-content: center;

    }
    @media only screen and (max-width: 600px) {

        #logo {
            width: 65%;
            margin-bottom: 50px;

        }
    }

    @media only screen and (min-width: 601px) and ( max-width: 1399px) {

        #logo {
            width: 40%;
        }
    }


    @media only screen and (min-width: 1400px) {
        #logo {
            width: 35%;
        }
    }


</style>

<template>

    <div id="logoContainer">
            <img id="logo" alt="logo EPHEC Sport" src="/images/logoEPHECSport.gif" class="w3-centered w3-opacity-max " >
    </div>

</template>

<script>
    export default {
        name: 'home'
    }
</script>
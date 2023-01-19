<template>
    <div class="banner">
        <div class="bannerContent">
            <h1>Prochaine séance</h1>
            <h2>date et heure</h2>
            <h3>film</h3>
        </div>
    </div>
</template>


<script setup>


</script>



<style scoped>
.banner{
    height: 300px;
    color: var(--color-white);
}

.bannerContent{
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding-left: 30px;
    height: 100%;
    background-image: url("../assets/cinema.jpeg");
    background-position: center;
    background-size: cover;
}

.bannerContent h1 {

    text-transform: uppercase;
    font-size: 2em;
    font-weight: 800;
    margin: 0;
}

.bannerContent h3 {
    font-size: 1.1em;
    width: 25rem;
}

</style>
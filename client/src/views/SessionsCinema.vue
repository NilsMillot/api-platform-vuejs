<template>
    <div class="container mt-5">
        <div class="row">
            <div class="d-flex justify-content-between">
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-dark" @click="type = 'new'">Nouveau</button>
                    <button type="button" class="btn btn-dark" @click="type = 'old'">Ancien</button>
                </div>
                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-dark">Nouvelle séance</button>
                </div>
            </div>
            <div v-if="type == 'new'" class="col-md-5">
                <ul class="list-group">
                    <li class="list-group-item list">
                        <h5>AVATAR</h5>
                        <h6>20 février 2023 - 11:15</h6>
                    </li>
                    <li class="list-group-item list">
                        <h5>AVATAR</h5>
                        <h6>20 février 2023 - 11:15</h6>
                    </li>
                    <li class="list-group-item list">
                        <h5>AVATAR</h5>
                        <h6>20 février 2023 - 11:15</h6>
                    </li>
                </ul>
            </div>


            <div class="col-md-7 list-group list" style="height:200px">
                
            </div>
        </div>
    </div>
</template>


<script setup>
import { ref } from "vue";

const type = ref("new");



</script>

<style scoped>

.list {
    background-color: #2f2f2f;
    color:white
}

.list:hover {
    border-left: 2px solid var(--color-darkred);
}
</style>
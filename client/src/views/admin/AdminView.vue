<template>

<div>
<div class="card card-admin shadow-sm">
    <div>
        <h3 class="pt-3">Admin</h3>
        <hr/>
    </div>
    <div class="d-flex flex-wrap justify-content-center">
        <router-link class="btn mt-4 btn-cinemax" to="/admin/users">Utilisateurs</router-link>
        <router-link class="btn mt-4 btn-cinemax" to="/admin/session/list">Seances</router-link>
        <router-link class="btn mt-4 btn-cinemax" to="/admin/quizz/new">Quiz</router-link>
    </div>
    
  </div>
</div>
</template>

<style scoped>
.card-admin {
  width: 70%;
  height: 100%;
  margin: 50px;
  padding: 20px;
  background-color: #ffffff30;
  color: var(--color-white);
  box-shadow: 20px;
}
.btn-cinemax {
background-color: var(--color-red);
color: var(--color-white);
text-align: center;
width: 150px;
margin: 50px ;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
</style>

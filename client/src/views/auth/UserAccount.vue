<template>
  <div>
    <div class="card card-account shadow-sm">
      <div>
        <h3 class="pt-3">Mon compte</h3>
        <hr />
      </div>
      <div class="d-flex">
      <div class="card-body">
        <div class="form-group">
          <label for="name">Nom :</label>
          <input
            type="text"
            v-model="user.value.name"
            name="name"
            class="form-control"
            autocomplete="name"
            required
            autofocus
          />
        </div>
        <div class="form-group">
          <label for="address">Adresse :</label>
          <input
            type="text"
            v-model="user.value.adress"
            name="address"
            class="form-control"
            autocomplete="address"
            required
            autofocus
          />
        </div>
        <div class="form-group">
          <label for="email">E-mail : </label>
          <input
            disabled
            type="email"
            v-model="user.value.email"
            name="email"
            class="form-control"
            autocomplete="email"
            required
            autofocus
          />
        </div>
        <div class="d-flex justify-content-center">
          <button class="btn mt-4 btn-cinemax" type="submit" @click="HandleSubmitForm">
            <span>Modifier</span>
          </button>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group">
          <label for="password">Mot de passe :</label>
          <input
            type="password"
            name="password"
            class="form-control"
            autocomplete="password"
            required
            autofocus
          />
        </div>
        <div class="form-group">
          <label for="password">Nouveau mot de passe :</label>
          <input
            type="password"
            name="password"
            class="form-control"
            autocomplete="password"
            required
            autofocus
          />
        </div>
        <div class="d-flex justify-content-center">
          <button class="btn mt-4 btn-cinemax" type="submit">
            <span>Changer mon mot de passe</span>
          </button>
        </div>
      </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive } from "vue";

const user = reactive({ value: {} });

onMounted(async () => {
  await fetchUser();
  console.log(user.value.id);
});
const fetchUser = async () => {
  return fetch(`${import.meta.env.VITE_API_SERVER_URL}/users/1`)
    .then((response) => response.json())
    .then((data) => {
      user.value = data;
      console.log(user.value);
    });
};
</script>

<style scoped>
.card-account {
  width: 90%;
  height: 90%;
  margin: 0 auto;
  margin-top: 80px;
  padding: 20px;
  background-color: #ffffff30;
  color: var(--color-white);
  box-shadow: 20px;
}
.btn-cinemax {
  background-color: var(--color-red);
  color: var(--color-white);
  text-align: center;
  width: 100%;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
.form-control {
    color: var(--color-white);
    border: none; 
}
</style>

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
              v-model="user.name"
              name="name"
              class="form-control"
            />
          </div>
          <div class="form-group">
            <label for="address">Adresse :</label>
            <input
              type="text"
              v-model="user.adress"
              name="address"
              class="form-control"
            />
          </div>
          <div class="form-group">
            <label for="address">Demande de rôle cinéma :</label>
            <input type="checkbox" v-model="user.isCinema" name="isCinema" />
          </div>
          <div class="d-flex justify-content-center">
            <button
              class="btn mt-4 btn-cinemax"
              type="submit"
              @click="handleSubmitForm()"
            >
              <span>Modifier</span>
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <router-link to="/forget-password" class="btn mt-4 btn-cinemax"
              >Changer mon mot de passe</router-link
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive } from "vue";

const user = reactive({});

onMounted(async () => {
  if (localStorage.getItem("token")) {
    const response = await fetch(`${import.meta.env.VITE_API_SERVER_URL}/me`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    const currentUser = await response.json();
    user.id = currentUser.id;
    user.name = currentUser.name;
    user.adress = currentUser.adress;
    user.isCinema = currentUser.status === "cinemaRoleRequested" ? true : false;
  }
});

const handleSubmitForm = () => {
  const requestOptions = {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
    body: JSON.stringify({
      name: user.name,
      adress: user.adress,
      status: user?.isCinema ? "cinemaRoleRequested" : "",
    }),
  };
  fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users/${user.id}`,
    requestOptions
  ).then((response) => console.log(response.json()));
  console.log("%cUserAccount.vue line:89 user", "color: #007acc;", user);
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
</style>

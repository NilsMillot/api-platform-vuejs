<template>
  <div class="container">
    <div v-if="message != ''" class="alert alert-dark mt-2" role="alert">
        {{ message }}
      </div>
    <div class="card card-account shadow-sm">
      <div>
        <h3 class="pt-3">
          Mon compte ({{
            user?.roles?.includes("ROLE_CINEMA") ? "cinéma" : "client"
          }}) - Mes crédits : {{ user?.totalCredits }}
        </h3>
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
import { onMounted, reactive, ref } from "vue";

const user = reactive({});
const message = ref("");

if (!localStorage.getItem("token")) {
  location.href = "/";
}

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
    user.totalCredits = currentUser.totalCredits;
    user.id = currentUser.id;
    user.name = currentUser.name;
    user.adress = currentUser.adress;
    user.roles = currentUser.roles;
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
  fetch(`${import.meta.env.VITE_API_SERVER_URL}/me`, requestOptions).then(
    (response) => {
      if (response.status === 200) {
        message.value = "Votre compte a bien été modifié."
      } else {
        message.value = "Une erreur est survenue."
      }
    }
  );
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

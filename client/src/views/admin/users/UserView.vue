<template>
  <div>
    <div class="card card-user-edit shadow-sm" v-if="!shouldOfuscate">
      <div>
        <h3 class="pt-3">Utilisateur: {{ user.email }}</h3>
        <hr />
      </div>
      <div class="d-flex">
        <div class="card-body">
          <form @submit="handleSubmitUpdatedUser">
            <!-- <input type="hidden" v-model="user.id" /> -->
            <div class="form-group">
              <label for="name">Nom :</label>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="user.name"
                placeholder="Nom"
              />
            </div>
            <div class="form-group">
              <label for="address">Adresse :</label>
              <input
                type="text"
                class="form-control"
                id="adress"
                v-model="user.adress"
                placeholder="Adresse"
              />
            </div>
            <div class="form-group">
              <label for="totalCredits">Total de crédits :</label>
              <input
                type="number"
                class="form-control"
                id="totalCredits"
                v-model="user.totalCredits"
                placeholder="Crédits"
              />
            </div>
            <div class="form-group">
              <label for="status">Status :</label>
              <input
                type="text"
                class="form-control"
                id="status"
                v-model="user.status"
                placeholder="Status"
              />
            </div>
            <div id="roles">
              <span>
                <label for="isAdmin">COMPTE ACTIVE :</label>
                <input type="checkbox" v-model="user.enabled" />
              </span>
              <span>
                <label for="isAdmin">COMPTE CINEMA :</label>
                <input type="checkbox" v-model="user.isCinema" />
              </span>
              <span>
                <label for="isAdmin">COMPTE ADMIN :</label>
                <input type="checkbox" v-model="user.isAdmin" />
              </span>
            </div>
            <div
              class="alert alert-primary"
              role="alert"
              v-show="messageFromFetch"
            >
              {{ messageFromFetch }}
            </div>
            <div class="d-flex" id="buttonsSubmit">
              <button
                type="submit"
                class="btn m-4 btn-cinemax"
                :disabled="isSent"
              >
                <span v-show="!isSent">Envoyer</span>
                <span
                  v-show="isSent"
                  class="spinner-border spinner-border-sm"
                  role="status"
                  aria-hidden="true"
                ></span>
              </button>
              <router-link to="/admin/users" class="btn m-4 btn-cinemax"
                >Retour</router-link
              >
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-12" v-else>
      <h1>User</h1>
      <p>Vous n'avez pas accès à cette page</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref, watchEffect, inject } from "vue";
const user = reactive({});
const shouldOfuscate = ref(true);
const currentUser = inject("currentUser");
const isSent = ref(false);
const messageFromFetch = ref("");

if (!localStorage.getItem("token")) {
  location.href = "/";
}

watchEffect(() => {
  if (currentUser) {
    if (currentUser.roles?.includes("ROLE_ADMIN")) {
      shouldOfuscate.value = false;
    } else if (
      currentUser.roles?.includes("ROLE_USER") ||
      currentUser.roles?.includes("ROLE_CINEMA")
    ) {
      location.href = "/";
    }
  } else {
    location.href = "/";
  }
});

onMounted(async () => {
  const id = location.href.split("/").pop();

  const response = await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users/${id}`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  );
  const userFetched = await response.json();

  if (response.status !== 200) {
    shouldOfuscate.value = true;
  } else {
    shouldOfuscate.value = false;
    user.id = userFetched.id;
    user.adress = userFetched.adress;
    user.status = userFetched.status;
    user.name = userFetched.name;
    user.isAdmin = userFetched.roles.includes("ROLE_ADMIN");
    user.isCinema = userFetched.roles.includes("ROLE_CINEMA");
    user.totalCredits = userFetched.totalCredits;
    user.enabled = userFetched.enabled;
    user.email = userFetched.email;
  }
});

const handleSubmitUpdatedUser = async (e) => {
  isSent.value = true;
  e.preventDefault();
  const response = await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users/${user.id}`,
    {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      body: JSON.stringify({
        name: user.name,
        adress: user.adress,
        totalCredits: user.totalCredits,
        status: user.status,
        enabled: user.enabled,
        roles: user.isAdmin
          ? ["ROLE_ADMIN"]
          : user.isCinema
          ? ["ROLE_CINEMA"]
          : ["ROLE_USER"],
      }),
    }
  );
  if (response.status === 200) {
    messageFromFetch.value = "L'utilisateur a été modifié avec succès !";
  } else {
    messageFromFetch.value = "Une erreur est survenue.";
  }
  isSent.value = false;
};
</script>

<style scoped>
h1,
p {
  color: #fff;
}

.card-user-edit {
  width: 70%;
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
  width: 25%;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}

#roles {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 20px;
}

#buttonsSubmit {
  justify-content: center;
}
</style>

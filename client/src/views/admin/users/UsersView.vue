<template>
  <div class="container m-5">
    <div>
      <h2 class="pt-2">Utilisateurs</h2>
      <hr class="pb-5" />
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table pt-10 tab" v-if="!shouldOfuscate">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">NOM</th>
              <th scope="col">EMAIL</th>
              <th scope="col">ROLE</th>
              <th scope="col">ACTIONS</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>{{ user.roles }}</td>
              <td>
                <router-link
                  :to="'/admin/users/' + user.id"
                  class="btn btn-sm me-2 btn-cinemax"
                  >Modifier</router-link
                >
                <button
                  class="btn btn-sm btn-cinemax"
                  @click="deleteUser(user.id)"
                >
                  Supprimer
                </button>
              </td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  v-model="newUser.name"
                  placeholder="Nom"
                />
              </td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  v-model="newUser.email"
                  placeholder="Email"
                />
              </td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  v-model="newUser.adress"
                  placeholder="Adresse"
                />
              </td>
              <td>
                <input
                  type="checkbox"
                  v-model="newUser.isCinema"
                  placeholder="Is Cinema"
                />
                <label for="isCinema">EST UN CINÉMA</label>
                <br />
                <input type="checkbox" v-model="newUser.isAdmin" />
                <label for="isAdmin">EST UN ADMIN</label>
              </td>
              <td>
                <button class="btn mt-2 btn-cinemax" @click="addUser">
                  Ajouter
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <h1 v-if="shouldOfuscate">Vous n'avez pas accès à cette page</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
const shouldOfuscate = ref(true);
const users = reactive([]);
const newUser = reactive({
  name: "",
  email: "",
  adress: "",
  isCinema: false,
  isAdmin: false,
});

onMounted(async () => {
  const response = await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users?page=1`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  );
  if (response.status !== 200) {
    location.href = "/";
  } else {
    shouldOfuscate.value = false;
  }

  const usersFetched = await response.json();
  const users2 = usersFetched["hydra:member"];

  users2?.forEach((user) => {
    users.push(user);
  });
});

const addUser = async () => {
  const response = await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/signupadmin`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      body: JSON.stringify(newUser),
    }
  );
  const user = await response.json();

  if (user["hydra:description"]) {
    alert(user["hydra:description"]);
  }
  if (response.status === 201) {
    alert("User created");
    if (newUser.isCinema) {
      newUser.roles = "ROLE_CINEMA";
    } else if (newUser.isAdmin) {
      newUser.roles = "ROLE_ADMIN";
    } else {
      newUser.roles = "ROLE_USER";
    }
    users.push(newUser);
  }
};

const deleteUser = async (userId) => {
  const response = await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users/${userId}`,
    {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  );
  const user = await response.json();
  console.log(response.status);
  if (response.status === 200) {
    alert("User deleted");
    users.splice(users.indexOf(user), 1);
  }
};
</script>

<style scoped>
.container {
  color: white;
}

.tab {
  background-color: #2f2f2f;
  color: white;
  padding: 200px !important;
}
label {
  padding-left: 5px;
  font-size: 12px;
}

.btn-cinemax {
  background-color: var(--color-red);
  color: var(--color-white);
  text-align: center;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
</style>

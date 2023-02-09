<template>
  <div class="container">
    <h1>Users</h1>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped" v-if="!shouldOfuscate">
          <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
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
                  class="btn btn-primary"
                  >Edit</router-link
                >
                <button class="btn btn-danger" @click="deleteUser(user.id)">
                  Delete
                </button>
              </td>
            </tr>
            <tr>
              <td></td>
              <td>
                <input
                  type="text"
                  class="form-control"
                  v-model="newUser.name"
                  placeholder="Name"
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
                  placeholder="Adress"
                />
              </td>
              <td>
                <input
                  type="checkbox"
                  v-model="newUser.isCinema"
                  placeholder="Is Cinema"
                />
                <label for="isCinema">Is Cinema</label>
                <br />
                <input type="checkbox" v-model="newUser.isAdmin" />
                <label for="isAdmin">Is Admin</label>
              </td>
              <td>
                <button class="btn btn-success" @click="addUser">Add</button>
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
const shouldOfuscate = ref(false);
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
    shouldOfuscate.value = true;
  } else {
    shouldOfuscate.value = false;
  }

  const usersFetched = await response.json();
  const users2 = usersFetched["hydra:member"];

  users2.forEach((user) => {
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
h1,
th,
td {
  color: white;
}
</style>

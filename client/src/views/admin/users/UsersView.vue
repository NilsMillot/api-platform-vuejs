<template>
  <div class="container">
    <h1>Users</h1>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
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
                  type="text"
                  class="form-control"
                  v-model="newUser.roles"
                  placeholder="Roles"
                />
              </td>
              <td>
                <button class="btn btn-success" @click="addUser">Add</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive } from "vue";
const users = reactive([]);
const newUser = reactive({
  name: "",
  email: "",
  adress: "",
  roles: [],
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
  if (localStorage.getItem("token")) {
    const usersFetched = await response.json();
    const users2 = usersFetched["hydra:member"];

    users2.forEach((user) => {
      users.push(user);
    });
  }
});

const addUser = async () => {
  // const response = await fetch(`${import.meta.env.VITE_API_SERVER_URL}/users`, {
  //   method: "POST",
  //   headers: {
  //     "Content-Type": "application/json",
  //     Authorization: `Bearer ${localStorage.getItem("token")}`,
  //   },
  //   body: JSON.stringify(newUser),
  // });
  // const user = await response.json();
  // console.log(user);
  // users.push(user);

  users.push(newUser);
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
  console.log(user);
};
</script>

<style scoped>
h1,
th,
td {
  color: white;
}
</style>

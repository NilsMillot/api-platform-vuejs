<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12" v-if="!shouldOfuscate">
        <h1>User</h1>
        <form @submit="handleSubmitUpdatedUser">
          <!-- <input type="hidden" v-model="user.id" /> -->
          <div class="form-group">
            <label for="name">Name</label>
            <input
              type="text"
              class="form-control"
              id="name"
              v-model="user.name"
              placeholder="Name"
            />
          </div>
          <div class="form-group">
            <label for="adress">Adress</label>
            <input
              type="text"
              class="form-control"
              id="adress"
              v-model="user.adress"
              placeholder="Adress"
            />
          </div>
          <div class="form-group">
            <label for="totalCredits">Total Credits</label>
            <input
              type="text"
              class="form-control"
              id="totalCredits"
              v-model="user.totalCredits"
              placeholder="Total Credits"
            />
          </div>
          <div class="form-group">
            <label for="status">Status</label>
            <input
              type="text"
              class="form-control"
              id="status"
              v-model="user.status"
              placeholder="Status"
            />
          </div>
          <div class="form-group">
            <label for="enabled">Enabled</label>
            <input
              type="text"
              class="form-control"
              id="enabled"
              v-model="user.enabled"
              placeholder="Enabled"
            />
          </div>
          <div class="form-group">
            <label for="roles">Roles</label>
            <input
              type="text"
              class="form-control"
              id="roles"
              v-model="user.roles"
              placeholder="Roles"
            />
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
          <router-link to="/admin/users" class="btn btn-primary"
            >Back</router-link
          >
        </form>
      </div>
      <div class="col-md-12" v-else>
        <h1>User</h1>
        <p>Vous n'avez pas accès à cette page</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
const user = reactive({});
const shouldOfuscate = ref(false);

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
    user.roles = userFetched.roles;
    user.totalCredits = userFetched.totalCredits;
    user.enabled = userFetched.enabled;
  }
});

const handleSubmitUpdatedUser = async (e) => {
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
        roles: user.roles,
      }),
    }
  );
  if (response.status === 200) {
    alert("User updated");
  } else {
    alert("Error when trying to update user");
  }
};
</script>

<style scoped>
h1,
p {
  color: #fff;
}
</style>

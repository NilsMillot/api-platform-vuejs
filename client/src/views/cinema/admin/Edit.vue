<template>
  <div v-if="!shouldOfuscate">
    <HeaderBanner
      title="Modifier une séance"
      img="../../../src/assets/cinema.jpeg"
    />
    <div class="container mt-5">
        <div class="d-flex justify-content-end p-5">
          <router-link to="/cinema/session/list" class="btn btn-sm btn-cinemax-primary">Mes séances</router-link>
        </div>
      <div class="card card-session shadow-sm">
        <div>
          <h3 class="pt-3">Modifier une séance</h3>
          <hr />
        </div>
        <div class="card-body">
          <div class="form-group mt-3">
            <input
              type="text"
              class="form-control"
              required
              disabled
              v-model="session.movie_title"
            />
          </div>
          <div class="form-group mt-3">
            <input
              type="date"
              v-model="session.date"
              class="form-control"
              required
            />
          </div>
          <div class="form-group mt-3">
            <input
              type="time"
              class="form-control"
              required
              v-model="session.time"
            />
          </div>
          <div class="form-group mt-3">
            <input
              type="number"
              placeholder="12,30 €"
              class="form-control"
              required
              v-model="session.price"
            />
          </div>
          <div class="d-flex justify-content-center">
            <button
              class="btn btn-sm btn-cinemax-primary mt-4"
              type="submit"
              @click.prevent="handleSubmit"
            >
              <span>Enregistrer</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { inject, watchEffect, reactive, onMounted, ref } from "vue";
import { useRoute } from "vue-router";
import HeaderBanner from "../../../components/HeaderBanner.vue";

const shouldOfuscate = ref(true);
const currentUser = inject("currentUser");

if (!localStorage.getItem("token")) {
  location.href = "/";
}

watchEffect(() => {
  if (currentUser) {
    if (currentUser.roles?.includes("ROLE_CINEMA")) {
      shouldOfuscate.value = false;
    } else if (
      currentUser.roles?.includes("ROLE_USER") ||
      currentUser.roles?.includes("ROLE_ADMIN")
    ) {
      location.href = "/";
    }
  } else {
    location.href = "/";
  }
});

const session = reactive({
  id: "",
  price: "",
  room: "",
  date: "",
  time: "",
  movie_id: "",
  movie_title: "",
});

onMounted(async () => {
  const { params } = useRoute();
  const { id } = params;
  await fetchSession(id);
});

const fetchSession = async (id) => {
  const requestOptions = {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  };
  await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/movie_screenings/${id}`,
    requestOptions
  ).then((response) =>
    response.json().then((data) => {
      session.id = data.id;
      session.movie_title = data.movie_title;
      session.date = data.session_datetime.split("T")[0];
      session.price = data.price;
      session.time = data.session_datetime.split("T")[1].substr(0, 5);
      session.room = data.room;
      session.movie_id = data.movie_id;
    })
  );
};

const handleSubmit = () => {
  const requestOptions = {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
    body: JSON.stringify({
      sessionDatetime: new Date(new Date(session.date + " " + session.time)),
    }),
  };
  fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/session/edit/${session.id}`,
    requestOptions
  ).then((response) => console.log(response.json()));
};
</script>

<style scoped>
h3,
hr {
  color: var(--color-white);
}
.card-session {
  padding: 20px;
  background-color: #2f2f2f;
  color: var(--color-black);
  box-shadow: 20px;
}
</style>

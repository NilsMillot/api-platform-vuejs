<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-session shadow-sm">
          <div>
            <h3 class="pt-3">Créer une séance</h3>
            <hr />
          </div>
          <div class="card-body">
            <div class="form-group mt-3">
              <input
                type="text"
                class="form-control"
                :value="resultSearch.title"
                required
                disabled
              />
            </div>
            <div class="form-group mt-3">
                <select class="form-select" @change="handleChangeCinema($event)">
                    <option
                    v-for="(cinema, index) in cinema.value"
                    :key="index"
                    :value="cinema.id"
                    >
                    {{ cinema.name }}
                    </option>
                </select>
            </div>
            <div class="form-group mt-3">
              <input
                type="date"
                v-model="date"
                class="form-control"
                required
              />
            </div>
            <div class="form-group mt-3">
              <input
                type="time"
                class="form-control"
                required
                v-model="time"
              />
            </div>
            <div class="form-group mt-3">
              <input
                type="number"
                placeholder="12,30 €"
                class="form-control"
                required
                v-model="price"
              />
            </div>
            <div class="d-flex justify-content-center">
              <button
                class="btn btn-danger mt-4"
                type="submit"
                @click.prevent="handleSubmit"
              >
                <span>Enregistrer</span>
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <SearchBar
          @customEvent="updateSearch"
          placeholder="Choisissez un film..."
        />

        <div>
          <div class="row mt-5">
            <div class="list">
              <div v-for="(item, index) in result.value" :key="index">
                <div @click="handleChange(item)" class="block">
                  <img
                    class="listElements"
                    :src="`${getImageFromSrc(
                      item.backdrop_path || item.poster_path
                    )}`"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>

import { watch, reactive, ref, onMounted } from "vue";
import { getImageFromSrc } from "../../../utils/tmdbCalls";
import SearchBar from "../../../components/SearchBar.vue";


const search = ref("");
const result = reactive({ value: [] });
const resultSearch = reactive({ id: "", title: "" });
const cinema = reactive({value:[]})
const selectedCinema = ref();
const date = ref("");
const time = ref();
const price = ref();
const room = ref(1);

onMounted( async () => {
    await fetchCinema();
    selectedCinema.value = cinema.value[0].id
})

const fetchCinema = async () => {
  const requestOptions = {
    method: "GET",
    headers: { 
      Authorization: `Bearer ${localStorage.getItem("token")}`
    },
  };
  await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/users`,
    requestOptions
  ).then((response) => response.json().then((data) =>

  (cinema.value = data["hydra:member"].filter(
    (x) =>
      x.enabled == true &&
      x.roles.includes("ROLE_CINEMA")
  ))
));

};


const handleChange = (item) => {
  resultSearch.id = item.id;
  resultSearch.title = item.title;
};

const handleChangeCinema = (e) => {
  selectedCinema.value = e.target.value;
};

const updateSearch = (e) => {
  search.value = e.target.value;
};


watch(search, async (newSearch) => {
  await fetch(
    `https://api.themoviedb.org/3/search/movie?api_key=${
      import.meta.env.VITE_TMDB_API_KEY
    }&query=${newSearch}&language=fr`
  )
    .then((response) => response.json())
    .then(
      (data) =>
        (result.value = data.results?.filter(
          (item) => item.backdrop_path && item.poster_path
        ))
    );
});

const handleSubmit = async () => {
  const requestOptions = {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
    body: JSON.stringify({
      sessionDatetime: new Date(
        new Date(date.value.toString() + " " + time.value)
      ),
      price: price.value,
      creator: `/users/${selectedCinema.value}`,
      room: room.value,
      movieId: resultSearch.id,
      movieTitle: resultSearch.title,
      cinema: selectedCinema.value,
    }),
  };
  await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/session/new`,
    requestOptions
  ).then((response) => response.json().then((data) => console.log(data)));
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

.list {
  display: flex;
  overflow-x: scroll;
  padding: 20px;
}

.listElements {
  width: 11.5rem;
  max-height: 100px;
  object-fit: cover;
  border-radius: 4px;
  transition: all 1s;
}

.listElements:hover {
  transform: scale(1.05);
}

.block {
  width: 11.5rem;
  max-height: 100px;
  margin-right: 10px;
  position: relative;
}

.list::-webkit-scrollbar {
  display: none;
}

.input-search {
  border-radius: 15px;
  border: 1px solid var(--color-black);
  padding-left: 2em;
  background-color: #ffffff30;
}
</style>


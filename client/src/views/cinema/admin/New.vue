<template>
  <div class="container">
    <div class="row">
      <div class="d-flex justify-content-end p-5">
        <button class="btn btn-cinemax-dark">Mes séances</button>
      </div>

      <div class="col-md-6">
        <div class="card card-session shadow-sm">
          <div>
            <h3 class="pt-3">Séance</h3>
            <hr />
          </div>
          <div class="card-body">
            <div class="form-group mt-3">
              <input
                type="text"
                class="form-control"
                :value="resultSearch.title"
                required
                autofocus
                disabled
              />
            </div>
            <div class="form-group mt-3">
              <input
                type="date"
                class="form-control"
                v-model="date"
                required
                autofocus
              />
            </div>
            <div class="form-group mt-3">
              <input
                type="time"
                class="form-control"
                v-model="time"
                required
                autofocus
              />
            </div>
            <div class="form-group mt-3">
              <input
                type="number"
                placeholder="12,30 €"
                v-model="price"
                class="form-control"
                required
                autofocus
              />
            </div>

            <div class="form-group mt-3">
              <select v-model="room" class="form-select">
                <option value="1">Salle 1</option>
                <option value="2">Salle 2</option>
                <option value="2">Salle 3</option>
              </select>
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
import { watch, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { getImageFromSrc } from "../../../utils/tmdbCalls";
import SearchBar from "../../../components/SearchBar.vue";

const router = useRouter();
const search = ref("");
const date = ref();
const time = ref();
const price = ref();
const room = ref(1);
const result = reactive({ value: [] });
const resultSearch = reactive({ id: "", title: "" });
const session = ref(null);
const updateSearch = (e) => {
  search.value = e.target.value;
};


const generateSeat = async (id) => {
  for (let i = 1; i <= 30; i++){
    const requestOptions = {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        status: 1,
        seat: 1,
        sessionId: "/movie_screenings/"+ id,
        buyerId: null,
      }),
    };
    await fetch("https://localhost/bookings", requestOptions).then((response) =>
      console.log(response.json())
    );
  }
}

const handleSubmit = async () => {
  const requestOptions = {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      sessionDatetime: new Date(
        new Date(date.value.toString() + " " + time.value)
      ),
      price: price.value,
      room: room.value,
      movieId: resultSearch.id,
      movieTitle: resultSearch.title,
    }),
  };
  await fetch("https://localhost/movie_screenings", requestOptions)
    .then((response) =>response.json()
    .then((data) => console.log(data))
  );

  await generateSeat(4);


};

const handleChange = (item) => {
  resultSearch.id = item.id;
  resultSearch.title = item.title;
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
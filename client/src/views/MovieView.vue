<script setup>
import { onMounted, reactive, ref, inject, watch } from "vue";
import CardPaymentMovie from "@/components/CardPaymentMovie.vue";

const movie = reactive({ value: {} });
const quantity = reactive({ value: 0 });
const isCurrentUserAdmin = ref(false);
const isCurrentUserUser = ref(false);
const violations = ref([]);
const successMsg = ref([]);
const stock = ref(0);
const itemCount = ref(0);
const availableMovies = ref([]);
const items = reactive({ value: [] });
const price = reactive({ price: null, value: null });
const currentUser = inject("currentUser");
const orderPrice = ref(null);

// TODO: Michael you can get totalCredits like this and display the reduction with it in the template (security is in back as you did ;))
watch(currentUser, () => {
  console.log(currentUser?.totalCredits);
});

const getPrice = async () => {
  const id = new URLSearchParams(location.search).get("id");
  const response = await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/movies/${id}`
  );

  if (response.status === 404) {
    return null;
  }

  const movie = await response.json();
  return movie.price;
};

const getMovieInstances = async () => {
  const id = new URLSearchParams(location.search).get("id");
  const movieInstancesRes = await fetch(
    `${
      import.meta.env.VITE_API_SERVER_URL
    }/movie_instances?movie_id=${id}&available=true`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    }
  );
  const movieInstances = await movieInstancesRes.json();
  return movieInstances;
};

onMounted(async () => {
  const id = new URLSearchParams(location.search).get("id");
  if (!id) {
    location.href = "/";
  }
  const data = await fetch(
    `https://api.themoviedb.org/3/movie/${id}?api_key=${
      import.meta.env.VITE_TMDB_API_KEY
    }&lang=fr`
  );
  movie.value = await data.json();
  movie.value.poster = `https://image.tmdb.org/t/p/w500${movie.value.poster_path}`;
  movie.value.background = `https://image.tmdb.org/t/p/w1280${movie.value.backdrop_path}`;
  movie.value.country = movie.value?.production_countries?.[0]?.iso_3166_1;
  movie.value.movieDuration = Math.round(movie.value.runtime / 60);

  const movieInstances = await getMovieInstances();
  availableMovies.value = movieInstances;
  stock.value = movieInstances.length;
  price.value = await getPrice();

  if (currentUser?.roles?.includes("ROLE_ADMIN")) {
    isCurrentUserAdmin.value = true;
  }

  if (currentUser?.roles?.includes("ROLE_USER")) {
    isCurrentUserUser.value = true;
  }
});

const handleSubmitChangeStock = async () => {
  const response = await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/movie_instances`,
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
      body: JSON.stringify({
        movieId: movie.value.id,
        quantity: quantity.value,
        price: price.value,
      }),
    }
  );
  const data = await response.json();

  if (response.status === 201) {
    const movieInstances = await getMovieInstances();
    availableMovies.value = movieInstances;
    stock.value = movieInstances.length;
    successMsg.value = data.success;
  }

  if (response.status === 422) {
    violations.value = data.violations;
  }
};

const setItems = () => {
  const quantity = itemCount.value;
  while (items.value.length) {
    items.value.pop();
  }
  for (let i = 0; i < quantity; i++) {
    items.value.push(availableMovies.value[i]);
  }
};

// watch itemCount
watch(itemCount, () => {
  if (itemCount.value === 0) {
    orderPrice.value = 0;
  } else if (itemCount.value < 0) {
    orderPrice.value = null;
  } else {
    orderPrice.value = price.value * itemCount.value;
  }
});
</script>

<template>
  <div class="movie-view">
    <div
      class="movie-view__background-image"
      :style="{
        'background-image':
          'linear-gradient(to bottom, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 50%, rgba(0,0,0,0) 100%), url(' +
          movie.value.background +
          ')',
      }"
    ></div>
    <div class="movie-view__content">
      <img :src="movie.value.poster" class="movie-view__poster-image" />
      <div class="movie-view__text-content">
        <h1 class="movie-view__title">{{ movie.value.title }}</h1>
        <p class="movie-view__description">{{ movie.value.overview }}</p>
        <p class="movie-view__details">
          <span class="movie-view__release-date"
            >{{ movie.value.release_date }} -
          </span>
          <span class="movie-view__vote-average"
            >noté {{ movie.value.vote_average }}/10 -
          </span>
          <span class="movie-view__country">{{ movie.value.country }} - </span>
          <span class="movie-view__movie-duration"
            >{{ movie.value.movieDuration }}h</span
          >
        </p>
        <p v-if="price.value !== null" class="movie-view__price">
          Prix : {{ price.value }} €
        </p>
        <div
          v-if="isCurrentUserUser && stock === 0"
          class="alert movie-view__alert-danger-dark"
          role="alert"
        >
          <span class="text-center">Le film n'est pas en stock</span>
        </div>
        <div class="bg-dark p-4 rounded" v-if="isCurrentUserAdmin">
          <h3>Gestion du Stock</h3>
          <p>Quantité en stock : {{ stock }}</p>
          <form
            v-if="isCurrentUserAdmin"
            @submit.prevent="handleSubmitChangeStock()"
            class="movie-view__form"
          >
            <div class="form-group">
              <label for="price">Fixer un prix</label>
              <input
                type="number"
                class="form-control"
                step="0.01"
                id="price"
                v-model="price.value"
              />
            </div>
            <div class="form-group">
              <label for="quantity">Ajouter au stock :</label>
              <input
                type="number"
                class="form-control"
                id="quantity"
                v-model="quantity.value"
              />
            </div>
            <input
              type="submit"
              class="btn btn-cinemax-primary"
              value="Valider"
            />
          </form>
          <div
            v-for="msg in successMsg"
            :key="msg"
            v-if="successMsg"
            class="alert movie-view__alert-danger-dark"
          >
            <span>{{ msg }}</span>
          </div>
          <ul v-if="violations.length > 0" class="movie-view__message">
            <li
              v-for="violation in violations"
              :key="violation.propertyPath"
              class="movie-view__violation"
            >
              {{ violation.propertyPath }} : {{ violation.message }}
            </li>
          </ul>
        </div>

        <div
          class="bg-dark mt-4 p-4 rounded"
          v-if="isCurrentUserUser && stock > 0"
        >
          <div class="container" v-if="isCurrentUserUser && stock > 0">
            <h3 class="text-center">Acheter</h3>
            <div class="form-group">
              <span>En stock : {{ stock }}</span
              ><br />
              <label for="item-count">Quantité à acheter</label>
              <input
                @input="setItems"
                type="number"
                class="item-count ml-2"
                min="1"
                :max="stock"
                id="price"
                v-model="itemCount"
              />
            </div>
            <span v-if="orderPrice !== null" class="font-weight-bold"
              >Prix de la commande : {{ orderPrice }} €</span
            ><br />
            <p v-if="orderPrice !== null" class="mb-4">
              Une réduction sera automatiquement ajouté si vous avez gagnés des
              crédits sur votre compte
            </p>
            <CardPaymentMovie
              :items="items.value"
              :price="price"
              url="/movie_instances/buy"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.movie-view {
  position: relative;
  padding-top: 50px;
  display: flex;
}

.movie-view__background-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
}

.movie-view__content {
  position: relative;
  z-index: 1;
  padding: 16px;
  display: flex;
  margin: auto;
}

.movie-view__poster-image {
  min-width: 280px;
  max-width: 720px;
  height: fit-content;
  border-radius: 14px;
}

.movie-view__text-content {
  max-width: 600px;
  padding-left: 16px;
  color: var(--color-grey-white);
}

.movie-view__title {
  font-size: 32px;
  margin-bottom: 8px;
}

.movie-view__description {
  font-size: 18px;
  margin-bottom: 16px;
}

.movie-view__details {
  font-size: 14px;
  color: var(--color-red);
}

.movie-view__input-number {
  width: 55px;
}

.movie-view__form {
  margin-top: 20px;
}

.movie-view__alert-danger-dark {
  margin-top: 20px;
  color: #ea868f !important;
  background-color: #2c0b0e !important;
  border-color: #842029 !important;
}

@media (max-width: 620px) {
  .movie-view__background-image {
    display: none;
  }

  .movie-view__poster-image {
    max-width: 100%;
    max-height: none;
    margin-bottom: 20px;
  }

  .movie-view__text-content {
    padding-left: 0;
  }

  .movie-view__content {
    flex-direction: column;
  }
}
</style>

<script setup>
import { onMounted, reactive } from "vue";

const movie = reactive({ value: {} });
const quantity = reactive({ value: 0 });

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
  movie.value.country = movie.value.production_countries[0].iso_3166_1;
  movie.value.movieDuration = Math.round(movie.value.runtime / 60);
  // TODO: Remove this console.log
  console.log(movie);

  // TODO: fetch number of movies in stock like this ? -->
  //
  // const dataStock = await fetch(
  //   `http://localhost/move_instances?movie_id=${id}`
  // );
  // const stock = await dataStock.json();
  // quantity.value = stock.length;
});

// TODO: Buy movie (move_instances table in database with buyer_id) (but before pay with stripe)
const handleBuyMovie = () => {
  console.log("buy movie with this id", movie.value.id);
};

// TODO: Change stock quantity (move_instances table in database without buyer_id)
const handleSubmitChangeStock = (quantityVal) => {
  console.log("Command this", movie.value.id, quantityVal);
};
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
        <!-- TODO: Check if current user have user role to display this div -->
        <button class="btn btn-cinemax-primary" @click="handleBuyMovie">
          Acheter le film / Précommander
        </button>
        <!-- TODO: Check if current user have admin role to display this form wich call handleSubmitChangeStock -->
        <form
          @submit.prevent="handleSubmitChangeStock(quantity)"
          class="movie-view__form-quantity"
        >
          <label for="quantity">Quantité en stock :</label>
          <input
            type="number"
            id="quantity"
            name="quantity"
            min="1"
            max="100"
            class="movie-view__input-number"
            v-model="quantity.value"
          />
          <input type="submit" value="Ok" />
        </form>
      </div>
    </div>
  </div>
</template>

<style>
.movie-view {
  position: relative;
  height: 95vh;
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

.movie-view__form-quantity {
  display: flex;
  align-items: center;
  align-content: center;
  justify-content: center;
  justify-items: center;
  margin-top: 15px;
}

.movie-view__form-quantity label {
  margin: 0;
}

@media (max-width: 620px) {
  .movie-view__background-image {
    display: none;
  }

  .movie-view__poster-image {
    max-width: 100%;
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

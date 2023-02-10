<template>
  <div>
    <div class="container mt-2">
      <div class="row">
        <div class="col-md-2">
          <div v-if="seats.value.length > 0">
            <div class="card d-flex justify-content-center p-3">
              <div v-for="(seat, i) in seats.value" :key="i">
                <p>x{{ i + 1 }} - place {{ seat.seat }}</p>
              </div>
              <hr />
              Prix TTC : {{ session.price * seats.value.length }} €
            </div>
          </div>
        </div>
        <div class="col-md-10">
          <div class="card card-booking d-flex justify-content-center">
            <div>
              <h3 class="m-3 d-flex justify-content-center">
                Sélectionnez vos places
              </h3>
              <hr />
            </div>
            <div class="d-flex justify-content-center">
              <table class="m-4">
                <tbody>
                  <div>
                    <td v-for="(booking, index) in bookings.value" :key="index">
                      <div
                        style="cursor: pointer"
                        @click="handleSelected(booking)"
                        v-if="!booking.buyerId"
                      >
                        <svg
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M19 9V7C19 5.35 17.65 4 16 4H8C6.35 4 5 5.35 5 7V9C3.35 9 2 10.35 2 12V17C2 18.65 3.35 20 5 20V22H7V20H17V22H19V20C20.65 20 22 18.65 22 17V12C22 10.35 20.65 9 19 9ZM7 7C7 6.45 7.45 6 8 6H16C16.55 6 17 6.45 17 7V9.78C16.39 10.33 16 11.12 16 12V14H8V12C8 11.12 7.61 10.33 7 9.78V7ZM20 17C20 17.55 19.55 18 19 18H5C4.45 18 4 17.55 4 17V12C4 11.45 4.45 11 5 11C5.55 11 6 11.45 6 12V16H18V12C18 11.45 18.45 11 19 11C19.55 11 20 11.45 20 12V17Z"
                            fill="#DB0000"
                          />
                        </svg>
                      </div>

                      <div v-else>
                        <svg
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          xmlns="http://www.w3.org/2000/svg"
                        >
                          <path
                            d="M19 9V7C19 5.35 17.65 4 16 4H8C6.35 4 5 5.35 5 7V9C3.35 9 2 10.35 2 12V17C2 18.65 3.35 20 5 20V22H7V20H17V22H19V20C20.65 20 22 18.65 22 17V12C22 10.35 20.65 9 19 9ZM7 7C7 6.45 7.45 6 8 6H16C16.55 6 17 6.45 17 7V9.78C16.39 10.33 16 11.12 16 12V14H8V12C8 11.12 7.61 10.33 7 9.78V7ZM20 17C20 17.55 19.55 18 19 18H5C4.45 18 4 17.55 4 17V12C4 11.45 4.45 11 5 11C5.55 11 6 11.45 6 12V16H18V12C18 11.45 18.45 11 19 11C19.55 11 20 11.45 20 12V17Z"
                            fill="#b2b2b2"
                          />
                        </svg>
                      </div>
                    </td>
                  </div>
                </tbody>
              </table>
            </div>
            <div
              class="d-flex justify-content-center"
              v-if="seats.value.length > 0"
            >
              <button
                @click="() => (display = true)"
                class="btn mt-4 btn-cinemax"
              >
                <span>Réserver ma place </span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <CardPayment
      class="mt-3"
      v-if="display"
      :price="price"
      :items="seats.value"
      url="/booking/payment"
      :session="session"
    />
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import CardPayment from "./CardPayment.vue";

const session = ref(null);
const bookings = reactive({ value: [] });
const seats = reactive({ value: [] });
const price = reactive({ price: 0 });
const display = ref(false);

onMounted(async () => {
  const id = new URLSearchParams(location.search).get("id");
  if (!id) {
    location.href = "/";
  }
  await fetchSession(id);

  if (
    session.value.id == null ||
    new Date(session.value.session_datetime) < new Date()
  ) {
    location.href = "/";
  }

  await fetchBookings();
  bookings.value = bookings.value.filter(
    (e, i) => e.session_id == `/movie_screenings/${id}`
  );
});

const fetchSession = async (id) => {
  return fetch(`${import.meta.env.VITE_API_SERVER_URL}/movie_screenings/${id}`)
    .then((response) => response.json())
    .then((data) => (session.value = data));
};

const fetchBookings = async () => {
  return fetch(`${import.meta.env.VITE_API_SERVER_URL}/bookings/`)
    .then((response) => response.json())
    .then((data) => (bookings.value = data["hydra:member"]));
};

const handleSelected = (booking) => {
  const found = seats.value.findIndex((e) => e.id == booking.id);
  if (found != -1) {
    seats.value.splice(found, 1);
  } else {
    seats.value.push(booking);
  }

  if (seats.value.length == 0) {
    display.value = false;
  }
  price.price = session.value.price * seats.value.length;
};
</script>

<style scoped>
.btn-cinemax {
  background-color: var(--color-red);
  color: var(--color-white);
  text-align: center;
  width: 100%;
  height: 50px;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
a:hover {
  background-color: lightgrey;
}
</style>

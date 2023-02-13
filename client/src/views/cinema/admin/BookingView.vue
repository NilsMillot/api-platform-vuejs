<template>
  <div>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-9">
          <div class="card card-booking d-flex justify-content-center">
            <div>
              <h3 class="m-3 d-flex justify-content-center">
                Les places réservées
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
          </div>
        </div>
        <div class="col-md-3"></div>
      </div>

      <div class="row mt-5">
        <div class="col-md-2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Places disponibles</h5>
              <p class="card-text">
                {{ seatAvailable }}
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-2">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Places réservées</h5>
              <p class="card-text">
                {{ seatReserved }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, reactive } from "vue";
import { useRoute, useRouter } from "vue-router";

const $route = useRoute();
const session = ref(null);
const bookings = reactive({ value: [] });
let seatReserved = ref(0);
let seatAvailable = ref(0);

onMounted(async () => {
  await fetchSession($route.params.id);
  if (
    session.value.id == null ||
    new Date(session.value.session_datetime) < new Date()
  ) {
    location.href = "/";
  }
  await fetchBookings($route.params.id);
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
      session.value = data;
    })
  );
};

const fetchBookings = async (id) => {
  const requestOptions = {
    method: "GET",
    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}`,
    },
  };
  await fetch(
    `${import.meta.env.VITE_API_SERVER_URL}/seats/${id}`,
    requestOptions
  ).then((response) =>
    response.json().then((data) => {
      bookings.value = data.data;
      seatReserved.value = data.data.filter((x) => x.buyer_id != null).length;
      seatAvailable.value = data.data.filter((x) => x.buyer_id == null).length;
    })
  );
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

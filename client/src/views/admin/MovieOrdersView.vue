<template>
  <div class="container">
    <div>
      <h2 class="pt-2">Commandes de films</h2>
      <hr class="pb-5" />
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table pt-10 tab" v-if="!shouldOfuscate">
          <thead>
          <tr>
            <th scope="col">EMAIL ACHETEUR</th>
            <th scope="col">NOM DU FILM</th>
            <th scope="col">QUANTITE</th>
            <th scope="col">PRIX</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="movieOrder in movieOrders" :key="movieOrder.id">
            <td>{{ movieOrder.buyer.email }}</td>
            <td>{{ movieOrder.movieName }}</td>
            <td>{{ movieOrder.quantity }}</td>
            <td>{{ movieOrder.price }} €</td>
          </tr>
          </tbody>
        </table>
        <h1 v-if="shouldOfuscate">Vous n'avez pas accès à cette page</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, inject, reactive, ref, watchEffect} from "vue";
import router from "@/router";
const currentUser = inject("currentUser");
const shouldOfuscate = ref(true);
const movieOrders = ref([]);

if (!localStorage.getItem("token")) {
  router.push("/");
}

watchEffect(() => {
  if (currentUser) {
    if (currentUser.roles?.includes("ROLE_ADMIN")) {
      shouldOfuscate.value = false;
    } else if (
        currentUser.roles?.includes("ROLE_USER") ||
        currentUser.roles?.includes("ROLE_CINEMA")
    ) {
      router.push("/");
    }
  } else {
    router.push("/");
  }
});

onMounted(async () => {
  const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/movie_orders`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
  );
  if (response.status !== 200) {
    location.href = "/";
  } else {
    shouldOfuscate.value = false;
  }

  const movieOrdersFetched = await response.json();
  movieOrders.value = movieOrdersFetched["hydra:member"];
});

</script>

<style scoped>
.container {
  color: white;
}

.tab {
  background-color: #2f2f2f;
  color: white;
  padding: 200px !important;
}
label {
  padding-left: 5px;
  font-size: 12px;
}
.actionsButtons {
  display: inline-flex;
  justify-content: space-between;
}
.btn-cinemax {
  background-color: var(--color-red);
  color: var(--color-white);
  text-align: center;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
</style>

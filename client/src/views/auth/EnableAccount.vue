<script setup>
import { onMounted, ref } from "vue";
import { useRoute } from "vue-router";
const isErrorOnFetch = ref(true);

onMounted(async () => {
  const { params } = useRoute();
  const { id } = params;
  const token = new URLSearchParams(window.location.search).get("token");

  await enableAccount(id, token);
});
const enableAccount = async (id, token) => {
  return fetch(`${import.meta.env.VITE_API_SERVER_URL}/enable_account/${id}`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ token: token }),
  }).then((response) => {
    if (response.status == 200) {
      isErrorOnFetch.value = false;
    }
  });
};
</script>

<template>
  <div class="enable-account-vue_background">
    <div class="card card-enable-account shadow-sm">
      <div class="text-center pt-3" v-if="isErrorOnFetch">
        <h2 class="text-center">Zut!</h2>
        <p class="text-center">
          Le token que vous nous donnez n'est pas valide. Veuillez vérifier vos
          mails ou tentez de vous connecter 😪.
        </p>
      </div>
      <div class="text-center pt-3" v-else>
        <h2 class="text-center">Compte activé</h2>
        <p class="text-center">
          Votre compte a été activé. Vous pouvez vous connecter.
        </p>
      </div>
      <div class="d-flex justify-content-center">
        <router-link to="/login" class="btn mt-4 btn-cinemax"
          >Me connecter</router-link
        >
      </div>
    </div>
  </div>
</template>

<style scoped>
.card-enable-account {
  width: 450px;
  margin: 150px auto auto;
  margin-top: 150px;
  padding: 20px;
  background-color: var(--color-black);
  color: var(--color-white);
  border-radius: 10px;
}
.btn-cinemax {
  background-color: var(--color-red);
  color: var(--color-white);
  text-align: center;
  width: 100%;
}
.btn-cinemax:hover {
  background-color: var(--color-darkred);
  color: var(--color-white);
}
.enable-account-vue_background {
  display: flex;
  background-image: linear-gradient(rgba(0, 0, 0, 0.604), rgba(0, 0, 0, 0.649)),
    url("../../assets/background.jpeg");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  height: 96vh;
}
</style>

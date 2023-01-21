<script setup>
import { ref } from "vue";

const email = ref(null);
const sent = ref(false);

const handleSubmitForm = async (e) => {
  e.preventDefault();
  sent.value = true;
  // TODO: Call the API to send forgot password email
  console.log(email.value);

  setTimeout(() => {
    sent.value = false;
  }, 3000);
};
</script>
<template>
  <div class="forgetpassword_background">
    <div class="card card-forgetPassword shadow-sm">
      <div class="text-center">
        <h3 class="pt-3">Réinitialisation du mot de passe</h3>
      </div>
      <div class="card-body">
        <form
          class="d-flex flex-column justify-content-center"
          @submit="handleSubmitForm"
        >
          <div class="form-group">
            <input
              type="email"
              placeholder="E-mail"
              name="email"
              id="inputForgetMail"
              class="form-control"
              v-model="email"
              autocomplete="email"
              required
              autofocus
            />
          </div>
          <div class="d-flex justify-content-center">
            <span
              class="spinner-border spinner-border-sm"
              role="status"
              aria-hidden="true"
              v-show="sent"
              style="margin-top: 40px"
            ></span>
            <button class="btn mt-4 btn-cinemax" type="submit" v-show="!sent">
              <span>Envoyer</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card-forgetPassword {
  width: 450px;
  margin: 150px auto auto;
  padding: 20px;
  height: 285px;
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
#inputForgetMail {
  background-color: #ffffff30;
  color: var(--color-white);
  border: none;
}
.forgetpassword_background {
  display: flex;
  background-image: linear-gradient(rgba(0, 0, 0, 0.604), rgba(0, 0, 0, 0.649)),
    url("https://wallpaper.dog/large/20493433.jpg");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  height: 96vh;
}
</style>

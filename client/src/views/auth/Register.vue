<script setup>
import { reactive, ref } from "vue";

const formInputs = reactive({
  name: "",
  email: "",
  password: "",
  passwordConfirm: "",
});

const errorMessage = ref(null);

const handleSubmitForm = async (e) => {
  e.preventDefault();
  const requestData = {
    name: formInputs.name,
    email: formInputs.email,
    password: formInputs.password,
    adress: "Pas d'adresse",
    isCinema: false,
    status: 'Aucun'
  };

  fetch(`${import.meta.env.VITE_API_SERVER_URL}/signup`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(requestData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
    });
};
</script>

<template>
  <div class="register-vue_background">
    <div class="card card-register shadow-sm">
      <div class="text-center">
        <h3 class="pt-3">S'inscrire</h3>
      </div>
      <div class="card-body">
        <form
          class="d-flex flex-column justify-content-center"
          @submit="handleSubmitForm"
        >
          <div class="form-group">
            <input
              type="name"
              placeholder="Nom"
              name="email"
              id="inputMail"
              class="form-control"
              v-model="formInputs.name"
              autocomplete="email"
              required
              autofocus
            />
          </div>
          <div class="form-group">
            <input
              type="email"
              placeholder="E-mail"
              name="email"
              id="inputMail"
              class="form-control"
              v-model="formInputs.email"
              autocomplete="email"
              required
              autofocus
            />
          </div>
          <div class="form-group">
            <input
              type="password"
              placeholder="Mot de passe"
              name="password"
              id="inputPwd"
              class="form-control"
              v-model="formInputs.password"
              autocomplete="current-password"
              required
            />
          </div>
          <div class="form-group">
            <input
              type="password"
              placeholder="Confirmation de mot de passe"
              name="password"
              id="inputPwd"
              class="form-control"
              v-model="formInputs.passwordConfirm"
              autocomplete="current-password"
              required
            />
          </div>
          <span>{{ errorMessage }}</span>
          <div class="d-flex justify-content-center">
            <button class="btn mt-4 btn-cinemax" type="submit">
              <span>S'inscrire</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card-register {
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
#inputMail {
  background-color: #ffffff30;
  color: var(--color-white);
  border: none;
}
#inputPwd {
  background-color: #ffffff30;
  color: var(--color-white);
  border: none;
}
#forgetPassword {
  font-size: 12px;
  margin-top: 20px;
  color: #ffffff95;
}
.register-vue_background {
  display: flex;
  background-image: linear-gradient(rgba(0, 0, 0, 0.604), rgba(0, 0, 0, 0.649)),
    url("../../assets/background.jpeg");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  height: 96vh;
}
</style>

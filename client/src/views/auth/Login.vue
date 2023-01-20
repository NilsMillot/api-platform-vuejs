<script setup>
import { reactive } from "vue";

const formInputs = reactive({
  email: "",
  password: "",
});

const handleSubmitForm = async (e) => {
  e.preventDefault();
  // TODO: Pass the localhost to the env variable
  const response = await fetch("https://localhost/auth", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(formInputs),
  });
  const data = await response.json();
  console.log(data);
  if (data.token) {
    localStorage.setItem("token", data.token);
    alert("Vous êtes connecté !");
    location.href = "/";
  } else if (data.error) {
    alert(data.error);
  }
};
</script>

<template>
  <div>
    <div class="card card-login shadow-sm">
      <div class="text-center">
        <h3 class="pt-3">S'identifier</h3>
      </div>
      <div class="card-body">
        <!-- Same with utilisation of reactive formInputs and the function handleSubmitForm -->
        <form
          class="d-flex flex-column justify-content-center"
          @submit="handleSubmitForm"
        >
          <div class="form-group">
            <input
              type="email"
              placeholder="E-mail"
              name="email"
              id="inputEmail"
              class="form-control"
              autocomplete="email"
              required
              autofocus
              v-model="formInputs.email"
            />
          </div>
          <div class="form-group">
            <input
              type="password"
              placeholder="Mot de passe"
              name="password"
              id="inputPassword"
              class="form-control"
              autocomplete="current-password"
              required
              v-model="formInputs.password"
            />
          </div>
          <div class="d-flex justify-content-center">
            <button class="btn mt-4 btn-cinemax" type="submit">
              <span>S'identifier</span>
            </button>
          </div>
          <a href="/forget-password" id="forgetPassword"
            >Mot de passe oublié ?</a
          >
          <div class="link-register">
            <p id="register-text">Première visite sur CINEMAX ?</p>
            <a href="/register" id="register">Inscrivez-vous</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card-login {
  width: 450px;
  margin: 0 auto;
  margin-top: 150px;
  padding: 20px;
  background-color: var(--color-black);
  color: var(--color-white);
  box-shadow: 20px;
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
#inputEmail {
  background-color: #ffffff30;
  color: var(--color-white);
  border: none;
}
#inputPassword {
  background-color: #ffffff30;
  color: var(--color-white);
  border: none;
}
#forgetPassword {
  font-size: 12px;
  margin-top: 20px;
  color: #ffffff95;
}
/* body{
    background-image: linear-gradient(rgba(0, 0, 0, 0.604), rgba(0, 0, 0, 0.649)),url("../../assets/films-montage.jpeg") !important;
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
} */
.link-register {
  margin-top: 50px;
  display: flex;
  flex-direction: row;
  align-items: baseline;
}
#register-text {
  font-size: 14px;
  color: #ffffff72;
}
#register {
  font-size: 13px;
  color: var(--color-white);
  padding-left: 5px;
}
</style>

<script setup>
import {onMounted, reactive, ref} from "vue";
import router from "@/router";

const formInputs = reactive({
  email: "",
  password: "",
});

const message = ref(null);

const handleSubmitForm = async (e) => {
  e.preventDefault();
  const response = await fetch(`${import.meta.env.VITE_API_SERVER_URL}/auth`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(formInputs),
  });
  const data = await response.json();

  if (data.token) {
    message.value = null;
    localStorage.setItem("token", data.token);
    await router.push("/");
  } else if (data.message) {
    message.value = data.message;
  } else if (data.error) {
    message.value = data.error;
  }
};

onMounted(() => {
  const signupMessage = router.currentRoute.value.query.message;
  message.value = signupMessage;
});
</script>

<template>
  <div class="login-vue_background">
    <div class="card card-login shadow-sm">
      <div class="text-center">
        <h3 class="pt-3">S'identifier</h3>
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
          <span>{{ message }}</span>
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
  margin: 150px auto auto;
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
.login-vue_background {
  display: flex;
  background-image: linear-gradient(rgba(0, 0, 0, 0.604), rgba(0, 0, 0, 0.649)),
    url("../../assets/background.jpeg");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
  height: 96vh;
}
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

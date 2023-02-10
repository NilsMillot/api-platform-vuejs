<script setup>
import { reactive, ref } from "vue";
import router from "@/router";

const formInputs = reactive({
  password: "",
  passwordConfirm: "",
});

const violations = ref([]);

const handleSubmitForm = async (e) => {
  e.preventDefault();

  const requestData = {
    resetPasswordToken: router.currentRoute.value.query['reset_password_token'],
    password: formInputs.password,
    passwordConfirm: formInputs.passwordConfirm
  };

  const response = await fetch(`${import.meta.env.VITE_API_SERVER_URL}/reset_password`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(requestData),
  })

  if (response.status === 200) {
    violations.value = [];
    await router.push({
      name: "login",
      query: { message: "Votre mot de passe a été mis à jour, vous pouvez vous connecter" },
    });
  }

  if (response.status === 422) {
    const data = await response.json();
    violations.value = data.violations;
  }

  if (response.status === 404) {
    const data = await response.json();
    violations.value = [{ propertyPath: "user", message: data.error }];
  }
};
</script>

<template>
  <div class="register-vue_background">
    <div class="card card-register shadow-sm">
      <div class="text-center">
        <h3 class="pt-3">Nouveau mot de passe</h3>
      </div>
      <div class="card-body">
        <form
          class="d-flex flex-column justify-content-center"
          @submit="handleSubmitForm"
        >
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
          <div v-if="violations.length > 0">
            <ul>
              <li v-for="violation in violations" :key="violation">
                {{ violation.propertyPath }} : {{ violation.message }}
              </li>
            </ul>
          </div>
          <div class="d-flex justify-content-center">
            <button class="btn mt-4 btn-cinemax" type="submit">
              <span>Valider</span>
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

<template>
    <div class="card card-user shadow-sm">
      <div class="text-center">
        <h3 class="pt-3">Utilisateur</h3>
      </div>
      <div class="card-body">
        <form class="d-flex flex-column justify-content-center" @submit.prevent="handleSubmitForm">
          <div class="form-group">
            <input
              type="text"
              placeholder="Nom"
              class="form-control"
              required
              autofocus
            />
          </div>
          <div class="form-group">
            <input
              type="text"
              placeholder="Adresse"
              class="form-control"
              required
              autofocus
            />
          </div>
          <div class="form-group">
            <input
              type="email"
              placeholder="E-mail"
              class="form-control"
              required
              autofocus
            />
          </div>
          <div class="d-flex justify-content-center">
            <button class="btn mt-4 btn-cinemax" type="submit">
              <span>Enregistrer</span>
            </button>
          </div>
        </form>
      </div>
    </div>
</template>

<style scoped>
.card-user {
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

input {
  background-color: #ffffff30;
  color: var(--color-white);
  border: none;
}
</style>

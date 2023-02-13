<script setup>
import { computed, onMounted, reactive, ref, watch, watchEffect } from "vue";

const props = defineProps({
  items: Object,
  price: Object,
  url: String,
});
onMounted(() => {
  price.value = props.price;
  items.value = props.items;
});
watch(props.price, (newPrice) => {
  price.value = newPrice;
});

watch(props.items, (newItems) => {
  console.log(newItems)
  items.value = newItems;
});

const cardName = ref("");
const cardNumber = ref("");
const cardMonth = ref("");
const cardYear = ref("");
const cardCvv = ref("");
const minCardYear = ref(new Date().getFullYear());
const $index = ref(0);
const error = ref(null);
const modeLoading = ref(false);

const price = ref("");
const items = reactive({ value: [] });
const isSending = ref(false);
const minCardMonth = computed(() => {
  if (cardYear.value === minCardYear.value) return new Date().getMonth() + 1;
  return 1;
});

watchEffect(() => {
  if (!/^\d*$/.test(cardNumber.value)) {
    cardNumber.value = cardNumber.value.slice(0, -1);
  }

  if (/\d/.test(cardName.value)) {
    cardName.value = cardName.value.slice(0, -1);
  }

  if (!/^\d*$/.test(cardCvv.value)) {
    cardCvv.value = cardCvv.value.slice(0, -1);
  }
});

function handlePay() {
  isSending.value = true;
  modeLoading.value = true;
  error.value = null;

  const request = new Request(
    `${import.meta.env.VITE_API_SERVER_URL}` + props.url,
    {
      method: "POST",
      body: JSON.stringify({
        cardNumber: cardNumber.value,
        cardName: cardName.value,
        cardMonth: cardMonth.value,
        cardYear: cardYear.value,
        cardCvv: cardCvv.value,
        price: price.value.value * items.value.length,
        items: items.value,
      }),
      headers: {
        "Content-Type": "application/json",
        "Authorization": `Bearer ${localStorage.getItem("token")}`,
      },
    }
  );

  fetch(request)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      modeLoading.value = false;
      if (data.message === "success") {
        isSending.value = false;
        location.href = "/payment/success";
      } else {
        if (data["hydra:title"] === 'An error occurred') {
          error.value = "Une erreur est survenue, la commande n'est pas passé";
        } else {
          error.value = data.message;
        }
        isSending.value = false;
      }
    });
}
</script>

<template>
  <main>
    <div class="container">
      <div class="is-flex is-justify-content-center">
        <div class="wrapper">
          <div class="card-form">
            <form @submit.prevent="handlePay">
              <div class="card-form__inner">
                <div class="card-input">
                  <label for="idCardNumber" class="card-input__label"
                    >Numéro de la carte</label
                  >
                  <input
                    type="text"
                    id="idCardNumber"
                    class="card-input__input"
                    v-model="cardNumber"
                    data-ref="idCardNumber"
                    autocomplete="off"
                  />
                </div>
                <div class="card-input">
                  <label for="idCardName" class="card-input__label"
                    >Titulaire de la carte</label
                  >
                  <input
                    type="text"
                    id="idCardName"
                    class="card-input__input"
                    v-model="cardName"
                    data-ref="idCardName"
                  />
                </div>
                <div class="card-form__row">
                  <div class="card-form__col">
                    <div class="card-form__group">
                      <label for="cardMonth" class="card-input__label"
                        >Date d'expiration</label
                      >
                      <select
                        class="card-input__input -select"
                        id="cardMonth"
                        v-model="cardMonth"
                        data-ref="cardDate"
                      >
                        <option value="" disabled selected>Mois</option>
                        <option
                          v-bind:value="n < 10 ? '0' + n : n"
                          v-for="n in 12"
                          v-bind:disabled="n < minCardMonth"
                          v-bind:key="n"
                        >
                          {{ n < 10 ? "0" + n : n }}
                        </option>
                      </select>
                      <select
                        class="card-input__input -select"
                        id="cardYear"
                        v-model="cardYear"
                        data-ref="cardDate"
                      >
                        <option value="" disabled selected>Année</option>
                        <option
                          v-bind:value="$index + minCardYear"
                          v-for="(n, $index) in 12"
                          v-bind:key="n"
                        >
                          {{ $index + minCardYear }}
                        </option>
                      </select>
                    </div>
                  </div>
                  <div class="card-form__col -cvv">
                    <div class="card-input">
                      <label for="cardCvv" class="card-input__label">CVC</label>
                      <input
                        type="text"
                        class="card-input__input"
                        id="cardCvv"
                        maxlength="3"
                        v-model="cardCvv"
                        autocomplete="off"
                      />
                    </div>
                  </div>
                </div>

                <p v-if="error" class="error-message">
                  {{ error }}
                </p>

                <button
                  v-bind:class="{ 'is-loading': modeLoading, 'disabled-button': items.value.length === 0 }"
                  class="card-form-button"
                  type="submit"
                  :disabled="isSending || items.value.length === 0"
                >
                  <span v-show="!isSending">Acheter</span>
                  <span
                    v-show="isSending"
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                  ></span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style>
.card-form {
  max-width: 570px;
  margin: auto;
  width: 100%;
}

@media screen and (max-width: 576px) {
  .card-form {
    margin: 0 auto;
  }
}

.card-form__inner {
  background: #fff;
  box-shadow: 0 30px 60px 0 rgba(90, 116, 148, 0.4);
  border-radius: 10px;
  padding: 35px;
  padding-top: 60px;
}

@media screen and (max-width: 480px) {
  .card-form__inner {
    padding: 25px;
    padding-top: 165px;
  }
}

@media screen and (max-width: 360px) {
  .card-form__inner {
    padding: 15px;
    padding-top: 165px;
  }
}

.card-form__row {
  display: flex;
  align-items: flex-start;
}

@media screen and (max-width: 480px) {
  .card-form__row {
    flex-wrap: wrap;
  }
}

.card-form__col {
  flex: auto;
  margin-right: 35px;
}

.card-form__col:last-child {
  margin-right: 0;
}

@media screen and (max-width: 480px) {
  .card-form__col {
    margin-right: 0;
    flex: unset;
    width: 100%;
    margin-bottom: 20px;
  }

  .card-form__col:last-child {
    margin-bottom: 0;
  }
}

.card-form__col.-cvv {
  max-width: 150px;
}

@media screen and (max-width: 480px) {
  .card-form__col.-cvv {
    max-width: initial;
  }
}

.card-form__group {
  display: flex;
  align-items: flex-start;
  flex-wrap: wrap;
}

.card-form__group .card-input__input {
  flex: 1;
  margin-right: 15px;
}

.card-form__group .card-input__input:last-child {
  margin-right: 0;
}

.card-form-button {
  width: 100%;
  height: 55px;
  background-color: var(--color-red);
  border: none;
  border-radius: 5px;
  font-size: 22px;
  color: #fff !important;
  margin-top: 20px;
  cursor: pointer;
}

@media screen and (max-width: 480px) {
  .card-form-button {
    margin-top: 10px;
  }
}

.card-list {
  margin-bottom: -130px;
}

@media screen and (max-width: 480px) {
  .card-list {
    margin-bottom: -120px;
  }
}

.card-input {
  margin-bottom: 20px;
}

.card-input__label {
  font-size: 14px;
  margin-bottom: 5px;
  font-weight: 500;
  color: #1a3b5d;
  width: 100%;
  display: block;
  user-select: none;
}

.card-input__input {
  width: 100%;
  height: 50px;
  border-radius: 5px;
  box-shadow: none;
  border: 1px solid #ced6e0;
  transition: all 0.3s ease-in-out;
  font-size: 18px;
  padding: 5px 15px;
  background: none;
  color: #1a3b5d;
  font-family: "Source Sans Pro", sans-serif;
}

.error-message {
  color: var(--color-red) !important;
}

.disabled-button {
  background-color: #ced6e0 !important;
  cursor: not-allowed !important;
}
</style>

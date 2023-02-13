<template>
  <div v-if="!shouldOfuscate">
    <HeaderBanner title="Séances" img="../../src/assets/cinema.jpeg" />
    <List />
  </div>
</template>

<script setup>
import HeaderBanner from "../../../components/HeaderBanner.vue";
import List from "../../../components/admin/session/List.vue";
import { inject, watchEffect, ref } from "vue";

const shouldOfuscate = ref(true);
const currentUser = inject("currentUser");

if (!localStorage.getItem("token")) {
  location.href = "/";
}

watchEffect(() => {
  if (currentUser) {
    if (currentUser.roles?.includes("ROLE_ADMIN")) {
      shouldOfuscate.value = false;
    } else if (
      currentUser.roles?.includes("ROLE_USER") ||
      currentUser.roles?.includes("ROLE_CINEMA")
    ) {
      location.href = "/";
    }
  } else {
    location.href = "/";
  }
});
</script>

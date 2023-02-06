<template>
  <div class="banner">
    <div
      class="bannerContent"
      v-bind:style="{
        'background-image': 'url(' + props.img + ')',
      }"
    >
      <h1>{{ props.title }}</h1>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  title: String,
  img: String,
});
</script>

<style scoped>
.banner {
  height: 300px;
  color: var(--color-white);
}

.bannerContent {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  padding-left: 30px;
  height: 100%;
  background-position: center;
  background-size: cover;
}

.bannerContent h1 {
  text-transform: uppercase;
  font-size: 2em;
  font-weight: 800;
  margin: 0;
}

.bannerContent h3 {
  font-size: 1.1em;
  width: 25rem;
}
</style>

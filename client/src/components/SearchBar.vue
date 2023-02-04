<template>
  <div class="container input-group mb-3">
    <input
      @input="$emit('customEvent', $event)"
      type="text"
      class="form-control input-search"
      :placeholder="props.placeholder"
    />
  </div>
</template>

<script setup>
const props = defineProps({
  placeholder: String,
});

const emit = defineEmits({
  customEvent: true,
});
</script>

<style scoped>
.input-search {
  border-radius: 15px;
  border: 1px solid var(--color-black);
  padding-left: 2em;
  background-color: #ffffff30;
}
</style>

<template>
 
</template>

<script setup>

onMounted(async () => {
  await fetchQuestions();
});


const fetchQuestions = async () => {
  try {
    const response = await fetch(
      `${import.meta.env.VITE_API_SERVER_URL}/questions`,
      {
        method: "GET",
        headers: {
          Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
      }
    );
    if (response.ok) {
      const data = await response.json();
      questions.value = data["hydra:member"];
    } else {
      const data = await response.json();
      console.log(data);
      throw new Error("Erreur");
    }
  } catch (error) {
    console.log(error);
  }
};

</script>

<style scoped>

</style>
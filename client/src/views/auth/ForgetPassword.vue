<template>
    <div>
            <div class="card card-login shadow-sm">
                <div class="text-center">
                    <h3 class="pt-3">Réinitialisation du mot de passe</h3>
                </div>
                <div class="card-body">
                    <form class="d-flex flex-column justify-content-center">
                        <div class="form-group">
                            <input type="email" placeholder="E-mail" name="email" id="inputEmail" class="form-control" v-model="email" autocomplete="email" required autofocus>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn mt-4 btn-cinemax" type="submit"><span>Valider</span></button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

</template>

<script setup>

</script>

<style scoped>

</style>
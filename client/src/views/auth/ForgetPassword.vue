<template>
    <div>
            <div class="card card-forgetPassword shadow-sm">
                <div class="text-center">
                    <h3 class="pt-3">Réinitialisation du mot de passe</h3>
                </div>
                <div class="card-body">
                    <form class="d-flex flex-column justify-content-center">
                        <div class="form-group">
                            <input type="email" placeholder="E-mail" name="email" id="inputForgetMail" class="form-control" v-model="email" autocomplete="email" required autofocus>
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
.card-forgetPassword {
            width: 450px;
            margin: 0 auto;
            margin-top: 150px;
            padding: 20px;
            background-color: var(--color-black);
            color: var(--color-white);
            box-shadow: 20px;
            
        }
        .btn-cinemax{
            background-color: var(--color-red);
            color:var(--color-white);
            text-align: center;
            width: 100%;
        }
        .btn-cinemax:hover{
            background-color: var(--color-darkred);
            color: var(--color-white)
        }
       #inputForgetMail{
            background-color: #ffffff30;
            color: var(--color-white);
            border: none;
       }
</style>
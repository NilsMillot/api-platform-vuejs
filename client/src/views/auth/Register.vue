<template>
    <div>
            <div class="card card-register shadow-sm">
                <div class="text-center">
                    <h3 class="pt-3">S'inscrire</h3>
                </div>
                <div class="card-body">
                    <form class="d-flex flex-column justify-content-center">
                        <div class="form-group">
                            <input type="name" placeholder="Nom" name="email" id="inputMail" class="form-control" v-model="name" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="E-mail" name="email" id="inputMail" class="form-control" v-model="email" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Mot de passe" name="password" id="inputPwd" class="form-control" v-model="password" autocomplete="current-password" required>
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Confirmation de mot de passe" name="password" id="inputPwd" class="form-control" v-model="passwordConfirm" autocomplete="current-password" required>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn mt-4 btn-cinemax" type="submit"><span>S'inscrire</span></button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
       .card-register {
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
       #inputMail{
            background-color: #ffffff30;
            color: var(--color-white);
            border: none;
       }
       #inputPwd{
            background-color: #ffffff30;
            color: var(--color-white);
            border: none;
       }
       #forgetPassword {
            font-size: 12px;
            margin-top: 20px;
            color: #ffffff95;
       }
</style>



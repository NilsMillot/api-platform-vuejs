<template>
    <div class="">
            <div class="card card-login shadow-sm">
                <div class="text-center">
                    <h3 class="pt-3" >S'identifier</h3>
                </div>
                <div class="card-body">
                    <form class="d-flex flex-column justify-content-center">
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" placeholder="Votre email" name="email" id="inputEmail" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Mot de Passe</label>
                            <input type="password" name="password" id="inputPassword" class="form-control" v-model="password" autocomplete="current-password" required>
                        </div>
                        <a href="#" id="forgetPassword">Mot de passe oublié ?</a>
                        <p>Première visite sur cinemax?</p><a href="/register" id="register">Inscrivez-vous</a>
                        <div class="d-flex justify-content-center">
                            <button class="btn mt-4 btn-cinemax" type="submit">S'identifier</button>
                        </div>

                    </form>
                </div>
            </div>
    </div>

  
</template>

<script setup>

</script>

<style >
        .card-login {
            width: 400px;
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
        }
        .btn-cinemax:hover{
            background-color: var(--color-darkred);
            color: var(--color-white)
        }
       #inputEmail{
            background-color: var(--color-grey);
            color: var(--color-white);
            border: none;
       }
       #inputPassword{
            background-color: var(--color-grey);
            color: var(--color-white);
            border: none;
       }
       #forgetPassword {
            font-size: 10px;
            padding-left: 20px;
       }
       body{
            background-image: linear-gradient(rgba(0, 0, 0, 0.604), rgba(0, 0, 0, 0.649)),url("../../assets/films-montage.jpeg") !important;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;

       }
</style>



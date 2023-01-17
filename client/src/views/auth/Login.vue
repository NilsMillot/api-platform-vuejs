<template>
    <div>
            <div class="card card-login shadow-sm">
                <div class="text-center">
                    <h3 class="pt-3" >Connexion</h3>
                </div>
                <div class="card-body">
                    <form method="post"
                            class="d-flex flex-column justify-content-center">

                        <label for="inputEmail">Email</label>
                        <input type="email" name="email" id="inputEmail" class="form-control" v-model="email" autocomplete="email" required autofocus>
                        <label for="inputPassword">Password</label>
                        <input type="password" name="password" id="inputPassword" class="form-control" v-model="password" autocomplete="current-password" required>

                        <div class="d-flex justify-content-center">
                            <button class="btn mt-4 btn-cinemax" type="submit">Connexion</button>
                        </div>

                    </form>
                </div>
            </div>
    </div>

  
</template>

<script setup>

</script>

<style scoped>
        .card-login {
            width: 500px;
            margin: 0 auto;
            margin-top: 200px;
            padding: 20px;
            background-color: #F5F5F5;
            
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
       input{
           margin-bottom: 20px;
       }
</style>



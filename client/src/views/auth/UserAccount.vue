<template>
    <div>
            <div class="card card-account shadow-sm">
                <div>
                    <h3 class="pt-3">Mon compte</h3>
                    <hr>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <label for="name">Mon nom :</label>
                            <input type="name" placeholder="E-mail" name="email" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="address">Mon adresse :</label>
                            <input type="email" placeholder="E-mail" name="email" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="email">Mon adresse e-mail : </label>
                            <input type="email" placeholder="E-mail" name="email" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">Mon mot de passe :</label>
                            <input type="email" placeholder="E-mail" name="email" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn mt-4 btn-cinemax" type="submit"><span>Modifier</span></button>
                        </div>  
                </div>
            </div>
    </div>
</template>

<script setup>

import { onMounted } from 'vue';    
onMounted(async () => {
        await fetchUser()
    })
    const fetchUser = async () => {
        return fetch('https://localhost/users/1')
            .then(response => response.json())
            .then(data => {
                console.log(data)
            })
    }
</script>

<style scoped>
.card-account {
            width: 80%;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            background-color: #f3f3f3;
            color: var(--color-black);
            box-shadow: 20px;
            
        }
        .btn-cinemax:hover{
            background-color: var(--color-darkred);
            color: var(--color-white)
        }
      
       #forgetPassword {
            font-size: 12px;
            margin-top: 20px;
            color: #ffffff95;
       }
       body{
            background-image: linear-gradient(rgba(0, 0, 0, 0.604), rgba(0, 0, 0, 0.649)),url("../../assets/films-montage.jpeg") !important;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
       }
       .link-register{
            margin-top: 50px;
            display: flex;
            flex-direction: row;
            align-items: baseline;
       }
       #register-text{
            font-size: 14px;
            color: #ffffff72;
       }
       #register{
            font-size: 13px;
            color: var(--color-white);
            padding-left: 5px;
       }
</style>
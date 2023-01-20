<template>
     <div>
            <div class="d-flex justify-content-end p-5">
                <button class="btn btn-dark ">Mes séances</button>
            </div>
            <div class="card card-session shadow-sm">
                 <div>
                    <h3 class="pt-3">Séance</h3>
                    <hr>
                </div>
                <div class="card-body">
                        <div class="form-group">
                            <input type="name" name="email" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group mt-3">
                            <input type="date" name="email" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group mt-3">
                            <input type="time" name="email" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="form-group mt-3">
                            <input type="number" placeholder="12,30 €" class="form-control" autocomplete="email" required autofocus>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-danger mt-4" type="submit"><span>Enregistrer</span></button>
                        </div>  
                </div>
            </div>
    </div>
</template>

<script setup>

</script>

<style scoped>

h3, hr{
    color: var(--color-white);
}
.card-session {
    width: 80%;
    margin: 0 auto;
    margin-top: 10px;
    padding: 20px;
    background-color: #2f2f2f;
    color: var(--color-black);
    box-shadow: 20px;
    
}

</style>
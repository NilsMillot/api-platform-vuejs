<template>
    <div class="container mt-5">
        <div class="row">
            <div class="d-flex justify-content-between">

                <div class="btn-group mb-3">
                    <button type="button" class="btn btn-dark">Nouvelle séance</button>
                </div>
            </div>
            <div class="col-md-5">
                <ul class="list-group">
                    <li v-for="(session,index) in results.value" :key="index" @click="sessionSelected(session)" class="list-group-item list">
                        <h5>{{session.movie_title}}</h5>
                        <p class="p-date">{{session.sessionDatetime.split('T')[0]}}</p>
                    </li>
                </ul>
            </div>


            <div v-if="details.id" class="col-md-7">
                <div class="card card-session">
                    <div>
                        <h3 class="pt-3">Séance</h3>
                        <hr/>
                    </div>
                    <div class="card-body">
                        <div class="form-group mt-3">
                        <input
                            type="text"
                            class="form-control"
                            v-model="details.movie_title"
                            required
                            autofocus
                            disabled
                        />
                        </div>
                        <div class="form-group mt-3">
                        <input
                            type="date"
                            class="form-control"
                            v-model="details.date"
                            required
                            autofocus
                        />
                        </div>
                        <div class="form-group mt-3">
                        <input
                            type="time"
                            class="form-control"
                            v-model="details.time"
                            required
                            autofocus
                        />
                        </div>
                        <div class="form-group mt-3">
                        <input
                            type="number"
                            placeholder="12,30 €"
                            v-model="details.price"
                            class="form-control"
                            required
                            autofocus
                        />
                        </div>

                        <div class="form-group mt-3">
                        <select v-model="details.room" class="form-select">
                            <option value="1">Salle 1</option>
                            <option value="2">Salle 2</option>
                            <option value="2">Salle 3</option>
                        </select>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                        <button
                            class="btn btn-danger "
                            type="submit"
                            @click.prevent="handleSubmit"
                        >
                        <span>Enregistrer</span>
                        </button>
                        <button
                            class="btn btn-danger mx-2"
                            type="submit"
                            @click.prevent="handleDelete"
                        >
                        <span>Supprimer</span>
                        </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
</template>


<script setup>
import { onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();
const results = reactive({value:[]})
const details = reactive({
    id:'',
    price:'',
    room:'',
    date:'',
    time:'',
    movie_id:'',
    movie_title:''

});

onMounted( async () =>{
    await fetchSessions();
});

const sessionSelected = (session) => {
    details.id = session.id;
    details.movie_title = session.movie_title;
    details.date = session.sessionDatetime.split('T')[0]
    details.price = session.price;
    details.time = (session.sessionDatetime.split('T')[1]).substr(0, 5)
    details.room = session.room;
    details.movie_id = session.movie_id;
}

const handleDelete = () => {
    const requestOptions = {
        method: "DELETE"
    };
    fetch(`https://localhost/movie_screenings/${details.id}`, requestOptions).then((response) =>
        console.log(response)
    );
}

const handleSubmit = () => {
    const requestOptions = {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      sessionDatetime: new Date(new Date(details.date + " " +  details.time)),
      price: details.price,
      room:details.room,
      movieId: details.movie_id,
      movieTitle: details.movie_title
    }),
  };
  fetch(`https://localhost/movie_screenings/${details.id}`, requestOptions).then((response) =>
    console.log(response.json())
  );
}

const fetchSessions = async () => {
  return fetch("https://localhost/movie_screenings")
    .then((response) => response.json())
    .then(
      (data) =>
        (results.value = data["hydra:member"])
    );
};

</script>

<style scoped>

.list {
    background-color: #2f2f2f;
    color:white
}

.p-date{
    font-size: 14px;
}

.list:hover {
    border-left: 2px solid var(--color-darkred);
}

.card-session {
  padding: 20px;
  background-color: #2f2f2f;
  color: var(--color-white);
  box-shadow: 20px;
}
</style>
<template>
  <nav class="navbar navbar-expand-lg navbar-dark px-5">
    <a class="navbar-brand logo" href="/">CINEMAX</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
            <a class="nav-link" href="/">Découvrir</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/session">Cinéma</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="#">Quizz</a>
            </li>

            <li class="nav-item">
            <a class="nav-link" href="/contact  ">Contact</a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/register">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/login">Connexion</a>
            </li>
        </ul>
            
        </div>
    </nav>
</template>

<style scoped>
.logo {
  color: var(--color-red);
}

nav {
  background-color: var(--color-grey);
}

nav div a {
  color: var(--color-white);
  font-size: 14px;
}

nav a:hover {
  color: var(--color-red);
}
</style>

export function getImageFromSrc(src) {
  return `https://image.tmdb.org/t/p/original/${src}`;
}

export function getUrlDiscoverMovieFromGenre(genreId) {
  return `https://api.themoviedb.org/3/discover/movie?api_key=${
    import.meta.env.VITE_TMDB_API_KEY
  }&with_genres=${genreId}&language=fr`;
}

export function getUrlDiscoverTVWithNetwork(networkId) {
  return `https://api.themoviedb.org/3/discover/tv?api_key=${
    import.meta.env.VITE_TMDB_API_KEY
  }&with_networks=${networkId}&language=fr`;
}

export function getUrlTrendingAllWeek() {
  return `https://api.themoviedb.org/3/trending/all/week?api_key=${
    import.meta.env.VITE_TMDB_API_KEY
  }`;
}

// TODO: Use this function in the app instead of doing fetch everywhere when we need to get data from TMDB
export function getMoviesDiscoverFromGenre(genreId) {
  return fetch(
    `https://api.themoviedb.org/3/discover/movie?api_key=${
      import.meta.env.VITE_TMDB_API_KEY
    }&with_genres=${genreId}&language=fr`
  ).then((res) => res.json());
}

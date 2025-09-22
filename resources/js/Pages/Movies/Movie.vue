<script setup>
    import MovieDetails from "@/components/MovieDetails.vue";
import { ref, onMounted } from "vue";

    const movie = ref(null);
    const id = 132493;
    const imagePath = "https://image.tmdb.org/t/p/w185";

    const fetchData = async () => {
        try {
           const res = await axios.get(route("movies.getById", id)); 
           movie.value = res.data;
           console.log("movie: ", movie.value);
        } catch (error) {
            console.error("Failed to fetch data: ", error); 
        }
    }

    onMounted(fetchData);
</script>
<template>
    <div class="items-center  w-full">
        <div v-if="movie" class="flex items-center gap-8 w-full justify-center mt-10">
            <img 
                :src="`${imagePath}/${movie.poster_path}`" 
            />
            <div class="w-1/2">
                <h1 class="text-2xl mb-2">{{ movie.original_title }}</h1>
                <p>{{ movie.overview }}</p>
            </div>
        </div>
        <div v-else>
            <p>Loading...</p>
        </div>
        <MovieDetails :movieItem="movie" />
    </div>
</template>
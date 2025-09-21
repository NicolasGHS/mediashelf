<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { ref, onMounted } from "vue";
    import { Link } from '@inertiajs/vue3';


    const query = ref("");
    const movies = ref([]);
    const imageConfig = ref(null);
    // TODO: make dynamic
    const imagePath = "https://image.tmdb.org/t/p/w92/";


    const submit = async () => {
        try {
            const res = await axios.get(route("movies.search"), {
                params: {query: query.value }
            })
            movies.value = res.data.results;
        } catch (error) {
            console.error("error fetching movies: ", error);
        }
    }

    const fetchImageConfig = async () => {
        try {
            const res = await axios.get(route("movies.imagePath"));
            imageConfig.value = res.data;
        } catch (error) {
            console.error("error fetching image path:", error);
        }
    }

    onMounted(fetchImageConfig);
</script>
<template>
    <h2>Search Movie</h2>
    <form @submit.prevent="submit">
        <div>
            <InputLabel value="name" />

            <div class="flex items-center gap-2">

            <TextInput 
                v-model="query"
                id="name" 
                class="mt-1 block w-full"
                required
                autofocus
            />

            <button class="border p-1 rounded">
                Search
            </button>
            </div>
        </div>
    </form>

    <div>
        <h2>Search Results:</h2>
        <ul>
            <li v-for="movie in movies" :key="movie.id" class="flex gap-1 mb-2 border rounded p-1">
                <Link :href="route('movie', movie.id)" class="flex gap-2">
                    <img 
                        v-if="imageConfig" 
                        :src="`${imagePath}/${movie.poster_path}`" 
                        alt="poster"
                        class="w-20 rounded"
                    />
                    <div>
                        <p class="text-black">{{ movie.title }}</p>
                        <p class="text-black">{{ movie.release_date }}</p>
                    </div>
                </Link>
            </li>
        </ul>
    </div>
</template>
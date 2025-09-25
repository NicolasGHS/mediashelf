<script setup>
    import { ref, onMounted } from "vue";
    import { Link } from '@inertiajs/vue3';
    import { Button } from 'primevue';
    import InputText from 'primevue/inputtext';
    import Card from 'primevue/card';


    const query = ref("");
    const movies = ref();
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
    <div class="space-y-4">
        <Card>
            <template #title>
                <h2>Search Movie</h2>
            </template>
            <template #content>
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="flex flex-col gap-2">
                        <label for="name" class="font-medium">Movie Name</label>
                        <div class="flex items-center gap-2">
                            <InputText 
                                v-model="query"
                                id="name" 
                                class="flex-1"
                                placeholder="Enter movie name..."
                                required
                                autofocus
                            />
                            <Button 
                                type="submit"
                                label="Search"
                                severity="primary"
                            />
                        </div>
                    </div>
                </form>
            </template>
        </Card>

        <Card v-if="movies">
            <template #title>
                <h2>Search Results</h2>
            </template>
            <template #content>
                <div class="space-y-3">
                    <div v-for="movie in movies" :key="movie.id" class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                        <Link :href="route('movie', movie.id)" class="flex gap-3 p-3 hover:bg-gray-50">
                            <img 
                                v-if="imageConfig" 
                                :src="`${imagePath}/${movie.poster_path}`" 
                                alt="poster"
                                class="w-20 rounded"
                            />
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ movie.title }}</p>
                                <p class="text-gray-600">{{ movie.release_date }}</p>
                            </div>
                        </Link>
                    </div>
                </div>
            </template>
        </Card>
    </div>
</template>
<script setup>
    import { ref, onMounted } from "vue";
    import { Link } from '@inertiajs/vue3';
    import { Button } from 'primevue';
    import InputText from 'primevue/inputtext';
    import Card from 'primevue/card';
    import Paginator from 'primevue/paginator';


    const query = ref("");
    const movies = ref();
    const imageConfig = ref(null);
    const currentPage = ref(1);
    const totalResults = ref(0);
    const totalPages = ref(0);
    const resultsPerPage = 20; // TMDB returns 20 results per page by default
    // TODO: make dynamic
    const imagePath = "https://image.tmdb.org/t/p/w92/";


    const submit = async () => {
        currentPage.value = 1; // Reset to first page on new search
        await searchMovies(1);
    }

    const searchMovies = async (page = 1) => {
        try {
            const res = await axios.get(route("movies.search"), {
                params: {
                    query: query.value,
                    page: page
                }
            })
            movies.value = res.data.results;
            totalResults.value = res.data.total_results;
            totalPages.value = res.data.total_pages;
            currentPage.value = page;
        } catch (error) {
            console.error("error fetching movies: ", error);
        }
    }

    const onPageChange = (event) => {
        searchMovies(event.page + 1); // PrimeVue paginator is 0-based, API is 1-based
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
                <div class="flex justify-between items-center">
                    <h2>Search Results</h2>
                    <span class="text-sm text-gray-500">{{ totalResults }} results found</span>
                </div>
            </template>
            <template #content>
                <div class="space-y-4">
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
                    
                    <Paginator 
                        v-if="totalPages > 1"
                        :first="(currentPage - 1) * resultsPerPage"
                        :rows="resultsPerPage"
                        :totalRecords="totalResults"
                        @page="onPageChange"
                        template="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink RowsPerPageDropdown CurrentPageReport"
                        :currentPageReportTemplate="`Page ${currentPage} of ${totalPages}`"
                    />
                </div>
            </template>
        </Card>
    </div>
</template>
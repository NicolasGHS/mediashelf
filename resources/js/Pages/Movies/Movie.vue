<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import MovieDetails from "@/components/MovieDetails.vue";
    import { ref, onMounted } from "vue";
import WatchStatus from '@/components/WatchStatus.vue';

    const props = defineProps({
        movieId: Number
    });

    const movie = ref(null);
    const status = ref(null);
    const imagePath = "https://image.tmdb.org/t/p/w185";

    

    const fetchData = async () => {
        try {
           const res = await axios.get(route("movies.getById", props.movieId)); 
           movie.value = res.data;
           console.log("movie: ", movie.value);
        } catch (error) {
            console.error("Failed to fetch data: ", error); 
        }
    }

    const getStatus = async () => {
        try {
            const res = await axios.get(route("movies.getStatus", props.movieId));    
            console.log("status response: ", res);
            status.value = res.data.status;
        } catch (error) {
            console.error("failed to fetch status: ", error); 
        }
    }

    const handleStatusChange = async (data) => {
        try {
            const res = await axios.put(route("movies.updateStatus", data.movieId), {
                status: data.status
            });
            
            if (res.data.success) {
                // Update the local status value
                status.value = data.status;
                console.log("Status updated successfully:", res.data);
            } else {
                console.error("Failed to update status:", res.data);
            }
        } catch (error) {
            console.error("Error updating status:", error);
        }
    }

    onMounted(fetchData);
    onMounted(getStatus);
</script>
<template>
    <Head title="Movie Details" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Movie Details
            </h2>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div v-if="movie" class="flex items-start gap-8 w-full">
                            <div class="flex flex-col items-center">
                                <img 
                                    :src="`${imagePath}/${movie.poster_path}`" 
                                    :alt="movie.original_title"
                                    class="rounded-lg shadow-md mb-3"
                                />
                                <WatchStatus 
                                    :status="status" 
                                    :movieId="props.movieId"
                                    @statusChanged="handleStatusChange" 
                                />
                            </div>
                            <div class="flex-1">
                                <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ movie.original_title }}</h1>
                                <p class="text-gray-600 leading-relaxed mb-6">{{ movie.overview }}</p>
                                <MovieDetails :movieItem="movie" />
                            </div>
                        </div>
                        <div v-else class="text-center py-8">
                            <p class="text-gray-500">Loading movie details...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
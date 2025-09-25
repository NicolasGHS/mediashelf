<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    movie: {
        type: Object,
        required: true
    },
    imagePath: {
        type: String,
        default: "https://image.tmdb.org/t/p/w92/"
    }
});
</script>

<template>
    <div class="border rounded-lg overflow-hidden hover:shadow-md transition-shadow">
        <Link :href="route('movie', movie.tmdb_id)" class="flex gap-3 p-3 hover:bg-gray-50">
            <img 
                :src="`${imagePath}/${movie.poster_path}`" 
                :alt="movie.title"
                class="w-20 rounded"
            />
            <div class="flex-1">
                <p class="font-semibold text-gray-900">{{ movie.title }}</p>
                <p class="text-gray-600">{{ movie.release_date }}</p>
            </div>
        </Link>
    </div>
</template>
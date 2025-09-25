<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    watchedMovies: {
        type: Array,
        default: () => []
    },
    wantToWatchMovies: {
        type: Array,
        default: () => []
    }
});

const activeTab = ref('want-to-watch');
</script>

<template>
    <Head title="My Watchlist" />
    
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                My Watchlist
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Tab Navigation -->
                <div class="mb-8">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <button
                            @click="activeTab = 'want-to-watch'"
                            :class="[
                                activeTab === 'want-to-watch'
                                    ? 'border-indigo-500 text-indigo-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                'whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm'
                            ]"
                        >
                            Want to Watch ({{ wantToWatchMovies.length }})
                        </button>
                        <button
                            @click="activeTab = 'watched'"
                            :class="[
                                activeTab === 'watched'
                                    ? 'border-indigo-500 text-indigo-600'
                                    : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                                'whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm'
                            ]"
                        >
                            Watched ({{ watchedMovies.length }})
                        </button>
                    </nav>
                </div>

                <!-- Want to Watch Tab -->
                <div v-show="activeTab === 'want-to-watch'" class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Movies I Want to Watch</h3>
                        <div v-if="wantToWatchMovies.length === 0" class="text-gray-500 text-center py-8">
                            No movies in your watchlist yet.
                        </div>
                        <ul v-else class="divide-y divide-gray-200">
                            <li v-for="movie in wantToWatchMovies" :key="movie.tmdb_id" class="py-3">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ movie.title || 'Untitled Movie' }}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Watched Tab -->
                <div v-show="activeTab === 'watched'" class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Movies I've Watched</h3>
                        <div v-if="watchedMovies.length === 0" class="text-gray-500 text-center py-8">
                            No watched movies yet.
                        </div>
                        <ul v-else class="divide-y divide-gray-200">
                            <li v-for="movie in watchedMovies" :key="movie.tmdb_id" class="py-3">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ movie.title || 'Untitled Movie' }}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
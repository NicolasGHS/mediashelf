<script setup>
defineProps(["movieItem"])
</script>

<template>
    <div v-if="movieItem" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="font-semibold text-gray-700 mb-2">Origin Country</p>
            <ul class="flex gap-2">
                <li v-for="country in movieItem.origin_country" :key="country" 
                    class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">
                    {{ country }}
                </li>
            </ul>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="font-semibold text-gray-700 mb-2">Language</p>
            <p class="text-gray-600">{{ movieItem.original_language?.toUpperCase() }}</p>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="font-semibold text-gray-700 mb-2">Release Date</p>
            <p class="text-gray-600">{{ movieItem.release_date }}</p>
        </div>
        
        <div class="bg-gray-50 p-4 rounded-lg">
            <p class="font-semibold text-gray-700 mb-2">Duration</p>
            <p class="text-gray-600">{{ movieItem.runtime }} minutes</p>
        </div>
    </div> 
</template>
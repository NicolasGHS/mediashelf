<script setup>
defineProps(["movieItem"])
</script>

<template>
    <div v-if="movieItem">
        <div class="mb-3">
            <p>From</p>
            <ul class="flex gap-1">
                <li v-for="country in movieItem.origin_country">
                    <p>{{ country }}</p>
                </li>
            </ul>
        </div>
        <div class="mb-3">
            <p>Language</p>
            <p>{{ movieItem.original_language }}</p>
        </div>
        <div class="mb-3">
            <p>Release Date</p>
            <p>{{ movieItem.release_date }}</p>
        </div>
        <div class="mb-3">
            <p>Duration</p>
            <p>{{ movieItem.runtime }}</p>
        </div>
    </div> 
</template>
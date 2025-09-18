<script setup>
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import { ref } from "vue";

    const query = ref("");
    const movies = ref([]);

    console.log("movies: ", movies);

    const submit = async () => {
        try {
            const res = await axios.get(route("movies.search"), {
                params: {query: query.value }
            })
            console.log("response: ", res);
            movies.value = res.data.results;
        } catch (error) {
            console.error("error fetching movies: ", error);
        }
    }
</script>
<template>
    <h2>Search Movie</h2>
    <form @submit.prevent="submit">
        <div>
            <InputLabel value="name" />

            <TextInput 
                v-model="query"
                id="name" 
                class="mt-1 block w-full"
                required
                autofocus
            />

            <PrimaryButton />
        </div>
    </form>

    <div>
        <h2>Search Results:</h2>
        <ul>
            <li v-for="movie in movies" :key="movie.id">
                {{ movie.title }}
            </li>
        </ul>
    </div>
</template>
<script setup>
    import { ref, onMounted } from "vue";

    const movie = ref();
    const id = 132493;

    const fetchData = async () => {
        try {
           const res = await axios.get(route("movies.getById", id)); 
           movie.value = res.data;
           console.log("movie: ", movie.value.data);
        } catch (error) {
            console.error("Failed to fetch data: ", error); 
        }
    }

    onMounted(fetchData);
</script>
<template>
    <h1 class="text-2xl">{{ movie.original_title }}</h1>
</template>
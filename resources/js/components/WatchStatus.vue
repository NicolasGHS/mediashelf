<script setup>
import Select from 'primevue/select';

const props = defineProps(['status']);
const options = ["Want to watch", "Watched"];

</script>
<template>
    <Select :options="options" :placeholder="props.status"  />
</template>
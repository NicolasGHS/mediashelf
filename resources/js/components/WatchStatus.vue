<script setup>
import Select from 'primevue/select';
import { ref, computed } from 'vue';

const props = defineProps(['status', 'movieId']);
const emit = defineEmits(['statusChanged']);

const options = ["Want to watch", "Watched"];

// Convert database status to display format
const displayStatus = computed(() => {
    if (props.status === 'want_to_watch') return 'Want to watch';
    if (props.status === 'watched') return 'Watched';
    return props.status;
});

const selectedStatus = ref(displayStatus.value);

const handleStatusChange = (newStatus) => {
    selectedStatus.value = newStatus;
    
    // Convert display format back to database format
    const dbStatus = newStatus === 'Want to watch' ? 'want_to_watch' : 'watched';
    
    // Emit event to parent component
    emit('statusChanged', {
        movieId: props.movieId,
        status: dbStatus
    });
};

</script>
<template>
    <Select 
        :options="options" 
        v-model="selectedStatus"
        :placeholder="displayStatus || 'Select status'"
        @change="handleStatusChange"
    />
</template>
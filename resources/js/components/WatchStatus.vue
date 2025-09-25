<script setup>
import Select from 'primevue/select';
import { ref, computed, watch } from 'vue';

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

watch(displayStatus, (newDisplayStatus) => {
    selectedStatus.value = newDisplayStatus;
});

const handleStatusChange = (event) => {
    // PrimeVue Select passes an event object, we need the value
    const newStatus = event.value || event;
    selectedStatus.value = newStatus;
    
    // Convert display format back to database format
    let dbStatus;
    if (newStatus === 'Want to watch') {
        dbStatus = 'want_to_watch';
    } else if (newStatus === 'Watched') {
        dbStatus = 'watched';
    } else {
        console.error('Unknown status:', newStatus);
        return;
    }
    
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
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import AddMovieForm from '@/components/AddMovieForm.vue';
import Card from 'primevue/card';
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <Card class="shadow-sm">
                    <template #content>
                        <AddMovieForm />
                    </template>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

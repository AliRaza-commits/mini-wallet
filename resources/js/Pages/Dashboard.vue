<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const { props } = usePage();
const username = props?.auth?.user?.name;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">Welcome, {{ username }}</div>
                </div>
                <div class="bg-white mt-2 shadow-lg rounded-lg p-6 flex items-center space-x-4">
                    <img src="/logo.png" alt="Logo" class="h-20 w-20 object-contain" />
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Great Mini Wallet</h2>
                        <p class="text-gray-600 mt-1">Your personal finance companion — simple, secure, and smart.</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

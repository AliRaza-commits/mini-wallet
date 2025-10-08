<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white"
    >
        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                >Dashboard</Link>

            <template v-else>
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Log in</Link>

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ms-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Register</Link
                >
            </template>
        </div>
         <!-- Hero Section -->
        <section class="flex flex-col items-center justify-center min-h-screen px-6 text-center bg-gradient-to-br from-indigo-500 to-purple-600 text-white">
            <img src="/logo.png" alt="Logo" class="h-24 mb-6" />
            <h1 class="text-4xl font-extrabold mb-4">Great Mini Wallet</h1>
            <p class="text-lg max-w-xl mb-6">Manage your money effortlessly. Track balances, send payments, and stay in control — all in one place.</p>
            <a href="#features" class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-full shadow hover:bg-gray-100 transition">Explore Features</a>
        </section>

        <!-- Features Section -->
        <section id="features" class="py-16 px-6 max-w-6xl mx-auto">
            <h2 class="text-3xl font-bold text-center mb-10">Why You'll Love It</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-xl font-semibold mb-2">💰 Instant Balance</h3>
                <p>View your wallet balance in real-time with secure syncing across devices.</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-xl font-semibold mb-2">🔐 Secure Payments</h3>
                <p>Send and receive money with end-to-end encryption and fraud protection.</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6 text-center">
                <h3 class="text-xl font-semibold mb-2">📊 Smart Insights</h3>
                <p>Track spending trends and get personalized tips to improve your finances.</p>
            </div>
            </div>
        </section>

        <!-- Call to Action -->
        <section class="py-16 px-6 text-center bg-indigo-600 text-white">
            <h2 class="text-3xl font-bold mb-4">Ready to simplify your wallet?</h2>
            <p class="mb-6">Sign up today and take control of your financial future.</p>
            <a href="/register" class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-full shadow hover:bg-gray-100 transition">Get Started</a>
        </section>
    </div>
     <!-- Footer -->
    <footer class="w-full py-6 text-center text-sm text-gray-500">
        &copy; 2025 Great Mini Wallet. All rights reserved.
    </footer>

</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>

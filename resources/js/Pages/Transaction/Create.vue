<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import axios from 'axios';import { watch } from 'vue';
import Swal from 'sweetalert2'

const receiverId = ref('');
const amount = ref('');
const loading = ref(false);
const error = ref('');
const success = ref('');

// Validation
const isReceiverValid = computed(() => receiverId.value && receiverId.value > 0);
const isAmountValid = computed(() => amount.value && parseFloat(amount.value) > 0);
const isFormValid = computed(() => isReceiverValid.value && isAmountValid.value);

const sendMoney = async () => {
  if (!isFormValid.value) {
    Swal.fire({
      title: "Transaction Issue",
      text: "Please fill out all fields correctly.",
      icon: "warning"
    });
    return;
  }

  error.value = '';
  success.value = '';
  loading.value = true;

  try {
    await axios.get('/sanctum/csrf-cookie');
    await axios.post('/api/transactions', {
      receiver_id: receiverId.value,
      amount: parseFloat(amount.value),
    }, { withCredentials: true });

    success.value = 'Transaction sent successfully!';
    Swal.fire({
      title: "Transaction Status",
      text: "Transaction sent successfully!",
      icon: "success"
    });
    receiverId.value = '';
    amount.value = '';
  } catch (err) {
    error.value = err.response?.data?.message || 'Something went wrong.';
    Swal.fire({
      title: "Transaction Issue",
      text: err.response?.data?.message || 'Something went wrong.',
      icon: "warning"
    });
  } finally {
    loading.value = false;
  }
};

function formatCurrency(value) {
  const num = parseFloat(value.replace(/[^0-9.]/g, ''));
  return isNaN(num) ? '' : num.toLocaleString('en-US', {
    style: 'currency',
    currency: 'USD',
    minimumFractionDigits: 2,
  });
}
</script>

<template>
  <Head title="Create Transaction" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Create Transaction
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
          <form @submit.prevent="sendMoney" class="space-y-4">
            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Receiver ID</label>
              <input
                v-model="receiverId"
                type="number"
                placeholder="Enter Receiver ID"
                required
                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm"
              />
            </div>

            <div>
              <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Amount</label>
              <input
                v-model="amount"
                type="number"
                placeholder="Enter Amount"
                required
                class="mt-1 block w-full border-gray-300 dark:border-gray-600 rounded-md shadow-sm"
              />
            </div>

            <button
              type="submit"
              :disabled="loading"
              class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 disabled:opacity-50"
            >
              {{ loading ? 'Sending...' : 'Send Money' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
<style>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}
</style>
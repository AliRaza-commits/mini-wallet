<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { AgGridVue } from 'ag-grid-vue3';
import { ModuleRegistry, AllCommunityModule } from 'ag-grid-community';

// Register all Community features
ModuleRegistry.registerModules([AllCommunityModule]);

const { props } = usePage();
const userId = props.auth.user.id;
const transactions = ref([]);
const balance = ref(0);
const error = ref('');
const loading = ref(false);
const gridApi = ref(null);
const ready = ref(false);

const columnDefs = [
  { headerName: 'Sender Email', field: 'sender.email' },
  { headerName: 'Receiver Email', field: 'receiver.email' },
  { headerName: 'Amount', field: 'amount' },
];


const datasource = {
  async getRows(params) {
    try {
      const page = params.startRow / 5 + 1 // cacheBlockSize = 5
      await axios.get('/sanctum/csrf-cookie')
      const response = await axios.get(`/api/transactions?page=${page}&per_page=5`, {
        withCredentials: true
      })

      const rows = response.data.transactions.data;
      const totalRows = response.data.transactions.total;
      balance.value = response.data.balance;

      params.successCallback(rows, totalRows)
    } catch (err) {
      console.error('Failed to fetch rows:', err)
      params.failCallback()
    }
  }
}
const onGridReady = (params) => {
  gridApi.value = params.api;
};

onMounted(() => {
  window.Echo.private(`user.${userId}`)
    .listen('.transaction.created', (e) => {
      alert('Alert: Trasaction Updated');
      transactions.value.unshift(e.transaction);
      // Refresh AG Grid
      if (gridApi.value) {
        gridApi.value.refreshInfiniteCache();
      }
    });
});
</script>

<template>
  <Head title="Transaction History" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Transaction History
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
          <div v-if="loading" class="text-gray-500 dark:text-gray-400">Loading transactions...</div>
          <div v-else>
            <div class="mb-4">
              <h3 class="text-lg font-medium text-gray-700 dark:text-gray-300">
                Current Balance: <span class="font-bold text-green-600 dark:text-green-400">{{ (balance || 0).toFixed(3) }}</span>
              </h3>
            </div>

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white dark:bg-gray-800 p-6 shadow sm:rounded-lg">
                  <div v-if="loading" class="text-gray-500 dark:text-gray-400">Loading transactions...</div>
                  <AgGridVue
                    class="ag-theme-alpine"
                    :row-model-type="'serverSide'"
                    :pagination="true"
                    @grid-ready="onGridReady"
                    :columnDefs="columnDefs"
                    :datasource="datasource"
                    :rowModelType="'infinite'"
                    :pagination-page-size-selector=[10,15,20]
                    :pagination-page-size="10"
                    :cacheBlockSize="5"
                    :maxBlocksInCache="2"
                    style="width: 100%; height: 400px;"
                    />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
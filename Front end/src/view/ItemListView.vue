<template>
    <div>
      <h1>Daftar Item</h1>
      <div class="action-bar">
        <router-link to="/items/create" class="button primary">
          Tambah Item Baru
        </router-link>
      </div>
  
      <div v-if="loading" class="loading-message">Loading items...</div>
  
      <div v-if="error" class="error-message">
        <strong>Error!</strong>
        <span> {{ error }}</span>
      </div>
  
      <div v-if="!loading && !error && items.length > 0" class="table-container">
        <table>
          <thead>
            <tr>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Supplier</th>
              <th class="text-right">Harga</th>
              <th class="text-right">Stok</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in items" :key="item.id">
              <td>{{ item.name }}</td>
              <td>{{ item.category?.name ?? 'N/A' }}</td>
              <td>{{ item.supplier?.name ?? 'N/A' }}</td>
              <td class="text-right">Rp {{ formatPrice(item.price) }}</td>
              <td class="text-right">{{ item.quantity }}</td>
              <td class="text-center">
                <button @click="viewItem(item.id)" class="button small secondary">View</button>
                <button @click="editItem(item.id)" class="button small warning">Edit</button>
                <button @click="deleteItem(item.id)" class="button small danger">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
         </div>
  
       <div v-if="!loading && !error && items.length === 0" class="empty-state">
        Belum ada item.
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import apiClient from '@/services/api'; // Import instance Axios
  import { useRouter } from 'vue-router'; // Import useRouter
  
  const items = ref([]); // State untuk menyimpan daftar item
  const loading = ref(true); // State untuk status loading
  const error = ref(null); // State untuk pesan error
  const router = useRouter(); // Dapatkan instance router
  
  // Fungsi untuk mengambil data item dari API
  const fetchItems = async () => {
    loading.value = true;
    error.value = null;
    try {
      // Panggil endpoint GET /api/items
      const response = await apiClient.get('/items');
      // Asumsi backend mengembalikan data dalam format { data: [...] } jika ada paginasi
      // Jika tidak, mungkin langsung response.data
      items.value = response.data.data || response.data; // Sesuaikan berdasarkan struktur respons API
    } catch (err) {
      console.error("Error fetching items:", err);
      error.value = 'Gagal mengambil data item. Coba lagi nanti.';
      if (err.response) {
          // Handle error spesifik dari server (misal: 401, 403, 404)
          error.value += ` (Status: ${err.response.status})`;
      }
    } finally {
      loading.value = false;
    }
  };
  
  // Fungsi format harga (contoh sederhana)
  const formatPrice = (value) => {
    if (!value) return '0.00';
    return parseFloat(value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
  };
  
  // Fungsi navigasi (contoh)
  const viewItem = (id) => {
    router.push({ name: 'ItemDetail', params: { id } }); // Asumsi ada route ItemDetail
  };
  const editItem = (id) => {
     router.push({ name: 'ItemEdit', params: { id } }); // Asumsi ada route ItemEdit
  };
  const deleteItem = async (id) => {
      if (confirm('Apakah Anda yakin ingin menghapus item ini?')) {
          try {
              loading.value = true; // Mungkin tampilkan loading indicator kecil
              await apiClient.delete(`/items/${id}`);
              // Refresh data setelah delete berhasil
              await fetchItems();
              alert('Item berhasil dihapus.');
          } catch (err) {
               console.error("Error deleting item:", err);
               alert('Gagal menghapus item.');
               error.value = 'Gagal menghapus item.';
          } finally {
               loading.value = false;
          }
      }
  };
  
  
  // Panggil fetchItems saat komponen dimuat
  onMounted(() => {
    fetchItems();
  });
  </script>
  
  <style scoped>
  /* Styling spesifik untuk view ini menggunakan CSS biasa */
  
  .action-bar {
      text-align: right;
      margin-bottom: 1rem;
  }
  
  .button {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      text-decoration: none; /* For router-link used as button */
      display: inline-block;
  }
  
  .button.primary {
      background-color: #22c55e; /* green-500 */
      color: white;
  }
  .button.primary:hover {
      background-color: #16a34a; /* green-700 */
  }
  
  .button.secondary {
      background-color: #3b82f6; /* blue-500 */
      color: white;
  }
  .button.secondary:hover {
      background-color: #2563eb; /* blue-700 */
  }
  
  .button.warning {
      background-color: #f59e0b; /* yellow-500 */
      color: white;
  }
  .button.warning:hover {
      background-color: #d97706; /* yellow-700 */
  }
  
  .button.danger {
      background-color: #ef4444; /* red-500 */
      color: white;
  }
  .button.danger:hover {
      background-color: #dc2626; /* red-700 */
  }
  
  .button.small {
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem; /* text-xs */
      margin-right: 0.25rem;
  }
  .button.small:last-child {
      margin-right: 0;
  }
  
  
  .loading-message {
      text-align: center;
      padding: 1rem;
  }
  
  .error-message {
      background-color: #fee2e2; /* red-100 */
      border: 1px solid #f87171; /* red-400 */
      color: #b91c1c; /* red-700 */
      padding: 0.75rem 1rem;
      border-radius: 0.25rem;
      margin-bottom: 1rem;
  }
  
  .table-container {
      overflow-x: auto;
      background-color: white;
      border-radius: 0.25rem;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1); /* shadow */
  }
  
  table {
      width: 100%;
      border-collapse: collapse;
      min-width: 600px; /* Ensure minimum width */
  }
  
  thead tr {
      background-color: #e5e7eb; /* gray-200 */
      color: #4b5563; /* gray-600 */
      text-transform: uppercase;
      font-size: 0.875rem; /* text-sm */
      line-height: 1.5; /* leading-normal */
  }
  
  th, td {
      padding: 0.75rem 1.5rem; /* py-3 px-6 */
      text-align: left;
      border-bottom: 1px solid #e5e7eb; /* border-gray-200 */
  }
  
  tbody tr:hover {
      background-color: #f3f4f6; /* hover:bg-gray-100 */
  }
  
  tbody td {
      color: #4b5563; /* gray-600 */
      font-size: 0.875rem; /* text-sm */
      font-weight: normal; /* font-light */
  }
  
  .text-right {
      text-align: right;
  }
  
  .text-center {
      text-align: center;
  }
  
  .empty-state {
      text-align: center;
      padding: 1rem;
      color: #6b7280; /* gray-500 */
  }
  </style>
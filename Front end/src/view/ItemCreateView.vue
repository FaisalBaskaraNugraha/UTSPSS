<template>
    <div>
      <h1>Tambah Item Baru</h1>
  
      <div v-if="errorMessage" class="error-message mb-4">
        <strong>Error!</strong>
        <span> {{ errorMessage }}</span>
      </div>
       <div v-if="successMessage" class="success-message mb-4">
        <strong>Sukses!</strong>
        <span> {{ successMessage }}</span>
      </div>
  
      <form @submit.prevent="submitForm" class="form-card">
        <div class="form-group">
          <label for="name">Nama Item:</label>
          <input
            type="text"
            id="name"
            v-model="item.name"
            required
            :class="{ 'input-error': errors.name }"
          />
           <p v-if="errors.name" class="error-text">{{ errors.name[0] }}</p>
        </div>
  
        <div class="form-group">
          <label for="description">Deskripsi:</label>
          <textarea
            id="description"
            v-model="item.description"
            rows="3"
          ></textarea>
        </div>
  
         <div class="form-group">
          <label for="price">Harga:</label>
          <input
            type="number"
            id="price"
            v-model.number="item.price"
            required
            min="0"
            step="0.01"
             :class="{ 'input-error': errors.price }"
          />
           <p v-if="errors.price" class="error-text">{{ errors.price[0] }}</p>
        </div>
  
         <div class="form-group">
          <label for="quantity">Kuantitas:</label>
          <input
            type="number"
            id="quantity"
            v-model.number="item.quantity"
            required
            min="0"
             :class="{ 'input-error': errors.quantity }"
          />
           <p v-if="errors.quantity" class="error-text">{{ errors.quantity[0] }}</p>
        </div>
  
         <div class="form-group">
          <label for="category">Kategori:</label>
          <select
            id="category"
            v-model="item.category_id"
            required
             :class="{ 'input-error': errors.category_id }"
          >
            <option disabled value="">Pilih Kategori</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
           <p v-if="errors.category_id" class="error-text">{{ errors.category_id[0] }}</p>
        </div>
  
        <div class="form-group">
          <label for="supplier">Supplier:</label>
          <select
            id="supplier"
            v-model="item.supplier_id"
            required
             :class="{ 'input-error': errors.supplier_id }"
          >
            <option disabled value="">Pilih Supplier</option>
            <option v-for="supplier in suppliers" :key="supplier.id" :value="supplier.id">
              {{ supplier.name }}
            </option>
          </select>
           <p v-if="errors.supplier_id" class="error-text">{{ errors.supplier_id[0] }}</p>
        </div>
  
          <div class="form-group">
          <label for="admin_id">Admin ID (Pembuat):</label>
          <input
            type="number"
            id="admin_id"
            v-model.number="item.admin_id"
            required
            min="1"
            placeholder="Masukkan ID Admin yang valid"
             :class="{ 'input-error': errors.admin_id }"
          />
           <p v-if="errors.admin_id" class="error-text">{{ errors.admin_id[0] }}</p>
        </div>
  
  
        <div class="form-actions">
          <button
            type="submit"
            :disabled="isSubmitting"
            class="button primary"
          >
            {{ isSubmitting ? 'Menyimpan...' : 'Simpan Item' }}
          </button>
           <router-link to="/items" class="button secondary-link">
              Batal
          </router-link>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, reactive, onMounted } from 'vue';
  import apiClient from '@/services/api';
  import { useRouter } from 'vue-router';
  
  const router = useRouter();
  const item = reactive({ // Gunakan reactive untuk objek form
    name: '',
    description: '',
    price: null,
    quantity: null,
    category_id: '',
    supplier_id: '',
    admin_id: 1, // Hardcode sementara, ganti dengan ID admin yg login
  });
  const categories = ref([]);
  const suppliers = ref([]);
  const isSubmitting = ref(false);
  const errorMessage = ref('');
  const successMessage = ref('');
  const errors = ref({}); // Untuk menyimpan error validasi dari backend
  
  // Fungsi untuk mengambil data kategori dan supplier
  const fetchDataForDropdowns = async () => {
    try {
      // Ambil semua kategori (tanpa paginasi, atau sesuaikan endpoint jika perlu)
      const catResponse = await apiClient.get('/categories?nopaging=true'); // Tambah param jika perlu
      categories.value = catResponse.data.data || catResponse.data;
  
      // Ambil semua supplier
      const supResponse = await apiClient.get('/suppliers?nopaging=true');
      suppliers.value = supResponse.data.data || supResponse.data;
    } catch (err) {
      console.error("Error fetching categories/suppliers:", err);
      errorMessage.value = "Gagal memuat data kategori/supplier.";
    }
  };
  
  // Fungsi submit form
  const submitForm = async () => {
    isSubmitting.value = true;
    errorMessage.value = '';
    successMessage.value = '';
    errors.value = {}; // Reset error validasi
  
    try {
      // Kirim data ke endpoint POST /api/items
      await apiClient.post('/items', item);
      successMessage.value = 'Item berhasil ditambahkan!';
      // Reset form setelah sukses
      Object.assign(item, {
          name: '', description: '', price: null, quantity: null,
          category_id: '', supplier_id: '', admin_id: 1
      });
      // Arahkan kembali ke daftar item setelah beberapa saat
      setTimeout(() => {
          router.push({ name: 'ItemList' });
      }, 1500);
  
    } catch (err) {
      console.error("Error submitting item:", err);
      if (err.response && err.response.status === 422) {
        // Tangani error validasi dari Laravel
        errors.value = err.response.data.errors;
        errorMessage.value = 'Terdapat kesalahan pada input Anda. Silakan periksa kembali.';
      } else {
        // Tangani error umum lainnya
        errorMessage.value = 'Gagal menyimpan item. Terjadi kesalahan pada server.';
         if (err.response) {
             errorMessage.value += ` (Status: ${err.response.status})`;
         }
      }
    } finally {
      isSubmitting.value = false;
    }
  };
  
  // Ambil data dropdown saat komponen dimuat
  onMounted(() => {
    fetchDataForDropdowns();
  });
  </script>
  
  <style scoped>
  /* Styling spesifik untuk view ini menggunakan CSS biasa */
  .form-card {
      background-color: white;
      padding: 1.5rem; /* p-6 */
      border-radius: 0.5rem; /* rounded */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* shadow-md */
  }
  
  .form-group {
      margin-bottom: 1rem; /* mb-4 */
  }
  
  .form-group label {
      display: block; /* block */
      color: #374151; /* gray-700 */
      font-size: 0.875rem; /* text-sm */
      font-weight: bold; /* font-bold */
      margin-bottom: 0.5rem; /* mb-2 */
  }
  
  .form-group input[type="text"],
  .form-group input[type="number"],
  .form-group textarea,
  .form-group select {
      box-shadow: 0 1px 3px rgba(0,0,0,0.1); /* shadow */
      appearance: none; /* appearance-none */
      border: 1px solid #d1d5db; /* border */
      border-radius: 0.25rem; /* rounded */
      width: 100%; /* w-full */
      padding: 0.5rem 0.75rem; /* py-2 px-3 */
      color: #374151; /* text-gray-700 */
      line-height: 1.25; /* leading-tight */
      outline: none; /* focus:outline-none */
  }
  
  .form-group input:focus,
  .form-group textarea:focus,
  .form-group select:focus {
       box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5); /* focus:shadow-outline (a basic blue glow) */
       border-color: #60a5fa; /* focus:border-blue-500 */
  }
  
  
  .input-error {
      border-color: #ef4444; /* border-red-500 */
  }
  
  .error-text {
      color: #ef4444; /* text-red-500 */
      font-size: 0.75rem; /* text-xs */
      font-style: italic;
      margin-top: 0.25rem;
  }
  
  .form-actions {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 1.5rem; /* mb-6 */
  }
  
  /* Inherit button styles from ItemListView or define here */
  .button {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      transition: opacity 0.2s ease; /* Transition for disabled state */
  }
  
  .button:disabled {
      opacity: 0.5;
      cursor: not-allowed;
  }
  
  .button.primary {
      background-color: #3b82f6; /* blue-500 */
      color: white;
  }
  .button.primary:hover:not(:disabled) {
      background-color: #2563eb; /* blue-700 */
  }
  
  .secondary-link {
      display: inline-block;
      vertical-align: baseline;
      font-weight: bold;
      font-size: 0.875rem; /* text-sm */
      color: #3b82f6; /* text-blue-500 */
      text-decoration: none;
  }
  .secondary-link:hover {
      color: #1e40af; /* hover:text-blue-800 */
  }
  
  
  /* Messages (Error/Success) */
  .error-message {
      background-color: #fee2e2; /* red-100 */
      border: 1px solid #f87171; /* red-400 */
      color: #b91c1c; /* red-700 */
      padding: 0.75rem 1rem;
      border-radius: 0.25rem;
      margin-bottom: 1rem;
  }
  
  .success-message {
      background-color: #d1fae5; /* green-100 */
      border: 1px solid #6ee7b7; /* green-400 */
      color: #065f46; /* green-700 */
      padding: 0.75rem 1rem;
      border-radius: 0.25rem;
      margin-bottom: 1rem;
  }
  </style>
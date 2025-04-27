import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import ItemListView from '../views/Items/ItemListView.vue';
import ItemCreateView from '../views/Items/ItemCreateView.vue';
import CategoryListView from '../views/Categories/CategoryListView.vue';
// ... import view lainnya
import StockSummaryView from '../views/Reports/StockSummaryView.vue';
import LowStockView from '../views/Reports/LowStockView.vue';

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/items', name: 'ItemList', component: ItemListView },
  { path: '/items/create', name: 'ItemCreate', component: ItemCreateView },
  { path: '/categories', name: 'CategoryList', component: CategoryListView },
  // ... definisikan rute lain untuk create category, suppliers, dll.
  { path: '/reports/stock-summary', name: 'StockSummary', component: StockSummaryView },
  { path: '/reports/low-stock', name: 'LowStock', component: LowStockView },
  // Rute fallback (404)
  // { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFoundView },
];

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL), // Gunakan history mode
  routes,
});

export default router;
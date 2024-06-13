import { createRouter, createWebHistory } from 'vue-router';
import HomePage from './pages/HomePage.vue';
import PurchasePage from './pages/PurchasePage.vue';
import ShopPage from './pages/ShopPage.vue';

const routes = [
  { path: '/', name: 'Home', component: HomePage },
  { path: '/purchases', name: 'Purchases', component: PurchasePage },
  { path: '/shops', name: 'Shops', component: ShopPage },
  { path: '/shops/:shopId', name: 'PurchasesByShop', component: PurchasePage }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
